define(['backbone'], function (Backbone) {
  return Backbone.Router.extend({
    routes: {
      ':slug': 'showWithoutLang',
      ':lang/:slug': 'show'
    },

    initialize: function () {
      this.bind('route', this.pageView);
    },

    showWithoutLang(slug) {
      vent.trigger('ruin:showWithoutLang', slug);
    },

    show: function (lang, slug) {
      var language = lang || 'en';

      vent.trigger('language:check', language);
      vent.trigger('ruin:show', slug, language);
    },

    pageView: function () {
      var path = Backbone.history.getFragment();
      // ga('send', 'pageview', { page: '/' + path });
    }
  });
});
