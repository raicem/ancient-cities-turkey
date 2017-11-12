import React from 'react';
import { Link } from 'react-router-dom';
import { FormattedMessage } from 'react-intl';

export default function AboutTr() {
  return (
    <div className="info-bar">
      <div>
        <Link href="/" to="/">
          <button className="button button-red close-button" id="close">
            <FormattedMessage id="close" />
          </button>
        </Link>
      </div>
      <h3>About This Project</h3>
      <p>
        I wanted to be able see all of the ancient cities in Turkey on a map so that I can discover
        and travel whichever is close to my location. I could not find anything similar to what I've
        wanted so I started building this web site. Currently this contains around 110 archeological
        sites in Turkey. I assume the maximum number would be around 140 so there is still a lot of
        points to add.
      </p>
      <p>
        If you'd like to read more about this project you can read my blog post{' '}
        <a href="https://raicem.github.io/2017/08/28/ancient-cities-of-turkey/">here.</a>
      </p>
      <p>
        I have tried to pick most accurate information about the ruins. But as I have no formal
        education on this subject, please consider that there may be some data that is not
        up-to-date or correct. Please feel free to inform me using the send feedback form.
      </p>
      <p>
        You can reach me via the report issue form,{' '}
        <a href="https://twitter.com/ciftehavuz">Twitter</a> or{' '}
        <a href="mailto:unalancem@gmail.com">unalancem@gmail.com</a>.
      </p>
    </div>
  );
}
