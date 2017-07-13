require.config({
  baseUrl: '/js',
  paths: {
    jquery: 'vendor/jquery',
    backbone: 'vendor/backbone',
    underscore: 'vendor/underscore',
    mapboxgl: 'vendor/mapbox-gl',
    ga: '//www.google-analytics.com/analytics',
    handlebars: 'vendor/handlebars'
  }
});

require(['backbone', 'app/router', 'app/models/map', 'app/views/map'],
  function (Backbone, Router, Map, MapView) {
    window.router = new Router();
    window.vent = _.extend({}, Backbone.Events);

    $(document).on('click', 'a:not([data-bypass])', function (e) {
      var href = $(e.currentTarget).attr('href');
      e.preventDefault();
      router.navigate(href, true);
    });

    var mapView = new MapView({
      model: new Map()
    });

    Backbone.history.start({ pushState: true });
  });
