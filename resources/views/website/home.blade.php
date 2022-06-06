@extends('website.layouts.app')

@section('content')
    {{--Main Slider--}}
    <front-main-slider :sliders="{{$sliders}}"></front-main-slider>

    {{-- Special Sale --}}
    @if($topProducts->discounted()->count() > 0)
        @include('website.partials._specialSaleSlideshow', ['items' => $topProducts->discounted()])
    @endif

    <div class="uk-section uk-height-viewport uk-section-muted uk-position-relative uk-overflow-hidden">
        <img src="/uploads/A.svg" alt="" class="big-letter right uk-visible@m uk-height-1-1">
        <div class="uk-container">
            <h1 class="uk-text-center uk-margin-small-top">دسته‌بندی‌های منتخب</h1>
            <div class="uk-grid uk-grid-small uk-child-width-1-4@m uk-child-width-1-2 uk-grid-match uk-margin-large-top" data-uk-grid>
                @foreach(\App\Models\Category::whereFeatured(true)->limit(8)->get() as $category)
                    <div>
                        <a href="/category/{{$category->id}}" class="category-in-grid uk-background-default">
                            <img src="{{$category->splash}}" class="uk-width-expand uk-border-rounded">
                        </a>
                        <div class="uk-margin-small-top uk-text-center uk-text-truncate">{{$category->name}}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @foreach($widgets as $widget)
        @include('website.partials._productSlideshow', [
        'muted' => $widget->order % 2 === 0,
        'title' => ($widget->type === 1 ? "جدیدترین‌های " : "محبوب‌ترین‌های ") . ($widget->categoryItSelf ? $widget->categoryItSelf->name : "محصولات"),
        'link' => "/category/$widget->category?sort=" . ($widget->type === 1 ? 'latest' : 'popular'),
        'items' => $widget->type === 1 ? $topProducts->newest($widget->categoryItSelf) : $topProducts->popular($widget->categoryItSelf)
    ])
    @endforeach


@endsection