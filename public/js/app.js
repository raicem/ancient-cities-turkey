require.config({
  baseUrl: '/js',
  paths: {
    jquery: 'vendor/jquery',
    backbone: 'vendor/backbone',
    underscore: 'vendor/underscore',
    mapboxgl: 'vendor/mapbox-gl',
    ga: '//www.google-analytics.com/analytics',
    handlebars: 'vendor/handlebars',
    i18next: 'vendor/i18next'
  }
});

require(['backbone', 'app/router', 'app/models/map', 'app/views/map', 'i18next'],
  function (Backbone, Router, Map, MapView, i18next) {
    window.router = new Router();
    window.vent = _.extend({}, Backbone.Events);
    window.i18next = i18next;

    $(document).on('click', 'a:not([data-bypass])', function (e) {
      var href = $(e.currentTarget).attr('href');
      e.preventDefault();
      router.navigate(href, true);
    });

    var mapView = new MapView({
      model: new Map()
    });

    i18next.init({
      lng: 'en',
      debug: true,
      resources: {
        en: {
          translation: {
            reportIssue: 'Report Issue',
            reportIssuePlaceholder: 'Placeholder',
            close: 'Close',
            englishResources: 'English Resources',
            turkishResources: 'Turkish Resources',
            turkish: 'Turkish',
            english: 'English',
            send: 'Send',
            visitingInfo: 'Visiting Info'
          }
        },
        tr: {
          translation: {
            reportIssue: 'Hata Bildir',
            reportIssuePlaceholder: 'Placeholder',
            close: 'Kapat',
            englishResources: 'İngilizce Kaynaklar',
            turkishResources: 'Türkçe Kaynaklar',
            turkish: 'Türkçe',
            english: 'İngilizce',
            send: 'Gönder',
            visitingInfo: 'Ziyaret Bilgileri'
          }
        }
      }
    });

    function updateContent() {
      document.getElementById('reportIssue').innerHTML = i18next.t('reportIssue');
      document.getElementById('close').innerHTML = i18next.t('close');
      document.getElementById('englishResources').innerHTML = i18next.t('englishResources');
      document.getElementById('turkishResources').innerHTML = i18next.t('turkishResources');
      document.getElementById('turkish').innerHTML = i18next.t('turkish');
      document.getElementById('english').innerHTML = i18next.t('english');
      document.getElementById('send').innerHTML = i18next.t('send');
      document.getElementById('visitingInfo').innerHTML = i18next.t('visitingInfo');
    }

    i18next.on('languageChanged', function () {
      updateContent();
    });


    Backbone.history.start({ pushState: true });
  });
