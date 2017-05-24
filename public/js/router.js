App.Router = Backbone.Router.extend({
  routes: {
    ':slug': 'show'
  },

  initialize: function () {
    this.bind('route', this.pageView);
  },

  show: function (slug) {
    vent.trigger('ruin:show', slug);
  },

  pageView: function () {
    var path = Backbone.history.getFragment();
    ga('send', 'pageview', { page: '/' + path });
  }
});
