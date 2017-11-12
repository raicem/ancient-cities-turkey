import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Switch, Route } from 'react-router-dom';
import ReactMapboxGL, { Layer, Feature } from 'react-mapbox-gl';
import { addLocaleData, IntlProvider } from 'react-intl';
import trLocaleData from 'react-intl/locale-data/tr';
import axios from 'axios';
import SidebarContainer from './components/Sidebar/SidebarContainer';
import AboutTr from './components/AboutTr';
import AboutEn from './components/AboutEn';
import FeaturePopup from './components/FeaturePopup';
import messages from './messages';

const Map = ReactMapboxGL({
  accessToken:
    'pk.eyJ1IjoicmFpY2VtIiwiYSI6ImNqMjZmaHl6aTAwMmYzM3BqeWVrYnVjODIifQ.iZRVG8IE35SdbbkMhnK9ow',
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

    this.handleClick = this.handleClick.bind(this);

    const language = this.props.match.params.language || locale;

    this.state = {
      ruins: [],
      selected: null,
      language,
    };
  }

  componentWillMount() {
    axios.get(`/api/${this.state.language}/ruins`).then(response => {
      this.setState({ ruins: response.data }, () => {
        const newState = this.syncStateWithUrl(this.props);
        this.setState(newState);
      });
    });
  }

  componentWillReceiveProps(nextProps) {
    const newState = this.syncStateWithUrl(nextProps);
    this.setState(newState);
  }

  syncStateWithUrl(props) {
    const { language, ruin } = props.match.params;
    let newState = {};

    if (language !== this.state.language) {
      newState = { language };
    }

    if (this.state.selected === null || ruin !== this.state.selected.slug) {
      const selected = this.state.ruins.find(item => item.slug === this.props.match.params.ruin);

      newState = { selected };
    }

    return newState;
  }

  handleClick(feature) {
    if (feature !== undefined) {
      this.setState({ selected: feature });
    }
  }

  render() {
    const { ruins, selected, language } = this.state;

    return (
      <IntlProvider locale={language} messages={messages[language]}>
        <div>
          <Map
            fitBounds={[[25.059009, 35.259924], [45.351057, 42.210808]]}
            style="mapbox://styles/mapbox/streets-v9"
            containerStyle={{
              height: '100vh',
              width: '100vw',
            }}
            onClick={() => this.handleClick()}
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
                  onClick={() => {
                    this.handleClick(item);
                  }}
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
      <Route path="/:language/:ruin" component={App} />
      <Route path="/:language" component={App} />
      <Route path="/" component={App} />
    </Switch>
  </BrowserRouter>,
  document.getElementById('root'),
);
