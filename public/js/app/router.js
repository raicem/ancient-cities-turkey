define(['backbone'], function (Backbone) {
  return Backbone.Router.extend({
    routes: {
      'hakkinda': 'showAboutTr',
      'about': 'showAboutEn',
      ':slug': 'showWithoutLang',
      ':lang/:slug': 'show'
    },

    initialize: function () {
      this.bind('route', this.pageView);
    },

    showWithoutLang: function (slug) {
      vent.trigger('ruin:showWithoutLang', slug);
    },

    showAboutTr: function () {
      vent.trigger('about:show', 'tr');
    },

    showAboutEn: function () {
      vent.trigger('about:show', 'en');
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
