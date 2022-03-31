<div class="uk-section @if($muted ?? false) uk-section-muted @endif">
    <div class="uk-container">
        <div class="uk-grid uk-flex uk-flex-middle uk-margin-bottom">
            <div class="uk-width-expand"><h2 class="uk-text-large uk-text-center uk-text-left@s">{{$title}}</h2></div>
            {{--<div class="uk-width-auto uk-visible@s"><a href="{{$link ?? '#'}}" class="uk-text-primary"><span>نمایش تمام قطعات</span><span--}}
                            {{--data-uk-icon="chevron-left" class="uk-margin-small-left"></span></a></div>--}}
        </div>
        <div data-uk-slider dir="ltr">
            <div class="uk-position-relative uk-visible-toggle">
                <div class="uk-slider-container">
                    <ul class="uk-slider-items uk-child-width-1-4@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid uk-grid-small">
                        @foreach($items as $product)
                            <li>
                                <div class="uk-card product-card uk-box-shadow-hover-medium" style="border-radius: 0.6em;">
                                    <a href="/product/{{$product->id}}">
                                        <img src="{{$product->splashUrl}}" class="uk-width-expand">
                                    </a>
                                    <div class="uk-padding-small">
                                        <p class="uk-text-secondary uk-margin-remove uk-text-medium uk-text-center">{{$product->name}}</p>
                                        <p class="uk-text-secondary uk-margin-remove uk-text-medium uk-text-center">{{$product->en_name}}</p>
                                        <div class="uk-grid uk-grid-collapse uk-flex uk-flex-middle uk-margin-remove uk-text-muted" uk-grid>
                                            <div class="uk-width-expand">
                                                <stars-rating size="0.7" rating="{{$product->rating ?? 3}}"></stars-rating>
                                            </div>
                                            <div class="text-small@m">امتیاز</div>
                                        </div>
                                        <p class="uk-margin-remove uk-display-inline-block uk-width-1-1 text-small@m">
                                            <span class="uk-float-right uk-text-medium">{{number_format($product->price)}}</span>
                                            <span class="uk-float-left uk-text-medium uk-text-normal">تومان</span>
                                        </p>
                                        <a  href="/product/{{$product->id}}" class="uk-button uk-button-success uk-text-white uk-width-expand uk-margin-small-bottom uk-margin-small-top">
                                            <span>خرید</span><span class="uk-margin-small-right"
                                                                                data-uk-icon="cart"></span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                {{--<a class="uk-position-center-left-out uk-visible@s uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>--}}
                {{--<a class="uk-position-center-right-out uk-visible@s uk-position-small" href="#" uk-slidenav-previous--}}
                   {{--uk-slider-item="previous"></a>--}}
                {{--<a class="uk-position-center-left uk-hidden@s uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>--}}
                {{--<a class="uk-position-center-right uk-hidden@s uk-position-small" href="#" uk-slidenav-previous--}}
                   {{--uk-slider-item="previous"></a>--}}
            </div>
        </div>
        {{--<div class="uk-width-expand uk-hidden@s uk-text-center uk-text-left@s"><a href="{{$link ?? '#'}}" class="uk-text-primary"><span>نمایش تمام قطعات</span><span--}}
                        {{--data-uk-icon="chevron-left" class="uk-margin-small-left"></span></a></div>--}}
    </div>
</div>