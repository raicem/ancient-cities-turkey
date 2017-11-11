@extends('app')

@section('title')
    Ancient Cities Turkey
@endsection
@section('content')
    <div id="root"></div>
    {{--  <div id="map"></div>
    <div class="info-bar-container"></div>
    @include('partials.sidebar-handlebars')
    @include('partials.feedback-handlebars')
    @include('partials.about-handlebars')  --}}
@endsection
@section('scripts')
    <script src="{{ asset('js/react/app.js') }}"></script>
    {{--  <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-11941941-7', 'auto');
      ga('send', 'pageview');
    </script>  --}}
@endsection