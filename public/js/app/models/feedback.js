define(['backbone'], function (Backbone) {
  return Backbone.Model.extend({
    urlRoot: '/api/feedback',

    validate: function (attrs) {
      if (attrs.body.length < 1) {
        return 'Please enter a message';
      }
    }
  });
});
