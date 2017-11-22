import React from 'react';
import { Link } from 'react-router-dom';
import { FormattedMessage } from 'react-intl';
import PropTypes from 'prop-types';
import FeedbackContainer from '../FeedbackContainer';
import LinkList from './LinkList';

export default function Sidebar(props) {
  const { ruin, isLoaded, isFormShowing, language, handleClick } = props;
  return (
    <div className="info-bar">
      <div>
        <Link href="/" to="/">
          <button className="button button-red close-button" id="close">
            <FormattedMessage id="close" />
          </button>
        </Link>
        {isLoaded && (
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
              <li className="image-list-item maps-link-item">
                <a href={`http://maps.apple.com/?ll=${ruin.latitude},${ruin.longitude}`} className="maps-link">
                  <FormattedMessage id="openInMapsApp" />
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
              <LinkList links={ruin.english_links} titleId="resourcesInEnglish" />
              <LinkList links={ruin.turkish_links} titleId="resourcesInTurkish" />
            </ul>
            {!isFormShowing && (
              <div className="feedback">
                <button className="button button-blue feedback-button" onClick={handleClick}>
                  <FormattedMessage id="reportIssue" />
                </button>
              </div>
            )}
            {isFormShowing && <FeedbackContainer ruin={ruin} />}
            <div className="lang-buttons">
              <Link to={`/tr/${ruin.slug}`} href={`/tr/${ruin.slug}`}>
                Türkçe
              </Link>
              {' '}
              <Link to={`/en/${ruin.slug}`} href={`/en/${ruin.slug}`}>
                English
              </Link>
            </div>
            <div className="about">
              {language === 'tr' && (
                <Link to="/tr/hakkinda" href="/tr/hakkinda" id="aboutLink">
                  <FormattedMessage id="about" />
                </Link>
              )}
              {language === 'en' && (
                <Link to="/en/about" href="/en/about" id="aboutLink">
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

Sidebar.propTypes = {
  ruin: PropTypes.shape({
    id: PropTypes.number,
    slug: PropTypes.string,
    official_site: PropTypes.number,
    official_site_link: PropTypes.string,
    image: PropTypes.string,
    information: PropTypes.string,
    foursquare: PropTypes.string,
    tripadvisor: PropTypes.string,
    english_links: PropTypes.array,
    turkish_links: PropTypes.array,
    latitude: PropTypes.string,
    longitude: PropTypes.string,
    name: PropTypes.string,
    period: PropTypes.string,
    created_at: PropTypes.string,
    updated_at: PropTypes.string,
  }),
  isLoaded: PropTypes.bool.isRequired,
  isFormShowing: PropTypes.bool.isRequired,
  language: PropTypes.string.isRequired,
  handleClick: PropTypes.func.isRequired,
};

Sidebar.defaultProps = {
  ruin: {},
};
