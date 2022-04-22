@extends('website.layouts.app')

@section('title', $category->name)
@section('meta_title', $category->name)
@section('meta_description', $category->description)

@section('content')
    <div class="uk-section uk-section-small uk-section-muted padding-remove@m">
        <div class="uk-container">
            <ul class="uk-breadcrumb">
                <li><a href="/">زیگما</a></li>
                @if($ans1 = $category->parentCategory->parentCategory)
                <li><a href="/category/{{$ans1->id}}">{{$ans1->name}}</a>
                </li>
                @endif
                @if($ans2 = $category->parentCategory)
                    <li><a
                                href="/category/{{$ans2->id}}">{{$ans2->name}}</a></li>
                @endif
                <li><a href="/category/{{$category->id}}">{{$category->name}}</a></li>
            </ul>
            <front-products :category="{{$category}}" :options="{{$options}}"></front-products>
        </div>
    </div>
@endsection