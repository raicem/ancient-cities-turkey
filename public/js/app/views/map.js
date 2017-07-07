define(['backbone', 'mapboxgl', 'app/models/ruin', 'app/views/ruin'], function (Backbone, mapboxgl,RuinModel, RuinView) {
  return Backbone.View.extend({
    initialize: function () {
      var appView = this;

      vent.on('ruin:show', this.showRuin, this);
      vent.on('ruin:show-server', this.showRuinServer, this);

      this.model.map.on('load', function () {
        appView.addLayers();
        appView.attach();
      });
    },

    showRuin: function (slug) {
      var ruin = new RuinModel({ slug: slug });
      this.ruinView = new RuinView({ model: ruin });
    },

    showRuinServer: function (slug) {
      var thisView = this;
      var ruin = new RuinModel({ slug: slug });

      ruin.fetch().then(function () {
        thisView.addPopup(ruin.getCoordinates(), ruin.get('name'),
          ruin.get('slug'));
      });

      this.ruinView = new RuinView({ model: ruin });
    },

    addLayers: function () {
      this.model.map.addLayer({
        id: 'points',
        type: 'symbol',
        source: {
          type: 'geojson',
          data: '/api/ruins'
        },
        layout: {
          'icon-image': 'star-15'
        }
      });
    },

    attach: function () {
      var thisView = this;
      var map = this.model.map;

      map.on('click', function (e) {
        var features = map.queryRenderedFeatures(e.point,
          { layers: ['points'] });
        var feature = features[0];
        if (!features.length) {
          vent.trigger('ruin:hide');
          router.navigate('/');
        } else {
          thisView.addPopup(
            feature.geometry.coordinates,
            feature.properties.name,
            feature.properties.slug
          );
        }
      });

      map.on('mouseenter', 'points', function () {
        map.getCanvas().style.cursor = 'pointer';
      });

      map.on('mouseleave', 'points', function () {
        map.getCanvas().style.cursor = '';
      });
    },

    addPopup: function (coordinates, name, slug) {
      var popup = new mapboxgl.Popup({
        closeButton: false
      });
      popup.setLngLat(coordinates).setHTML(name + '<br><a href=\'/' +
        slug + '\' class=\'link\'>More...</a>').addTo(this.model.map);
    }
  });
});