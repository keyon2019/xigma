@extends('website.layouts.app')

@section('title', $category->name)
@section('meta_title', $category->name)
@section('meta_description', $category->description)

@section('content')
    @if($category->show_slider)
        <div class="uk-background-muted">
            <div class="uk-container">
                <img src="/{{$category->wide_splash}}" class="uk-width-expand uk-margin-top uk-border-rounded" uk-img>
            </div>
        </div>
    @endif
    <div class="uk-section uk-section-small uk-section-muted padding-remove@m">
        <div class="uk-container">
            <ul class="uk-breadcrumb">
                <li><a href="/">زیگما</a></li>
                @if($ans1 = $category->parentCategory->parentCategory ?? null)
                    <li><a href="/category/{{$ans1->id}}">{{$ans1->name}}</a>
                    </li>
                @endif
                @if($ans2 = $category->parentCategory ?? null)
                    <li><a
                                href="/category/{{$ans2->id}}">{{$ans2->name}}</a></li>
                @endif
                <li><a href="/category/{{$category->id}}">{{$category->name}}</a></li>
            </ul>
            <front-products :category="{{$category}}" :options="{{$options}}"></front-products>
        </div>
    </div>
@endsection