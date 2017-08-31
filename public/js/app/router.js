define(['backbone'], function (Backbone) {
  return Backbone.Router.extend({
    routes: {
      ':slug': 'showWithoutLang',
      ':lang/about': 'showAbout',
      ':lang/:slug': 'show'
    },

    initialize: function () {
      this.bind('route', this.pageView);
    },

    showWithoutLang: function (slug) {
      vent.trigger('ruin:showWithoutLang', slug);
    },

    showAbout: function (lang) {
      vent.trigger('about:show', lang);
    },

    show: function (lang, slug) {
      var language = lang || 'en';

      vent.trigger('language:check', language);
      vent.trigger('ruin:show', slug, language);
    },

    pageView: function () {
      var path = Backbone.history.getFragment();
      ga('send', 'pageview', { page: '/' + path });
    }
  });
});
