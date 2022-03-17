@extends('website.layouts.app')

@section('content')
    {{--Main Slider--}}
    <front-main-slider :sliders="{{$sliders}}"></front-main-slider>

    {{-- Special Sale --}}

    @include('website.partials._specialSaleSlideshow', ['items' => $topProducts->discounted()])

    {{-- Secondary Slider --}}
    <div>
        <img class="uk-width-expand" src="/uploads/secondary-slider.png">
    </div>

    @foreach($widgets as $widget)
        @include('website.partials._productSlideshow', [
        'muted' => $widget->order % 2 === 0,
        'title' => ($widget->type === 1 ? "جدیدترین‌های " : "محبوب‌ترین‌های ") . ($widget->categoryItSelf ? $widget->categoryItSelf->name : "محصولات"),
        'link' => '',
        'items' => $widget->type === 1 ? $topProducts->newest($widget->categoryItSelf) : $topProducts->popular($widget->categoryItSelf)
    ])
    @endforeach


@endsection