@extends('website.layouts.app')

@section('content')
    <div class="uk-section uk-section-muted">
        <div class="uk-container">
            <front-products :category="{{$category}}" :options="{{$options}}"></front-products>
        </div>
    </div>
@endsection