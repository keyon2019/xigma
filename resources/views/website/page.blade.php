@extends('website.layouts.app')

@section('title', $page->name)
@section('meta_title', $page->meta_title)
@section('meta_description', $page->meta_description)

@section('content')
    <div class="uk-section">
        <div class="uk-container">
            <h1 class="uk-heading">{{$page->name}}</h1>
            <hr/>
            <div class="ck-content">
                {!! $page->content !!}
            </div>
        </div>
    </div>
@endsection

