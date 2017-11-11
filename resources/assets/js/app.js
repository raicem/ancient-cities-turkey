import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Switch, Route, Link } from 'react-router-dom';
import ReactMapboxGL, { Layer, Feature, Popup } from 'react-mapbox-gl';
import { addLocaleData, IntlProvider, FormattedMessage } from 'react-intl';
import trLocaleData from 'react-intl/locale-data/tr';
import axios from 'axios';
import Sidebar from './components/Sidebar';
import AboutTr from './components/AboutTr';
import AboutEn from './components/AboutEn';
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
  constructor(props) {
    super(props);

    this.handleClick = this.handleClick.bind(this);
    this.changeCursor = this.changeCursor.bind(this);

    this.state = {
      ruins: [],
      selected: null,
      language: locale,
    };
  }

  componentWillMount() {
    console.log('app - component will mount');

    const language = this.props.match.params.language || locale;

    this.setState({ language });

    axios.get(`/api/${language}/ruins`).then(response => {
      this.setState(
        {
          ruins: response.data,
        },
        this.checkSelected,
      );
    });
  }

  componentWillReceiveProps(nextProps) {
    console.log('app - component will receive props');

    const newLanguage = nextProps.match.params.language || this.state.language;

    this.setState({
      language: newLanguage,
    });

    if (nextProps.location.pathname === '/') {
      this.setState({ selected: null });
    }
  }

  checkSelected() {
    const selected = this.state.ruins.find(item => item.slug === this.props.match.params.ruin);
    this.setState({
      selected,
    });
  }

  handleClick(feature) {
    if (feature !== undefined) {
      this.setState({ selected: feature });
    }
  }

  changeCursor({ map, type }) {
    const cursor = type === 'mouseenter' ? 'pointer' : 'move';
    map.getCanvas().style.cursor = cursor;
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
                  key={item.id}
                  coordinates={[item.longitude, item.latitude]}
                  onClick={() => {
                    this.handleClick(item);
                  }}
                  onMouseEnter={this.changeCursor}
                  onMouseLeave={this.changeCursor}
                />
              ))}
            </Layer>
            {selected && (
              <Popup
                key={selected.id}
                anchor="bottom"
                offset={[0, -10]}
                coordinates={[selected.longitude, selected.latitude]}
              >
                <div>
                  <Link href to={`/${this.state.language}/${selected.slug}`} className="level link">
                    <p>{selected.name}</p>
                    <img src="/img/info.jpg" className="info-image" alt="Click for info" />
                  </Link>
                </div>
              </Popup>
            )}
          </Map>
          <Switch>
            <Route exact path="/tr/hakkinda" component={AboutTr} />
            <Route exact path="/en/about" component={AboutEn} />
            <Route path="/:language/:ruin" component={Sidebar} />
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
