define(['backbone', 'mapboxgl', 'app/config'],
  function (Backbone, mapboxgl, config) {
    return Backbone.Model.extend({
      initialize: function initialize () {
        var map;
        mapboxgl.accessToken = config.mapboxToken;
        map = new mapboxgl.Map({
          container: 'map',
          style: 'mapbox://styles/mapbox/streets-v9'
        });

        map.addControl(new mapboxgl.NavigationControl(), 'top-left');
        map.addControl(new mapboxgl.GeolocateControl());
        map.fitBounds([[25.059009, 35.259924], [45.351057, 42.210808]]);
        this.map = map;
      }
    });
  });
