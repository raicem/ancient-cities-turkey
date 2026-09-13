import React from 'react';
import PropTypes from 'prop-types';
import { Link } from 'react-router-dom';
import { Popup } from 'react-map-gl/mapbox';
import { FormattedMessage, useIntl } from 'react-intl';
import { SITE_TYPE_MESSAGE_IDS } from '../siteTypes';

export default function FeaturePopup(props) {
  const { selected, language, onClose } = props;
  const intl = useIntl();
  const location = selected.district && selected.district.toLowerCase() !== (selected.city || '').toLowerCase()
    ? [selected.district, selected.city].filter(Boolean).join(', ')
    : selected.city;

  return (
    <Popup
      key={selected.slug}
      anchor="bottom"
      offset={14}
      maxWidth="min(260px, 82vw)"
      focusAfterOpen={false}
      longitude={Number(selected.longitude)}
      latitude={Number(selected.latitude)}
      onClose={onClose}
    >
      <Link to={`/${language}/${selected.slug}`} className="ruin-popup">
        {selected.image && (
          <img
            className="ruin-popup__image"
            src={`/${selected.image}`}
            alt=""
            onError={event => {
              event.currentTarget.style.display = 'none';
            }}
          />
        )}
        <div className="ruin-popup__body">
          {location && <span className="ruin-popup__city">{location}</span>}
          {(SITE_TYPE_MESSAGE_IDS[selected.site_type] || selected.is_unesco || selected.official_site_link) && (
            <span className="ruin-popup__metadata">
              {SITE_TYPE_MESSAGE_IDS[selected.site_type] && (
                <span className={`ruin-popup__type site-type--${selected.site_type}`}>
                  <span className="ruin-popup__type-dot" aria-hidden="true" />
                  <FormattedMessage id={SITE_TYPE_MESSAGE_IDS[selected.site_type]} />
                </span>
              )}
              {selected.is_unesco && (
                <span>
                  <FormattedMessage id="unescoShort" />
                </span>
              )}
              {selected.official_site_link && (
                <span title={intl.formatMessage({ id: 'officialSiteTitle' })}>
                  <FormattedMessage id="officialSite" />
                </span>
              )}
            </span>
          )}
          <span className="ruin-popup__name">{selected.name}</span>
          <span className="ruin-popup__footer">
            <span className="ruin-popup__cta">
              <FormattedMessage id="openGuide" />
              <svg
                className="ruin-popup__arrow"
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
            </span>
          </span>
        </div>
      </Link>
    </Popup>
  );
}

FeaturePopup.propTypes = {
  selected: PropTypes.shape({
    latitude: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
    longitude: PropTypes.oneOfType([PropTypes.string, PropTypes.number]),
    name: PropTypes.string,
    slug: PropTypes.string,
    image: PropTypes.string,
    city: PropTypes.string,
    district: PropTypes.string,
    site_type: PropTypes.string,
    is_unesco: PropTypes.bool,
    official_site_link: PropTypes.string,
  }).isRequired,
  language: PropTypes.string.isRequired,
  onClose: PropTypes.func.isRequired,
};
