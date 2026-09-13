import React from 'react';
import { FormattedMessage } from 'react-intl';
import { SITE_TYPES } from '../siteTypes';

function LegendMarker({ shape, color }) {
  const common = { fill: color, stroke: '#fff', strokeWidth: 1.3, strokeLinejoin: 'round' };

  if (shape === 'circle') {
    return <circle cx="10" cy="10" r="6.5" {...common} />;
  }

  if (shape === 'square') {
    return <rect x="3.5" y="3.5" width="13" height="13" rx="1.5" {...common} />;
  }

  if (shape === 'triangle') {
    return <path d="M10 3.2L17 16.8H3L10 3.2z" {...common} />;
  }

  if (shape === 'diamond') {
    return <path d="M10 2.5L17.5 10L10 17.5L2.5 10L10 2.5z" {...common} />;
  }

  return (
    <path
      d="M10 1.7l2.38 4.82 5.32.77-3.85 3.75.91 5.3L10 13.84l-4.76 2.5.91-5.3L2.3 7.29l5.32-.77L10 1.7z"
      {...common}
    />
  );
}

export default function MapLegend() {
  return (
    <details className="map-legend" open>
      <summary className="map-legend__title">
        <FormattedMessage id="siteTypes" />
      </summary>
      <ul className="map-legend__list">
        {SITE_TYPES.map(siteType => (
          <li className="map-legend__item" key={siteType.value}>
            <svg className="map-legend__marker" viewBox="0 0 20 20" aria-hidden="true">
              <LegendMarker shape={siteType.shape} color={siteType.color} />
            </svg>
            <FormattedMessage id={siteType.messageId} />
          </li>
        ))}
      </ul>
    </details>
  );
}
