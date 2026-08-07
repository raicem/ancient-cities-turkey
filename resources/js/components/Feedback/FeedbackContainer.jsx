import React, { useEffect, useState } from 'react';
import { useIntl } from 'react-intl';
import axios from 'axios';
import Feedback from './Feedback';

export default function FeedbackContainer(props) {
  const { ruin } = props;
  const intl = useIntl();

  const [message, setMessage] = useState('');
  const [isSent, setIsSent] = useState(null);

  useEffect(() => {
    setIsSent(null);
  }, [ruin]);

  const handleClick = event => {
    event.preventDefault();

    axios
      .post('/api/feedback', {
        ruin_id: ruin.id,
        ruin: ruin.slug,
        body: message,
      })
      .then(() => {
        setMessage('');
        setIsSent(true);
      })
      .catch(() => {
        setIsSent(false);
      });
  };

  const handleChange = event => {
    setMessage(event.target.value);
  };

  const placeholder = intl.formatMessage({ id: 'placeholder' }, { name: ruin.name });

  return (
    <Feedback
      placeholder={placeholder}
      isSent={isSent}
      message={message}
      handleChange={handleChange}
      handleClick={handleClick}
    />
  );
}
