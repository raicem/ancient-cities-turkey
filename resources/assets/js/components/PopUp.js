import React from 'react';

function PopUp(props) {
  const { feature } = props;
  return (
    <a href={feature.properties.slug} className="level link">
      <p>{feature.properties.name_tr}</p>
      <img src="/img/info.jpg" className="info-image" alt={feature.properties.name_tr} />
    </a>
  );
}

export default PopUp;
