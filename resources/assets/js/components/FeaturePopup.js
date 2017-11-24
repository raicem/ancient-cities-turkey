import React from 'react';
import PropTypes from 'prop-types';
import { Link } from 'react-router-dom';
import { Popup } from 'react-mapbox-gl';

export default function FeaturePopup(props) {
  const { selected, language } = props;
  return (
    <Popup
      key={selected.slug}
      anchor="bottom"
      offset={[0, -10]}
      coordinates={[selected.longitude, selected.latitude]}
    >
      <div>
        <Link href to={`/${language}/${selected.slug}`} className="level link">
          <p>{selected.name}</p>
          <div className="info-image">
            <svg
              version="1.1"
              xmlns="http://www.w3.org/2000/svg"
              width="20"
              height="32"
              viewBox="0 0 32 32"
              display="block"
            >
              <title>info</title>
              <path d="M14 9.5c0-0.825 0.675-1.5 1.5-1.5h1c0.825 0 1.5 0.675 1.5 1.5v1c0 0.825-0.675 1.5-1.5 1.5h-1c-0.825 0-1.5-0.675-1.5-1.5v-1z" />
              <path d="M20 24h-8v-2h2v-6h-2v-2h6v8h2z" />
              <path d="M16 0c-8.837 0-16 7.163-16 16s7.163 16 16 16 16-7.163 16-16-7.163-16-16-16zM16 29c-7.18 0-13-5.82-13-13s5.82-13 13-13 13 5.82 13 13-5.82 13-13 13z" />
            </svg>
          </div>
        </Link>
      </div>
    </Popup>
  );
}

FeaturePopup.propTypes = {
  selected: PropTypes.shape({
    latitude: PropTypes.string,
    longitude: PropTypes.string,
    name: PropTypes.string,
    slug: PropTypes.string,
  }).isRequired,
  language: PropTypes.string.isRequired,
};
