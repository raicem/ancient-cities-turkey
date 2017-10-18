import React, { Component } from 'react';
import mapboxgl from 'mapbox-gl';

mapboxgl.accessToken =
  'pk.eyJ1IjoicmFpY2VtIiwiYSI6ImNqMjZmaHl6aTAwMmYzM3BqeWVrYnVjODIifQ.iZRVG8IE35SdbbkMhnK9ow';

export default class Map extends Component {
  componentDidMount() {
    this.map = mapboxgl.Map({
      container: this.mapContainer,
      style: 'mapbox://styles/mapbox/streets-v9',
    });
  }

  render() {
    return <div ref={el => (this.mapContainer = el)} />;
  }
}
