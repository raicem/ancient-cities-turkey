import React, { useCallback, useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';
import { BrowserRouter, Route, Routes, useParams } from 'react-router-dom';
import Map, { Layer, Popup, Source } from 'react-map-gl/mapbox';
import axios from 'axios';
import { IntlProvider } from 'react-intl';
import messages from './messages';
import SidebarContainer from './components/Sidebar/SidebarContainer';
import AboutTr from './components/AboutTr';
import AboutEn from './components/AboutEn';
import FeaturePopup from './components/FeaturePopup';
import MapLegend from './components/MapLegend';
import { SITE_TYPE_MARKER_COLOR, SITE_TYPE_MARKER_ICON, SITE_TYPE_MARKER_SIZE } from './siteTypes';

const turkeyBounds = [
  [25.059009, 35.259924],
  [45.351057, 42.210808],
];

const mapStyle = 'mapbox://styles/mapbox/streets-v9';

function getLocale() {
  const languages = navigator.languages || [navigator.language || 'en'];

  return languages[0].substring(0, 2);
}

// Ruins list inlined by Blade (window.__INITIAL_RUINS__) so markers render
// without an API round-trip. Only usable when it matches the active locale;
// client-side language switches still fetch from the API.
function readInitialRuins(locale) {
  const initial = window.__INITIAL_RUINS__;

  if (initial && initial.locale === locale && Array.isArray(initial.data)) {
    return initial.data;
  }

  return null;
}

function App() {
  const { language: languageParam, ruin: ruinParam } = useParams();

  const defaultLanguage = languageParam || getLocale();

  const [ruins, setRuins] = useState(() => readInitialRuins(defaultLanguage) || []);
  const [selected, setSelected] = useState(null);
  const [cursor, setCursor] = useState('move');

  useEffect(() => {
    let active = true;

    const applyRuins = data => {
      if (active) {
        setRuins(data);
        setSelected(undefined);

        if (ruinParam) {
          const selectedRuin = data.find(item => item.slug === ruinParam);
          setSelected(selectedRuin);
        }
      }
    };

    const initialRuins = readInitialRuins(defaultLanguage);

    if (initialRuins) {
      applyRuins(initialRuins);
    } else {
      axios.get(`/api/${defaultLanguage}/ruins`).then(response => {
        applyRuins(response.data);
      });
    }

    return () => {
      active = false;
    };
  }, [defaultLanguage, ruinParam]);

  const handleMapClicked = useCallback(
    event => {
      if (event.features === undefined || event.features.length === 0) {
        setSelected(null);

        return;
      }

      const feature = event.features[0];
      const selectedRuin = ruins.find(item => item.id === feature.properties.id);

      if (selectedRuin) {
        setSelected(selectedRuin);
      }
    },
    [ruins]
  );

  const handleCursorChange = useCallback(event => {
    setCursor(event.features && event.features.length > 0 ? 'pointer' : 'move');
  }, []);

  const handlePopupClose = useCallback(() => {
    setSelected(null);
  }, []);

  const features = ruins
    .filter(item => item.latitude !== null && item.longitude !== null)
    .map(item => ({
      type: 'Feature',
      properties: { id: item.id, site_type: item.site_type },
      geometry: {
        type: 'Point',
        coordinates: [item.longitude, item.latitude],
      },
    }));

  return (
    <IntlProvider locale={defaultLanguage} messages={messages[defaultLanguage] || messages.en}>
      <div>
        <Map
          mapboxAccessToken={window.mapboxToken}
          mapStyle={mapStyle}
          cursor={cursor}
          initialViewState={{
            bounds: turkeyBounds,
            fitBoundsOptions: { padding: 20 },
          }}
          interactiveLayerIds={['marker']}
          onClick={handleMapClicked}
          onMouseMove={handleCursorChange}
          style={{ width: '100vw', height: '100vh' }}
        >
          <Source id="ruins" type="geojson" data={{ type: 'FeatureCollection', features }}>
            <Layer
              id="marker"
              type="symbol"
              layout={{
                'text-field': SITE_TYPE_MARKER_ICON,
                'text-size': SITE_TYPE_MARKER_SIZE,
                'text-allow-overlap': true,
              }}
              paint={{
                'text-color': SITE_TYPE_MARKER_COLOR,
                'text-halo-color': 'rgba(255, 255, 255, 1)',
                'text-halo-width': 2,
              }}
            />
          </Source>
          {selected && <FeaturePopup selected={selected} language={defaultLanguage} onClose={handlePopupClose} />}
        </Map>
        <MapLegend />
        {languageParam === 'tr' && ruinParam === 'hakkinda' && <AboutTr />}
        {languageParam === 'en' && ruinParam === 'about' && <AboutEn />}
        {ruinParam &&
          ruinParam !== 'hakkinda' &&
          ruinParam !== 'about' && <SidebarContainer />}
      </div>
    </IntlProvider>
  );
}

function Root() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/:language?/:ruin?" element={<App />} />
      </Routes>
    </BrowserRouter>
  );
}

createRoot(document.getElementById('root')).render(<Root />);
