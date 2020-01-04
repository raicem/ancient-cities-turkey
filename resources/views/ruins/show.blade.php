@extends('app')

@section('title')
    {{ $ruin->name }} @lang('messages.ruins.show.meta.title') - @lang('messages.meta.title')
@endsection
@section('seo')
    <meta name="keywords" content="{{ $ruin->name }}">
    <meta name="description" content="{{ $ruin->information }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ruin->name }} @lang('messages.ruins.show.meta.title') - @lang('messages.meta.title')">
    <meta name="twitter:description" content="{{ $ruin->information }}">
    <meta name="twitter:image" content="{{ $ruin->image ? url($ruin->image) : '' }}">
    <meta property="og:url" content="{{ request()->url() }}"/>
    <meta property="og:title" content="{{ $ruin->name }} @lang('messages.ruins.show.meta.title') - @lang('messages.meta.title')"/>
    <meta property="og:description" content="{{ $ruin->information }}"/>
    <meta property="og:image" content="{{ $ruin->image ? url($ruin->image) : '' }}"/>
@endsection
@section('content')
    <div id="root"></div>
    <noscript>@lang('messages.javascript.warning')</noscript>
@endsection
@section('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@endsection
