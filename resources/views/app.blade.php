<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">

<head>
	<meta charset='utf-8' />
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>@yield('title')</title>
	@yield('seo')
	<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ mix('css/app.css') }}"> 
	@yield('head-scripts')
</head>

<body>

	@yield('content') 
	@yield('scripts')
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