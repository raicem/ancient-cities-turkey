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
          <img src="/img/info.jpg" className="info-image" alt="Click for info" />
        </Link>
      </div>
    </Popup>
  );
}

FeaturePopup.propTypes = {
  selected: PropTypes.shape({
    latitude: PropTypes.number,
    longitude: PropTypes.number,
    name: PropTypes.string,
    slug: PropTypes.string,
  }).isRequired,
  language: PropTypes.string.isRequired,
};
