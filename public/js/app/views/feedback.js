define(['backbone', 'app/models/feedback', 'handlebars'], function (Backbone, FeedbackModel, Handlebars) {
  return Backbone.View.extend({
    className: 'feedback-form',

    events: {
      'submit form': 'sendFeedback'
    },

    initialize: function () {
      this.render();
    },

    sendFeedback: function (e) {
      e.preventDefault();
      this.removeMessages();

      var feedback = new FeedbackModel({
        ruin_id: this.$('#ruin_id').val(),
        ruin: this.$('#ruin').val(),
        body: this.$('#body').val()
      });

      if (feedback.isValid()) {
        feedback.save();
        this.$('#body').val('');
        this.message('success', 'Your message have been sent!');
      } else {
        this.message('error', 'Please enter a message');
      }
    },

    message: function (type, message) {
      this.$el.find('.alert-' + type).html('<p class="validation">' + message + '</p>');
    },

    removeMessages: function () {
      this.$el.find('.alert-error').html('');
      this.$el.find('.alert-success').html('');
    },

    render: function () {
      var ruin = this.model;
      var template = Handlebars.compile($('#feedback-form').html());
      $('.feedback').html(this.$el.html(template(ruin.attributes)));
    }
  });
});
