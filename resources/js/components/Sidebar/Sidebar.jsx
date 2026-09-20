import React from 'react';
import { Link } from 'react-router-dom';
import { FormattedMessage } from 'react-intl';
import PropTypes from 'prop-types';
import FeedbackContainer from '../Feedback/FeedbackContainer';
import LinkList from './LinkList';
import { SITE_TYPE_MESSAGE_IDS } from '../../siteTypes';

export default function Sidebar(props) {
  const { ruin, isLoaded, hasLoadError, isFormShowing, language, handleClick, handleRetry } = props;
  const district = ruin && ruin.district;
  const city = ruin && ruin.city;
  const location = district && district.toLowerCase() !== (city || '').toLowerCase()
    ? [district, city].filter(Boolean).join(', ')
    : city;
  const englishLinks = ruin?.english_links ?? [];

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
      {!isLoaded && !hasLoadError && (
        <div className="info-bar__loading" aria-live="polite">
          <span className="visually-hidden">
            <FormattedMessage id="loadingSite" />
          </span>
          <div className="info-bar__skeleton info-bar__skeleton--image" />
          <div className="info-bar__loading-body" aria-hidden="true">
            <div className="info-bar__skeleton info-bar__skeleton--label" />
            <div className="info-bar__skeleton info-bar__skeleton--title" />
            <div className="info-bar__skeleton info-bar__skeleton--line" />
            <div className="info-bar__skeleton info-bar__skeleton--line" />
            <div className="info-bar__skeleton info-bar__skeleton--line-short" />
          </div>
        </div>
      )}
      {hasLoadError && (
        <div className="info-bar__state" role="alert">
          <p><FormattedMessage id="siteLoadError" /></p>
          <button className="button" type="button" onClick={handleRetry}>
            <FormattedMessage id="retry" />
          </button>
        </div>
      )}
      {isLoaded && (
        <div>
          {ruin.image && (
            <img
              className="info-bar-image"
              src={`/${ruin.image}`}
              alt={ruin.name}
              fetchpriority="high"
              decoding="async"
              onError={event => {
                event.currentTarget.style.display = 'none';
              }}
            />
          )}
          <div className="info-bar__body">
            {location && <p className="info-bar__eyebrow">{location}</p>}
            {(ruin.site_type || ruin.is_unesco || ruin.official_site_link) && (
              <div className="info-bar__metadata">
                {ruin.site_type && SITE_TYPE_MESSAGE_IDS[ruin.site_type] && (
                  <span className={`info-bar__badge info-bar__badge--type site-type--${ruin.site_type}`}>
                    <span className="info-bar__type-dot" aria-hidden="true" />
                    <FormattedMessage id={SITE_TYPE_MESSAGE_IDS[ruin.site_type]} />
                  </span>
                )}
                {ruin.is_unesco && (
                  <span className="info-bar__badge info-bar__badge--unesco">
                    <FormattedMessage id="unescoBadge" />
                  </span>
                )}
                {ruin.official_site_link && (
                  <a
                    className="info-bar__badge info-bar__badge--official info-bar__badge--link"
                    href={ruin.official_site_link}
                    id="visitingInfo"
                    rel="noreferrer"
                  >
                    <FormattedMessage id="visitingInfo" />
                    <svg
                      className="info-bar__arrow"
                      width="10"
                      height="10"
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
              </div>
            )}
            <h3 className="ruin-title">{ruin.name}</h3>
            {ruin.other_names && ruin.other_names.length > 0 && (
              <p className="info-bar__aliases">
                <FormattedMessage id="alsoKnownAs" />: {ruin.other_names.join(', ')}
              </p>
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
            </ul>
            {language === 'tr' ? (
              <>
                <LinkList links={ruin.turkish_links} titleId="resourcesInTurkish" />
                <LinkList links={englishLinks} titleId="resourcesInEnglish" />
              </>
            ) : (
              <>
                <LinkList links={englishLinks} titleId="resourcesInEnglish" />
                <LinkList links={ruin.turkish_links} titleId="resourcesInTurkish" />
              </>
            )}
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
    official_site_link: PropTypes.string,
    image: PropTypes.string,
    information: PropTypes.string,
    english_links: PropTypes.array,
    turkish_links: PropTypes.array,
    latitude: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
    longitude: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
    name: PropTypes.string,
    city: PropTypes.string,
    district: PropTypes.string,
    site_type: PropTypes.string,
    other_names: PropTypes.array,
    is_unesco: PropTypes.bool,
    period: PropTypes.string,
    created_at: PropTypes.string,
    updated_at: PropTypes.string,
  }),
  isLoaded: PropTypes.bool.isRequired,
  hasLoadError: PropTypes.bool.isRequired,
  isFormShowing: PropTypes.bool.isRequired,
  language: PropTypes.string.isRequired,
  handleClick: PropTypes.func.isRequired,
  handleRetry: PropTypes.func.isRequired,
};

Sidebar.defaultProps = {
  ruin: {},
};
