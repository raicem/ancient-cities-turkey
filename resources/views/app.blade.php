<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8' />
	<title>@yield('title')</title>
	<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
	<meta name="keywords" content="@lang('messages.meta.keywords')">
	<meta name="description" content="@lang('messages.meta.description')">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="@lang('messages.meta.title')">
	<meta name="twitter:description" content="@lang('messages.meta.description')">
	<meta name="twitter:image" content="https://ancientcitiesturkey.com/img/preview.png">
	<meta property="og:url" content="https://ancientcitiesturkey.com" />
	<meta property="og:title" content="@lang('messages.meta.title')" />
	<meta property="og:description" content="@lang('messages.meta.description')" />
	<meta property="og:image" content="https://ancientcitiesturkey.com/img/preview.png" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ mix('css/app.css') }}"> 
	@yield('head-scripts')
</head>

<body>

	@yield('content') @yield('scripts')
	<script src="{{ mix('js/app.js') }}"></script>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-11941941-7', 'auto');
      ga('send', 'pageview');
	</script>
</body>

</html>