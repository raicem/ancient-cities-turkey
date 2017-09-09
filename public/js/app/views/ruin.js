define(['backbone', 'handlebars', 'app/views/feedback'], function (Backbone, Handlebars, Feedback) {
  return Backbone.View.extend({
    className: 'info-bar',
    events: {
      'click .close-button': 'close',
      'click button.feedback-button': 'showFeedbackForm'
    },

    close: function () {
      this.unrender();
    },

    showFeedbackForm: function () {
      new Feedback({ model: this.model });
    },

    initialize: function () {
      vent.on('ruin:hide', this.unrender, this);

      var thisView = this;
      this.model.fetch().then(function () {
        $(document).attr('title', thisView.model.get('name'));
        thisView.render();
      });
    },

    render: function () {
      var template = Handlebars.compile($('#ruin-bar').html());
      this.$el.html(template(this.model.attributes));

      $('.info-bar-container').html(this.el);
      i18next.changeLanguage(this.model.get('language'));
    },

    unrender: function () {
      $(document).attr('title', 'Ancient Cities Turkey');
      this.remove();
    }
  });
});
