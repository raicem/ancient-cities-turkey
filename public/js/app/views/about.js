define(['backbone', 'handlebars'], function (Backbone, Handlebars) {
  return Backbone.View.extend({
    className: 'info-bar',

    events: {
      'click .close-button': 'close'
    },

    initialize: function (options) {
      $(document).attr('title', 'About');
      this.render(options.lang);
    },

    close: function () {
      this.unrender();
    },

    render: function (lang) {
      var template = Handlebars.compile($('#about-page-' + lang).html());
      $('.info-bar-container').html(this.$el.html(template()));
      i18next.changeLanguage(lang);
    },

    unrender: function () {
      $(document).attr('title', 'Ancient Cities Turkey');
      this.remove();
      router.navigate('/');
    }
  });
});
