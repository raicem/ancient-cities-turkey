import axios from 'axios';
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Map from './components/Map';

window.axios = axios;

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

class App extends Component {
  render() {
    return <Map />;
  }
}

ReactDOM.render(<App />, document.getElementById('root'));
