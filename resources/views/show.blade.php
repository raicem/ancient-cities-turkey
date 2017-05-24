@extends('app')
@section('title')
    {{ $ruin->name }}
@endsection
@section('content')
    <div id="map"></div>
    <div class="info-bar" data-slug="{{ $ruin->slug }}">
        <div>
            <button class="close-button">Close</button>
        </div>
        <div class="ruin-info">
            <div class="info-bar-image" style="background-image: url({{ $ruin->image }})"></div>
            <h3 class="info-bar-title">{{ $ruin->name }}</h3>
            <p class="info-bar-description">{{ $ruin->information }}</p>
            <ul class="info-bar-link-list">
                <li>
                    <a data-bypass
                        href="http://maps.apple.com/?ll={{ $ruin->latitude }},{{ $ruin->longitude }}"
                        class="info-bar-map-link">Open in default Maps App</a>
                </li>
                @if($ruin->tripadvisor)
                    <li><a data-bypass href="{{ $ruin->tripadvisor }}">TripAdvisor</a></li>
                @endif
                @if($ruin->foursquare)
                    <li><a data-bypass href="{{ $ruin->foursquare }}">Foursquare</a></li>
                @endif
            </ul>
            <ul class="info-bar-link-list">
                <h4 class="info-bar-title">Resources in English</h4>
                @foreach($ruin->englishLinks as $link)
                    <li class="info-bar-link"><a data-bypass href="{{$link->url}}">{{$link->description}}</a></li>
                @endforeach
                <h4 class="info-bar-title">Türkçe Kaynaklar</h4>
                @foreach($ruin->turkishLinks as $link)
                    <li class="info-bar-link"><a data-bypass href="{{$link->url}}">{{$link->description}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    @include('partials/sidebar-mustache');
@endsection
@section('scripts')
    @include('partials/scripts')
@endsection
