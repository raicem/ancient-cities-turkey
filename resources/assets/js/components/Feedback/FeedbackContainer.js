import React from 'react';
import { injectIntl } from 'react-intl';
import axios from 'axios';
import Feedback from './Feedback';

class FeedbackContainer extends React.Component {
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
      ruin: nextProps.ruin,
      isSent: null,
    });
  }

  handleClick(event) {
    event.preventDefault();

    axios
      .post('/api/feedback', {
        ruin_id: this.state.ruin.id,
        ruin: this.state.ruin.slug,
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
    const { placeholder, isSent, message } = this.state;
    return (
      <Feedback
        placeholder={placeholder}
        isSent={isSent}
        message={message}
        handleChange={this.handleChange}
        handleClick={this.handleClick}
      />
    );
  }
}

export default injectIntl(FeedbackContainer);
