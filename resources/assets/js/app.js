import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Switch, Route } from 'react-router-dom';
import ReactMapboxGL, { Layer, Feature } from 'react-mapbox-gl';
import axios from 'axios';
import { addLocaleData, IntlProvider } from 'react-intl';
import trLocaleData from 'react-intl/locale-data/tr';
import messages from './messages';
import SidebarContainer from './components/Sidebar/SidebarContainer';
import AboutTr from './components/AboutTr';
import AboutEn from './components/AboutEn';
import FeaturePopup from './components/FeaturePopup';

const Map = ReactMapboxGL({
  accessToken:
    'pk.eyJ1IjoicmFpY2VtIiwiYSI6ImNqMjZmaHl6aTAwMmYzM3BqeWVrYnVjODIifQ.iZRVG8IE35SdbbkMhnK9ow'
});

addLocaleData(trLocaleData);

let locale =
  (navigator.languages && navigator.languages[0]) || navigator.language || navigator.userLanguages;

locale = locale.substring(0, 2);

class App extends React.Component {
  static changeCursor({ map, type }) {
    const cursor = type === 'mouseenter' ? 'pointer' : 'move';
    map.getCanvas().style.cursor = cursor;
  }

  constructor(props) {
    super(props);

    this.handleFeatureClicked = this.handleFeatureClicked.bind(this);
    this.handleMapClicked = this.handleMapClicked.bind(this);

    const language = this.props.match.params.language || locale;

    this.state = {
      ruins: [],
      selected: null,
      language,
      bounds: [[25.059009, 35.259924], [45.351057, 42.210808]]
    };
  }

  async componentWillMount() {
    const response = await axios.get(`/api/${this.state.language}/ruins`);

    this.setState({ ruins: response.data }, async () => {
      const newState = await this.syncStateWithUrl(this.props);
      this.setState(newState);
    });
  }

  async componentWillReceiveProps(nextProps) {
    const newState = await this.syncStateWithUrl(nextProps);
    this.setState(newState);
  }

  async syncStateWithUrl(props) {
    const { language, ruin } = props.match.params;
    const newState = {};

    if (language !== this.state.language && language !== undefined) {
      newState.language = language;
      const response = await axios.get(`/api/${language}/ruins`);
      newState.ruins = response.data;
    }

    if (ruin !== undefined) {
      const selected = this.state.ruins.find(item => item.slug === ruin);

      newState.selected = selected;
    }

    return newState;
  }

  handleMapClicked(event) {
    if (event.feature === undefined) {
      this.setState({ selected: null });
    }
  }

  handleFeatureClicked(event) {
    const mapBounds = event.map.getBounds();
    const bounds = mapBounds.toArray();

    if (event.feature !== undefined) {
      const selected = this.state.ruins[event.feature.properties.id];
      this.setState({ selected, bounds });
    }
  }

  render() {
    const { ruins, selected, language, bounds } = this.state;

    return (
      <IntlProvider locale={language} messages={messages[language]}>
        <div>
          <Map
            fitBounds={bounds}
            style="mapbox://styles/mapbox/streets-v9"
            containerStyle={{
              height: '100vh',
              width: '100vw'
            }}
            onClick={this.handleMapClicked}
          >
            <Layer
              type="symbol"
              id="marker"
              layout={{ 'icon-image': 'star-15', 'icon-allow-overlap': true }}
            >
              {ruins.map(item => (
                <Feature
                  item={item}
                  key={item.slug}
                  coordinates={[item.longitude, item.latitude]}
                  onClick={this.handleFeatureClicked}
                  onMouseEnter={App.changeCursor}
                  onMouseLeave={App.changeCursor}
                />
              ))}
            </Layer>
            {selected && <FeaturePopup selected={selected} language={language} />}
          </Map>
          <Switch>
            <Route exact path="/tr/hakkinda" component={AboutTr} />
            <Route exact path="/en/about" component={AboutEn} />
            <Route path="/:language/:ruin" component={SidebarContainer} />
          </Switch>
        </div>
      </IntlProvider>
    );
  }
}

ReactDOM.render(
  <BrowserRouter>
    <Switch>
      <Route path="/:language?/:ruin?" component={App} />
    </Switch>
  </BrowserRouter>,
  document.getElementById('root')
);
