App.Views.App = Backbone.View.extend({
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
    var ruin = new App.Models.Ruin({ slug: slug });
    this.ruinView = new App.Views.Ruin({ model: ruin });
  },

  showRuinServer: function (slug) {
    var thisView = this;
    var ruin = new App.Models.Ruin({ slug: slug });

    ruin.fetch().then(function () {
      thisView.addPopup(ruin.getCoordinates(), ruin.get('name'),
                ruin.get('slug'));
    });

    this.ruinView = new App.Views.Ruin({ model: ruin });
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

App.Views.Ruin = Backbone.View.extend({
  className: 'info-bar',
  events: {
    'click .close-button': 'close',
    'click button.feedback-button': 'showFeedbackForm'
  },

  close: function () {
    this.unrender();
  },

  showFeedbackForm: function () {
    new App.Views.Feedback({ model: this.model });
  },

  initialize: function () {
    var thisView = this;
    this.model.fetch().then(function () {
      $(document).attr('title', thisView.model.get('name'));
      thisView.render();
    });
  },

  render: function () {
    var template = Handlebars.compile($('#ruin-bar').html());
    this.$el.html(template(this.model.attributes));

    $('.info-bar-container').html(this.el);
  },

  unrender: function () {
    $(document).attr('title', 'Ancient Cities Turkey');
    this.remove();
  }
});

App.Views.Feedback = Backbone.View.extend({
  className: 'feedback-form',

  events: {
    'submit form': 'sendFeedback'
  },

  initialize: function () {
    this.render();
  },

  sendFeedback: function (e) {
    e.preventDefault();
    this.removeMessages();

    var feedback = new App.Models.Feedback({
      ruin_id: this.$('#ruin_id').val(),
      ruin: this.$('#ruin').val(),
      body: this.$('#body').val()
    });

    if (feedback.isValid()) {
      feedback.save();
      this.$('#body').val('');
      this.message('success', 'Your message have been sent!');
    } else {
      this.message('error', 'Please enter a message');
    }
  },

  message: function (type, message) {
    this.$el.find('.alert-' + type).html('<p class="validation">' + message + '</p>');
  },

  removeMessages: function () {
    this.$el.find('.alert-error').html('');
    this.$el.find('.alert-success').html('');
  },

  render: function () {
    var ruin = this.model;
    var template = Handlebars.compile($('#feedback-form').html());
    $('.feedback').html(this.$el.html(template(ruin.attributes)));
  }
});
