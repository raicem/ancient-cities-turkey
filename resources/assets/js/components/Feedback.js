import React from 'react';
import { FormattedMessage, injectIntl } from 'react-intl';
import axios from 'axios';

class Feedback extends React.Component {
  constructor(props) {
    super(props);

    this.handleClick = this.handleClick.bind(this);
    this.handleChange = this.handleChange.bind(this);

    this.state = {
      placeholder: props.intl.formatMessage({ id: 'placeholder' }, { name: props.ruin.name }),
      ruin: props.ruin,
      message: '',
      isSent: null,
    };
  }

  componentWillReceiveProps(nextProps) {
    this.setState({
      placeholder: nextProps.intl.formatMessage(
        { id: 'placeholder' },
        { name: nextProps.ruin.name },
      ),
    });
  }

  handleClick(event) {
    event.preventDefault();

    axios
      .post('/api/feedback', {
        ruin_id: this.state.ruin.id,
        ruin: this.state.ruin.name,
        body: this.state.message,
      })
      .then(() => {
        this.setState({ isSent: true, message: '' });
      })
      .catch(() => {
        this.setState({ isSent: false });
      });
  }

  handleChange(event) {
    this.setState({
      message: event.target.value,
    });
  }

  render() {
    return (
      <div>
        {this.state.isSent === false && (
          <div className="alert alert-error">
            <p className="validation">
              <FormattedMessage id="error" />
            </p>
          </div>
        )}
        {this.state.isSent && (
          <div className="alert alert-success">
            <p className="validation">
              <FormattedMessage id="success" />
            </p>
          </div>
        )}
        <form action="#">
          <div className="form-group">
            <textarea
              name="body"
              id="body"
              rows="5"
              placeholder={this.state.placeholder}
              value={this.state.message}
              onChange={this.handleChange}
            />
          </div>
          <div className="form-group">
            <button className="button button-blue" onClick={this.handleClick}>
              <FormattedMessage id="send" />
            </button>
          </div>
        </form>
      </div>
    );
  }
}

export default injectIntl(Feedback);
