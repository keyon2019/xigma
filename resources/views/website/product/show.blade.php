@extends('website.layouts.app')

@section('title', $product->name)
@section('meta_title', $product->name)
@section('meta_description', strip_tags($product->description))

@section('content')
    <div class="uk-section-xsmall uk-section-default">
        <front-product :category="{{$category}}" :product="{{$product}}">
            <div class="uk-margin uk-margin-remove-bottom">@include('website.partials._productSlideshow', ['items' => \App\Models\Product::limit(6)->get(), 'title' => 'قطعات مرتبط با انتخاب شما', 'muted' => true])</div>
        </front-product>
    </div>
    <div class="uk-section-muted uk-margin-top">
        @if($topProducts->discounted()->count() > 0)
            @include('website.partials._specialSaleSlideshow', ['items' => $topProducts->discounted()])
        @endif
    </div>
@endsection