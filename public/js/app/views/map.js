define(['backbone', 'mapboxgl', 'app/models/ruin', 'app/views/ruin', 'i18next'],
  function (Backbone, mapboxgl, RuinModel, RuinView, i18next) {
    return Backbone.View.extend({
      initialize: function () {
        var appView = this;

        vent.on('ruin:show', this.showRuin, this);
        vent.on('ruin:showWithoutLang', this.showRuinWithoutLang, this);
        vent.on('language:changed', this.languageChange, this);

        this.model.map.on('load', function () {
          appView.addLayers();
          appView.attach(appView.model.get('lang'));
        });
      },

      showRuin: function (slug, language) {
        var ruin = new RuinModel({ slug: slug, language: language });
        this.ruinView = new RuinView({ model: ruin });
      },

      showRuinWithoutLang: function (slug) {
        var lang = this.model.get('lang');
        router.navigate('/' + lang + '/' + slug, { trigger: true });
      },

      languageChange: function (lang) {
        this.model.map.off('click');
        this.attach(lang);

        localStorage.setItem('lang', lang);
        this.model.set({ lang: lang });

        i18next.changeLanguage(lang);
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
            'icon-image': 'star-15',
            'icon-allow-overlap': true
          }
        });
      },

      attach: function (language) {
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
            thisView.addPopup(feature, language);
          }
        });

        map.on('mouseenter', 'points', function () {
          map.getCanvas().style.cursor = 'pointer';
        });

        map.on('mouseleave', 'points', function () {
          map.getCanvas().style.cursor = '';
        });
      },

      addPopup: function (feature, language) {
        var lang = language || 'tr';

        var name = 'name_' + lang;

        var link = '/' + lang + '/' + feature.properties.slug;
        var html = '<a href=' + link + ' class="level link"><p>' + feature.properties[name] +
          '</p><img src="/img/info.jpg" class="info-image"></a>';

        var popup = new mapboxgl.Popup({
          closeButton: false
        });

        popup.setLngLat(feature.geometry.coordinates)
          .setHTML(html)
          .addTo(this.model.map);
      }
    });
  });
