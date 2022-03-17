@extends('website.layouts.app')

@section('title', $category->name)
@section('meta_title', $category->name)
@section('meta_description', $category->description)

@section('content')
    <div class="uk-section uk-section-small uk-section-muted padding-remove@m">
        <div class="uk-container">
            <front-products :category="{{$category}}" :options="{{$options}}"></front-products>
        </div>
    </div>
@endsection