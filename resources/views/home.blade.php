@extends('app')
@section('title')
    Ancient Cities Turkey
@endsection
@section('content')
    <div id="map"></div>
    <div class="info-bar-container"></div>
    @include('partials.sidebar-handlebars')
    @include('partials.feedback-handlebars')
@endsection
@section('scripts')
    @include('partials/scripts')
@endsection