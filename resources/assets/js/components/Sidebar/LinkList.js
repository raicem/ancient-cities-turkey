import React from 'react';
import { FormattedMessage } from 'react-intl';
import PropTypes from 'prop-types';

export default function LinkList(props) {
  const { links, titleId } = props;
  return (
    <div>
      <h4 className="link-list-title" id="englishResources">
        <FormattedMessage id={titleId} />
      </h4>
      {links &&
        links.map(item => (
          <li key={item.url} className="link-list-item">
            <a href={item.url} target="_blank" rel="noopener">
              {item.description}
            </a>
          </li>
        ))}
    </div>
  );
}

LinkList.propTypes = {
  links: PropTypes.arrayOf(PropTypes.object),
  titleId: PropTypes.string.isRequired,
};

LinkList.defaultProps = {
  links: [],
};
