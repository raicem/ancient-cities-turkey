import React from 'react';
import { FormattedMessage } from 'react-intl';
import PropTypes from 'prop-types';

export default function Feedback(props) {
  const { placeholder, isSent, message, handleChange, handleClick } = props;
  return (
    <div>
      {isSent === false && (
        <div className="alert alert-error">
          <p className="validation">
            <FormattedMessage id="error" />
          </p>
        </div>
      )}
      {isSent && (
        <div className="alert alert-success">
          <p className="validation">
            <FormattedMessage id="success" />
          </p>
        </div>
      )}
      <form>
        <div className="form-group">
          <textarea
            name="body"
            id="body"
            rows="5"
            placeholder={placeholder}
            value={message}
            onChange={handleChange}
          />
        </div>
        <div className="form-group">
          <button className="button button-blue" onClick={handleClick}>
            <FormattedMessage id="send" />
          </button>
        </div>
      </form>
    </div>
  );
}

Feedback.propTypes = {
  placeholder: PropTypes.string.isRequired,
  isSent: PropTypes.bool,
  message: PropTypes.string.isRequired,
  handleClick: PropTypes.func.isRequired,
  handleChange: PropTypes.func.isRequired,
};

Feedback.defaultProps = {
  isSent: null,
};
