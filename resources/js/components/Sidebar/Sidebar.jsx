import React from 'react';
import { Link } from 'react-router-dom';
import { FormattedMessage } from 'react-intl';
import PropTypes from 'prop-types';
import FeedbackContainer from '../Feedback/FeedbackContainer';
import LinkList from './LinkList';

export default function Sidebar(props) {
  const { ruin, isLoaded, isFormShowing, language, handleClick } = props;
  const district = ruin && ruin.district;
  const city = ruin && ruin.city;
  const location = district && district.toLowerCase() !== (city || '').toLowerCase()
    ? [district, city].filter(Boolean).join(', ')
    : city;

  return (
    <div className="info-bar">
      <Link to="/" className="info-bar__close" id="close" autoFocus>
        <svg
          className="info-bar__close-icon"
          width="12"
          height="12"
          viewBox="0 0 16 16"
          aria-hidden="true"
          focusable="false"
        >
          <path d="M3 3l10 10M13 3L3 13" fill="none" stroke="currentColor" strokeWidth="1.6" />
        </svg>
        <span className="visually-hidden">
          <FormattedMessage id="close" />
        </span>
      </Link>
      {isLoaded && (
        <div>
          {ruin.image && (
            <img
              className="info-bar-image"
              src={`/${ruin.image}`}
              alt={ruin.name}
              onError={event => {
                event.currentTarget.style.display = 'none';
              }}
            />
          )}
          <div className="info-bar__body">
            {location && <p className="info-bar__eyebrow">{location}</p>}
            <h3 className="ruin-title">{ruin.name}</h3>
            {ruin.official_site === 1 && (
              <a className="info-bar__official" href={ruin.official_site_link} id="visitingInfo">
                <img
                  className="ministry-logo"
                  src="/img/official.png"
                  alt="Official Site"
                  id="officialLogo"
                />
                <FormattedMessage id="visitingInfo" />
                <svg
                  className="info-bar__arrow"
                  width="12"
                  height="12"
                  viewBox="0 0 16 16"
                  aria-hidden="true"
                  focusable="false"
                >
                  <path
                    d="M1.5 8h12.2M9.4 3.7l4.3 4.3-4.3 4.3"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="1.6"
                  />
                </svg>
              </a>
            )}
            <p className="info-bar-description">{ruin.information}</p>
            <ul className="image-list">
              <li className="image-list-item">
                <a
                  href={`http://maps.apple.com/?ll=${ruin.latitude},${ruin.longitude}`}
                  className="image-list-link"
                >
                  <FormattedMessage id="openInMapsApp" />
                </a>
              </li>
              {ruin.tripadvisor && (
                <li className="image-list-item">
                  <a
                    href={ruin.tripadvisor}
                    className="image-list-link"
                    target="_blank"
                    rel="noopener"
                  >
                    <img src="/img/tripadvisor.png" alt="Tripadvisor Logo" />
                  </a>
                </li>
              )}
              {ruin.foursquare && (
                <li className="image-list-item">
                  <a
                    href={ruin.foursquare}
                    className="image-list-link"
                    target="_blank"
                    rel="noopener"
                  >
                    <img src="/img/foursquare.png" alt="Foursquare Logo" />
                  </a>
                </li>
              )}
            </ul>
            <LinkList links={ruin.english_links} titleId="resourcesInEnglish" />
            <LinkList links={ruin.turkish_links} titleId="resourcesInTurkish" />
            {!isFormShowing && (
              <div className="feedback">
                <button className="button feedback-button" onClick={handleClick}>
                  <FormattedMessage id="reportIssue" />
                </button>
              </div>
            )}
            {isFormShowing && <FeedbackContainer ruin={ruin} />}
            <div className="info-bar__footer">
              <div className="lang-buttons">
                <Link to={`/tr/${ruin.slug}`}>Türkçe</Link>
                <span className="info-bar__footer-separator" aria-hidden="true">
                  ·
                </span>
                <Link to={`/en/${ruin.slug}`}>English</Link>
              </div>
              {language === 'tr' && (
                <Link to="/tr/hakkinda" id="aboutLink">
                  <FormattedMessage id="about" />
                </Link>
              )}
              {language === 'en' && (
                <Link to="/en/about" id="aboutLink">
                  <FormattedMessage id="about" />
                </Link>
              )}
            </div>
          </div>
        </div>
      )}
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
    latitude: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
    longitude: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
    name: PropTypes.string,
    city: PropTypes.string,
    district: PropTypes.string,
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
