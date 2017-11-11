import React from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import { FormattedMessage } from 'react-intl';
import Feedback from './Feedback';

class Sidebar extends React.Component {
  constructor(props) {
    super(props);

    this.ruinSlug = props.match.params.ruin;

    this.handleClick = this.handleClick.bind(this);

    this.state = {
      ruin: null,
      isLoaded: false,
      language: props.match.params.language,
      isFormShowing: false,
    };
  }

  componentWillMount() {
    console.log('sidebar - component will mount');
    axios.get(`/api/${this.state.language}/ruins/${this.ruinSlug}`).then(response => {
      this.setState({ ruin: response.data, isLoaded: true });
    });
  }

  componentWillReceiveProps(nextProps) {
    console.log('sidebar - component will receive props', nextProps);
    const newRuin = nextProps.match.params.ruin;
    const newLanguage = nextProps.match.params.language;

    axios.get(`/api/${newLanguage}/ruins/${newRuin}`).then(response => {
      this.setState({ ruin: response.data, isLoaded: true, language: newLanguage });
    });
  }

  handleClick() {
    this.setState({ isFormShowing: true });
  }

  render() {
    const { ruin } = this.state;

    return (
      <div className="info-bar">
        <div>
          <Link href="/" to="/">
            <button className="button button-red close-button" id="close">
              <FormattedMessage id="close" />
            </button>
          </Link>
          {this.state.isLoaded && (
            <div className="ruin-info">
              <div className="info-bar-image" style={{ backgroundImage: `url(/${ruin.image})` }} />
              <div className="level info-bar-title">
                <h3 className="link-list-title">{ruin.name}</h3>
                {ruin.official_site === 1 && (
                  <div>
                    <img
                      className="ministry-logo"
                      src="/img/official.png"
                      alt="Official Site"
                      id="officialLogo"
                    />
                    <a href={ruin.official_site_link} id="visitingInfo">
                      <FormattedMessage id="visitingInfo" />
                    </a>
                  </div>
                )}
              </div>
              <p className="info-bar-description">{ruin.information}</p>
              <ul className="image-list flex">
                <li className="image-list-item">
                  <a href="http://maps.apple.com/?ll=@{{ latitude }},@{{ longitude }}">
                    <img src="/img/map.png" alt="Open in default maps app" />
                  </a>
                </li>
                {ruin.tripadvisor && (
                  <li className="image-list-item">
                    <a href={ruin.tripadvisor}>
                      <img src="/img/tripadvisor.png" alt="Tripadvisor Logo" />
                    </a>
                  </li>
                )}
                {ruin.foursquare && (
                  <li className="image-list-item">
                    <a href={ruin.foursquare}>
                      <img src="/img/foursquare.png" alt="Foursquare Logo" />
                    </a>
                  </li>
                )}
              </ul>
              <ul className="link-list">
                <h4 className="link-list-title" id="englishResources">
                  <FormattedMessage id="resourcesInEnglish" />
                </h4>
                {ruin.english_links &&
                  ruin.english_links.map(item => (
                    <li key={item.url} className="link-list-item">
                      <a href={item.url}>{item.description}</a>
                    </li>
                  ))}
                <h4 className="link-list-title" id="turkishResources">
                  <FormattedMessage id="resourcesInTurkish" />
                </h4>
                {ruin.turkish_links &&
                  ruin.turkish_links.map(item => (
                    <li key={item.url} className="link-list-item">
                      <a href={item.url}>{item.description}</a>
                    </li>
                  ))}
              </ul>
              {!this.state.isFormShowing && (
                <div className="feedback">
                  <button
                    id="reportIssue"
                    className="button button-blue feedback-button"
                    onClick={this.handleClick}
                  >
                    <FormattedMessage id="reportIssue" />
                  </button>
                </div>
              )}
              {this.state.isFormShowing && <Feedback ruin={ruin} />}
              <div className="lang-buttons">
                <Link to={`/tr/${ruin.slug}`}>Türkçe</Link>
                <Link to={`/en/${ruin.slug}`}>English</Link>
              </div>
              <div className="about">
                {this.state.language === 'tr' && (
                  <Link to="/tr/hakkinda" id="aboutLink">
                    <FormattedMessage id="about" />
                  </Link>
                )}
                {this.state.language === 'en' && (
                  <Link to="/en/about" id="aboutLink">
                    <FormattedMessage id="about" />
                  </Link>
                )}
              </div>
            </div>
          )}
        </div>
      </div>
    );
  }
}

export default Sidebar;
