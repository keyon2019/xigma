@extends('website.layouts.app')

@section('content')
    <div class="uk-section-xsmall uk-section-default">
        <front-product :product="{{$product}}">
            <div class="uk-margin">@include('website.partials._productSlideshow', ['items' => \App\Models\Product::limit(6)->get(), 'title' => 'قطعات مرتبط با انتخاب شما', 'muted' => true])</div>
        </front-product>
    </div>
    <div class="uk-section-muted uk-margin-top">
        @include('website.partials._specialSaleSlideshow', ['items' => \App\Models\Product::limit(6)->get(), 'title' => 'قطعات مرتبط با انتخاب شما', 'muted' => true])
    </div>
@endsection