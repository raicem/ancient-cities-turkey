define(['backbone'], function (Backbone) {
  return Backbone.Router.extend({
    routes: {
      ':slug': 'show',
      ':lang/:slug': 'show'
    },

    initialize: function () {
      this.bind('route', this.pageView);
    },

    show: function (lang, slug) {
      var language = lang || 'en';
      vent.trigger('language:check', language);
      // decide if there is a server side rendered portion on the page
      if ($('.info-bar[data-server]').length) {
        vent.trigger('ruin:show-server', slug, language);
      } else {
        vent.trigger('ruin:show', slug, language);
      }
    },

    pageView: function () {
      var path = Backbone.history.getFragment();
      // ga('send', 'pageview', { page: '/' + path });
    }
  });
});
