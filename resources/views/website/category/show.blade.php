@extends('website.layouts.app')

@section('title', $category->name)
@section('meta_title', $category->name)
@section('meta_description', $category->description)

@section('content')
    <div class="uk-section uk-section-small uk-section-muted padding-remove@m">
        <div class="uk-container">
            <ul class="uk-breadcrumb">
                <li><a href="/">زیگما</a></li>
                @if($category->parent_category->parent_category ?? null)
                <li><a href="/category/{{$category->parent_category->parent_category->id}}">{{$category->parent_category->parent_category->name}}</a>
                </li>
                @endif
                @if($category->parent_category)
                    <li><a
                                href="/category/{{$category->parent_category->id}}">{{$category->parent_category->name}}</a></li>
                @endif
                <li><a href="/category/{{$category->id}}">{{$category->name}}</a></li>
            </ul>
            <front-products :category="{{$category}}" :options="{{$options}}"></front-products>
        </div>
    </div>
@endsection