@extends('app')

@section('title')
    @lang('messages.meta.title')
@endsection
@section('seo')
    <meta name="keywords" content="@lang('messages.meta.keywords')">
    <meta name="description" content="@lang('messages.meta.description')">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@lang('messages.meta.title')">
    <meta name="twitter:description" content="@lang('messages.meta.description')">
    <meta name="twitter:image" content="https://ancientcitiesturkey.com/img/preview.png">
    <meta property="og:url" content="https://ancientcitiesturkey.com"/>
    <meta property="og:title" content="@lang('messages.meta.title')"/>
    <meta property="og:description" content="@lang('messages.meta.description')"/>
    <meta property="og:image" content="https://ancientcitiesturkey.com/img/preview.png"/>
@endsection
@section('content')
    <div id="root"></div>
@endsection
@section('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@endsection