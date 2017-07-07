define(['backbone'], function (Backbone) {
  return Backbone.Model.extend({
    idAttribute: 'slug',
    urlRoot: 'api/ruins',
    getCoordinates: function () {
      return [this.get('longitude'), this.get('latitude')];
    }
  });
});