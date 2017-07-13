define(['backbone'], function (Backbone) {
  return Backbone.Model.extend({
    idAttribute: 'slug',

    urlRoot: function () {
      if (this.get('language') === 'tr') {
        return '/api/tr/ruins';
      }
      return '/api/ruins';
    },

    getCoordinates: function () {
      return [this.get('longitude'), this.get('latitude')];
    }
  });
});
