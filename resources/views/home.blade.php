@extends('app')

@section('title')
    @lang('messages.meta.title')
@endsection
@section('content')
    <div id="root"></div>
@endsection
@section('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@endsection