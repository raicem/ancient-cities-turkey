define(['backbone', 'mapboxgl', 'app/config', 'i18next'],
  function (Backbone, mapboxgl, config) {
    return Backbone.Model.extend({
      initialize: function () {
        var map;

        this.determineUserLanguage();
        vent.on('language:check', this.changeLanguage, this);

        mapboxgl.accessToken = config.mapboxToken;
        map = new mapboxgl.Map({
          container: 'map',
          style: 'mapbox://styles/mapbox/streets-v9'
        });

        map.addControl(new mapboxgl.NavigationControl(), 'top-left');
        map.addControl(new mapboxgl.GeolocateControl());
        map.fitBounds([[25.059009, 35.259924], [45.351057, 42.210808]]);
        this.map = map;
      },

      determineUserLanguage: function () {
        var lang = localStorage.getItem('lang');

        if (lang === null) {
          lang = navigator.language || navigator.userLanguage;
          lang = lang.substring(0, 2);
        }

        if (lang !== 'en' && lang !== 'tr') {
          lang = 'en';
        }

        this.set({ lang: lang });
      },

      changeLanguage: function (language) {
        var currentLang = this.get('lang');

        if (currentLang !== language) {
          vent.trigger('language:changed', language);
        }
      }
    });
  });
