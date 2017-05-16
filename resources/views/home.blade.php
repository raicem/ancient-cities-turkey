@extends('app')
@section('title')
    Ancient Cities Turkey
@endsection
@section('content')
    <div id="map"></div>

    @include('partials/sidebar-mustache')
@endsection
@section('scripts')
    @include('partials/scripts')
@endsection