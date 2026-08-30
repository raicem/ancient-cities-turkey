import React from 'react';
import PropTypes from 'prop-types';
import { Link } from 'react-router-dom';
import { Popup } from 'react-map-gl/mapbox';
import { FormattedMessage } from 'react-intl';

export default function FeaturePopup(props) {
  const { selected, language } = props;
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
  }).isRequired,
  language: PropTypes.string.isRequired,
};
