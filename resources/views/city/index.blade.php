@extends('app')

@section('title')
    {{ $city->name }} Antik Kentleri
@endsection
@section('seo')
    <meta name="keywords" content="@lang('messages.cities.list.ancientCities', ['city' => $city->name])">
    <meta name="description" content="@lang('messages.cities.list.ancientCities', ['city' => $city->name])">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@lang('messages.cities.list.ancientCities', ['city' => $city->name])">
    <meta name="twitter:description"
          content="@lang('messages.cities.list.description', ['city' => $city->name, 'count' => $ruins->count()])">
    <meta name="twitter:image" content="{{ url($ruins->first->image) }}">
    <meta property="og:url" content="{{ request()->url() }}"/>
    <meta property="og:title" content="@lang('messages.cities.list.ancientCities', ['city' => $city->name])"/>
    <meta property="og:description"
          content="{{ $city->name }} ilinde {{$ruins->count()}} tane antik kent bulunmaktadır."/>
    <meta property="og:image" content="{{ url($ruins->first->image) }}"/>
@endsection

@section('content')
    <body class="container">
    @include('partials.header')
    <h1>@lang('messages.cities.list.ancientCities', ['city' => $city->name])</h1>

    @foreach($ruins as $ruin)
        <div class="site-ruin">
            <h2 class="site_ruin__title">{{ $ruin->name }}</h2>
            <div>
                <img class="site-ruin__image" src="{{ url($ruin->image) }}" alt="">
            </div>
            <p class="site-ruin__description">{{$ruin->information}}</p>
            <a href="/tr/{{$ruin->slug}}">@lang('messages.cities.list.more')</a>
        </div>
    @endforeach

    </body>
@endsection
