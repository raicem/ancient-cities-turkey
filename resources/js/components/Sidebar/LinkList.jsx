import React from 'react';
import { FormattedMessage } from 'react-intl';
import PropTypes from 'prop-types';

export default function LinkList(props) {
  const { links, titleId } = props;

  if (!links || links.length === 0) {
    return null;
  }

  return (
    <section className="link-list">
      <h4 className="info-bar__eyebrow">
        <FormattedMessage id={titleId} />
      </h4>
      <ul>
        {links.map(item => (
          <li key={item.url} className="link-list-item">
            <a href={item.url} target="_blank" rel="noopener">
              {item.description}
              <svg
                className="link-list-item__arrow"
                width="10"
                height="10"
                viewBox="0 0 16 16"
                aria-hidden="true"
                focusable="false"
              >
                <path
                  d="M3.5 12.5l9-9M5.5 3.5h7v7"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="1.6"
                />
              </svg>
            </a>
          </li>
        ))}
      </ul>
    </section>
  );
}

LinkList.propTypes = {
  links: PropTypes.arrayOf(PropTypes.object),
  titleId: PropTypes.string.isRequired,
};

LinkList.defaultProps = {
  links: [],
};
