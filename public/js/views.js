App.Views.App = Backbone.View.extend({
  initialize: function () {
    var map = this.model.map;
    var infoBar = $('.info-bar');

    vent.on('mapLoaded', this.addLayers, this);
    vent.on('mapLoaded', this.attach, this);
    vent.on('ruin:show', this.showRuin, this);
    vent.on('ruin:hide', this.hideRuin, this);

    map.on('load', function () {
      vent.trigger('mapLoaded');
    });

    if (infoBar.length) {
      this.showRuin(infoBar.data('slug'), true);
    }
  },

  showRuin: function (slug, fromDom) {
    var thisView = this;

    var ruin = new App.Models.Ruin({
      slug: slug
    });

    this.hideRuin();

    if (fromDom === true) {
      this.ruinView = new App.Views.Ruin(
          { model: ruin, el: $('.info-bar') }
      );

      ruin.fetch().then(function () {
        thisView.addPopup(ruin.getCoordinates(), ruin.get('name'), ruin.get('slug'));
      });
    } else {
      this.ruinView = new App.Views.Ruin({ model: ruin });
    }
  },

  hideRuin: function () {
    // eğer görüntüde bir ruin var ise çalışır.
    if (typeof this.ruinView !== 'undefined') {
      this.ruinView.unrender();
    }
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
      var features = map.queryRenderedFeatures(e.point, { layers: ['points'] });
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
    popup.setLngLat(coordinates)
      .setHTML(name + '<br><a href=\'/' +
        slug + '\' class=\'link\'>More...</a>')
      .addTo(this.model.map);
  }
});


App.Views.Ruin = Backbone.View.extend({
  className: 'info-bar',
  events: {
    'click .close-button': 'close'
  },

  close: function () {
    vent.trigger('ruin:hide');
  },

  initialize: function () {
    var that = this;
    this.model.fetch().then(function () {
      $(document).attr('title', that.model.get('name'));
      that.render();
    });
  },

  render: function () {
    var template = Handlebars.compile($('#ruin-bar').html());
    this.$el.html(template(this.model.attributes));

    $(document.body).append(this.el);
    $(this.el).addClass('show-info-bar');
  },

  unrender: function () {
    $(document).attr('title', 'Ancient Cities Turkey');
    this.remove();
  }
});
