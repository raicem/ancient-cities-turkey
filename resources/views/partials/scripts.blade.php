<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-11941941-7', 'auto');
    ga('send', 'pageview');
</script>

<script src="{{ asset('js/config.js') }}"></script>
<script src="{{ asset('js/vendor/underscore.js') }}"></script>
<script src="{{ asset('js/vendor/jquery.js') }}"></script>
<script src="{{ asset('js/vendor/backbone.js') }}"></script>
<script src="{{ asset('js/vendor/handlebars.js') }}"></script>
<script src="{{ asset('js/vendor/mapbox-gl.js') }}"></script>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/models.js') }}"></script>
<script src="{{ asset('js/views.js') }}"></script>
<script src="{{ asset('js/router.js') }}"></script>
<script>
    var router = new App.Router();
    
    $(document).on('click', 'a:not([data-bypass])', function (e) {
      var href = $(e.currentTarget).attr('href');
      e.preventDefault();
      router.navigate(href, true);
    });

    var map = new App.Models.App();
    new App.Views.App({
        model: map
    });
    
    Backbone.history.start({ pushState: true });
</script>

