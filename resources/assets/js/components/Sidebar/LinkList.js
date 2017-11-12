import React from 'react';
import { FormattedMessage } from 'react-intl';

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
            <a href={item.url}>{item.description}</a>
          </li>
        ))}
    </div>
  );
}
