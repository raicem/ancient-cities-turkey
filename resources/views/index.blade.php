@extends('app')

@section('content')
<div class="container">
    <h1>Sitemap</h1>
    <ul>
        @foreach($ruins as $ruin)
            <li><a href="/{{ $ruin->slug }}">{{ $ruin->name }}</a></li>
        @endforeach
    </ul>
</div>
@endsection