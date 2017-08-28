<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <title>@yield('title')</title>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no'/>
    <meta name="keywords" content="ancient cities, antique cities, turkey, ruins, historical sites">
    <meta name="description" content="Map of Ancient Cities in Turkey. You can get discover new places with useful links to history, visiting and much more.">
    <link href='{{ asset('css/mapbox-gl.css') }}' rel='stylesheet'/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/vendor/require.js') }}" data-main="{{ asset('js/app') }}"></script>
</head>
<body>

@yield('content')
@yield('scripts')
</body>
</html>
