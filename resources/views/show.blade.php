@extends('app')
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
            <a data-bypass href="http://maps.apple.com/?q={{ $ruin->slug }}&sll={{ $ruin->latitude }},{{ $ruin->longitude }}" class="info-bar-map-link">Open in default Maps App</a>
            <ul class="info-bar-link-list">
                @foreach($ruin->links as $link)
                <li class="info-bar-link"><a href="{{$link->url}}">{{$link->description}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    @include('partials/sidebar-mustache');
@endsection
@section('scripts')
    @include('partials/scripts')
@endsection
