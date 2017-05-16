(function () {
    window.App = {
        Models: {},
        Views: {},
        Collections: {},
        Router: {}
    };

    window.vent = _.extend({}, Backbone.Events);
})();

App.Router = Backbone.Router.extend({
    routes: {
        ':slug': 'show'
    },

    show: function (slug) {
        vent.trigger('ruin:show', slug);
    }
});

App.Models.App = Backbone.Model.extend({
    initialize: function () {
        mapboxgl.accessToken = Config.mapboxToken;
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v9'
        });

        map.addControl(new mapboxgl.NavigationControl(), 'top-left');
        map.addControl(new mapboxgl.GeolocateControl());
        var deneme = map.fitBounds([[25.059009, 35.259924], [45.351057, 42.210808]]);
        this.map = map;
    }
});

App.Views.App = Backbone.View.extend({
    initialize: function () {
        var map = this.model.map;

        vent.on('mapLoaded', this.addLayers, this);
        vent.on('mapLoaded', this.attach, map);
        vent.on('ruin:show', this.showRuin, this);
        vent.on('ruin:hide', this.hideRuin, this);

        map.on('load', function () {
            vent.trigger('mapLoaded');
        });

        $(document).on("click", "a:not([data-bypass])", function (e) {
            e.preventDefault(); // This is important
            var href = $(e.currentTarget).attr('href');
            router.navigate(href, true); // <- this part will pass the path to your router
        });

            var infoBar = $('.info-bar');
        if (infoBar.length) {
            this.showRuin(infoBar.data('slug'), true)
        }
    },

    showRuin: function (slug, fromDom) {
        this.hideRuin();
        var ruin = new App.Models.Ruin({
            "slug": slug
        });

        if (fromDom === true) {
            this.ruinView = new App.Views.Ruin({model: ruin, el: $('.info-bar')});
        } else {
            this.ruinView = new App.Views.Ruin({model: ruin});
        }
    },

    hideRuin: function () {
        // eğer görüntüde bir ruin var ise çalışır.
        if (typeof this.ruinView !== 'undefined') {
            this.ruinView.unrender();
        }
    },

    addLayers: function () {
        this.model.map.addLayer({
            "id": "points",
            "type": "symbol",
            "source": {
                "type": "geojson",
                "data": "/api/ruins"
            },
            "layout": {
                "icon-image": "star-15"
            }
        });
    },

    attach: function () {
        var map = this;
        map.on('click', 'points', function (e) {
            var feature = e.features[0];
            var popup = new mapboxgl.Popup({
                closeButton: false
            });
            popup.setLngLat(feature.geometry.coordinates)
                .setHTML(feature.properties.title + "<br><a href='/" + feature.properties.slug + "' class='link'>More...</a>")
                .addTo(map);
        });

        map.on('click', function (e) {
            var features = map.queryRenderedFeatures(e.point, {layers: ['points']});
            if (!features.length) {
                vent.trigger('ruin:hide');
                router.navigate('/');
            }
        });

        map.on('mouseenter', 'points', function () {
            map.getCanvas().style.cursor = 'pointer';
        });

        map.on('mouseleave', 'points', function () {
            map.getCanvas().style.cursor = '';
        });
    }
});

App.Models.Ruin = Backbone.Model.extend({
    idAttribute: 'slug',
    urlRoot: "api/ruins"
});

App.Views.Ruin = Backbone.View.extend({
    className: 'info-bar',
    events: {
        'click .close-button': 'close'
    },

    close: function () {
        vent.trigger('ruin:hide');
    },

    initialize: function () {
        var that = this;
        this.model.fetch().then(function () {
            $(document).attr('title', that.model.get('name'));
            that.render();
        })
    },

    render: function () {
        var template = Handlebars.compile($('#ruin-bar').html());
        this.$el.html(template(this.model.attributes));

        $(document.body).append(this.el);
        $(this.el).addClass('show-info-bar');
    },

    unrender: function () {
        $(document).attr('title', 'Ancient Cities Turkey');
        this.remove();
    }
});

var router = new App.Router;
Backbone.history.start({pushState: true});

var map = new App.Models.App;
new App.Views.App({
    model: map
});
