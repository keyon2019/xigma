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

    {{-- Newest Grid Sale --}}
    @include('website.partials._productSlideshow', [
        'muted' => true,
        'title' => 'جدیدترین قطعات',
        'link' => '#',
        'items' => $topProducts->newest()
    ])

    {{-- Newest Grid Sale 2 --}}
    @include('website.partials._productSlideshow', [
        'muted' => false,
        'title' => "جدیدترین قطعات موتورسیکلت",
        'link' => '#',
        'items' => $topProducts->newest(\App\Models\Category::first())
    ])

    {{-- Newest Grid Sale 3 --}}
    <div class="uk-section">
        <div class="uk-container">
            <div class="uk-grid uk-flex uk-flex-middle">
                <div class="uk-width-expand"><h2 class="uk-text-lead">پرفروش‌ترین قطعات</h2></div>
                {{--<div class="uk-width-auto"><a class="uk-text-primary"><span>نمایش تمام قطعات</span><span--}}
                {{--data-uk-icon="chevron-left" class="uk-margin-small-left"></span></a></div>--}}
            </div>
            <div data-uk-slider dir="ltr">
                <div class="uk-position-relative uk-visible-toggle">
                    <div class="uk-slider-container" style="padding: 2rem 1em">
                        <ul class="uk-slider-items uk-child-width-1-4@m uk-child-width-1-3@s uk-child-width-1-1 uk-grid uk-grid-small">
                            @foreach($topProducts->popular() as $product)
                                <li>
                                    <div class="uk-card product-card uk-box-shadow-hover-medium" style="border-radius: 0.6em">
                                        <a href="#">
                                            <img src="{{$product->splashUrl}}" class="uk-width-expand">
                                        </a>
                                        <div class="uk-padding-small">
                                            <p class="uk-text-secondary uk-margin-remove uk-text-medium uk-text-center">{{$product->name}}</p>
                                            <p class="uk-text-secondary uk-margin-remove-top uk-text-medium uk-text-light uk-text-center">
                                                Xigma 135 Civic</p>
                                            <p class="uk-margin-remove uk-display-inline-block uk-width-1-1">
                                                <span class="uk-float-right uk-text-meta">CUB</span>
                                                <span class="uk-float-left uk-text-meta">کلاس</span>
                                            </p>
                                            <p class="uk-margin-remove uk-display-inline-block uk-width-1-1">
                                                <span class="uk-float-left uk-text-meta">نوع</span>
                                                <span class="uk-float-right uk-text-meta">انژکتور</span>
                                            </p>
                                            <div class="uk-grid uk-grid-collapse uk-flex uk-flex-middle uk-margin-remove uk-text-muted" uk-grid>
                                                <div class="uk-width-expand">
                                                    <stars-rating size="0.7" rating="{{$product->rating}}"></stars-rating>
                                                </div>
                                                <div>مقبولیت</div>
                                            </div>
                                            {{--</p>--}}
                                            {{--<p class="uk-margin-remove uk-display-inline-block uk-width-1-1">--}}
                                            {{--<span class="uk-float-left uk-text-meta">مقبولیت</span>--}}
                                            {{--<span class="uk-float-right uk-text-meta">--}}
                                            {{--<stars-rating size="0.7" rating="{{$product->rating}}"></stars-rating>--}}
                                            {{--</span>--}}
                                            {{--</p>--}}
                                            <p class="uk-margin-remove uk-display-inline-block uk-width-1-1">
                                                <span class="uk-float-right uk-text-medium">{{number_format($product->price)}}</span>
                                                <span class="uk-float-left uk-text-medium uk-text-normal">تومان</span>
                                            </p>
                                            <a href="/product/{{$product->id}}"
                                               class="uk-button uk-button-success uk-text-white uk-width-expand uk-margin-small-bottom">
                                                <span>اضافه به سبد خرید</span><span class="uk-margin-small-right"
                                                                                    data-uk-icon="cart"></span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <a class="uk-position-center-left-out uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
                    <a class="uk-position-center-right-out uk-position-small" href="#" uk-slidenav-previous
                       uk-slider-item="previous"></a>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    import StarsRating from "../../js/components/StarsRating";

    export default {
        components: {StarsRating}
    }
</script>