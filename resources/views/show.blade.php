@extends('app')
@section('title')
    {{ $ruin->name }}
@endsection
@section('content')
    <div id="map"></div>
    <div class="info-bar-container">
        <div class="info-bar" data-slug="{{ $ruin->slug }}" data-server>
            <div>
                <button class="button button-red close-button">Close</button>
            </div>
            <div class="ruin-info">
                <div class="info-bar-image" style="background-image: url({{ asset('img/ruins/' . $ruin->image) }})"></div>
                <h3 class="link-list-title">{{ $ruin->name }}</h3>
                <p class="info-bar-description">{{ $ruin->information }}</p>
                <ul class="image-list flex">
                    <li class="image-list-item">
                        <a data-bypass
                           href="http://maps.apple.com/?ll={{ $ruin->latitude }},{{ $ruin->longitude }}"
                           class="info-bar-map-link">
                            <img src="/img/map.png" alt="">
                        </a>
                    </li>
                    @if($ruin->tripadvisor)
                        <li class="image-list-item">
                            <a data-bypass href="{{ $ruin->tripadvisor }}">
                                <img src="/img/tripadvisor.png" alt="">
                            </a>
                        </li>
                    @endif
                    @if($ruin->foursquare)
                        <li class="image-list-item">
                            <a data-bypass href="{{ $ruin->foursquare }}">
                                <img src="/img/foursquare.png" alt="">
                            </a>
                        </li>
                    @endif
                </ul>
                <ul class="link-list">
                    <h4 class="link-list-title">Resources in English</h4>
                    @foreach($ruin->englishLinks as $link)
                        <li class="link-list-item">
                            <a data-bypass href="{{$link->url}}">{{$link->description}}</a>
                        </li>
                    @endforeach
                    <h4 class="link-list-title">Türkçe Kaynaklar</h4>
                    @foreach($ruin->turkishLinks as $link)
                        <li class="link-list-item">
                            <a data-bypass href="{{$link->url}}">{{$link->description}}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="feedback">
                    <button class="feedback-button">Report Issue</button>
                </div>
                <div class="lang-buttons">
                    <a href="/tr/{{ $ruin->slug }}">
                        türkçe
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('partials.sidebar-handlebars')
    @include('partials.feedback-handlebars')
@endsection
@section('scripts')
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-11941941-7', 'auto');
      ga('send', 'pageview');
    </script>
@endsection
