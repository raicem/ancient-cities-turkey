<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <title>@yield('title')</title>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no'/>
    <meta name="keywords" content="ancient cities, antique cities, turkey, ruins, historical sites">
    <meta name="description" content="Map of Ancient Cities in Turkey. You can get discover new places with useful links to history, visiting info and much more.">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Ancient Cities of Turkey">
    <meta name="twitter:description" content="Map of Ancient Cities in Turkey. You can get discover new places with useful links to history, visiting info and much more.">
    <meta name="twitter:image" content="/img/preview.jpeg">
    <meta property="og:url" content="http://ancientcitiesturkey.com" />
    <meta property="og:title" content="Ancient Cities of Turkey" />
    <meta property="og:description" content="Map of Ancient Cities in Turkey. You can get discover new places with useful links to history, visiting info and much more." />
    <meta property="og:image" content="/img/preview.jpeg" />
    <link href='{{ asset('css/mapbox-gl.css') }}' rel='stylesheet'/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('head-scripts')
</head>
<body>

@yield('content')
@yield('scripts')
</body>
</html>
