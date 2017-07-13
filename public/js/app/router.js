define(['backbone'], function (Backbone) {
  return Backbone.Router.extend({
    routes: {
      ':slug': 'show',
      'tr/:slug': 'showTurkish'
    },

    initialize: function () {
      this.bind('route', this.pageView);
    },

    show: function (slug) {
      // decide if there is a server side rendered portion on the page
      if ($('.info-bar[data-server]').length) {
        vent.trigger('ruin:show-server', slug);
      } else {
        vent.trigger('ruin:show', slug);
      }
    },

    showTurkish: function (slug) {
      vent.trigger('ruin:show-turkish', slug);
    },

    pageView: function () {
      var path = Backbone.history.getFragment();
      // ga('send', 'pageview', { page: '/' + path });
    }
  });
});
