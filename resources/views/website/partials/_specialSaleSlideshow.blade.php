<div class="uk-container">
    <div class="uk-text-center uk-light">
        <div class="uk-background-danger uk-display-inline-block uk-text-primary uk-margin-remove
            uk-heading-small special-title">فــروش ویــژه
        </div>
    </div>
    <div data-uk-slider dir="ltr"
         style="padding: 2rem 1em; position: relative"
    >
        <div class="uk-position-relative uk-visible-toggle">
            <ul class="uk-slider-items uk-child-width-1-4@m uk-child-width-1-3@s uk-child-width-1-1 uk-grid uk-grid-small">
                @foreach($items as $product)
                    <li>
                        <div class="uk-card uk-card-default uk-box-shadow-hover-medium" style="border-radius: 0.6em">
                            <a href="/product/{{$product->id}}">
                                <img src="{{$product->splashUrl}}" class="uk-width-expand uk-border-rounded">
                            </a>
                            <div class="uk-padding-small">
                                <p class="uk-text-secondary uk-text-medium uk-margin-small-bottom uk-text-center uk-text-bold">{{$product->name}}</p>
                                <p class="uk-text-secondary uk-margin-remove uk-text-medium uk-text-center numeric-standard">{{$product->en_name}}</p>
                                <p class="uk-margin-remove uk-display-inline-block uk-width-1-1">
                                    <span class="uk-text-muted uk-float-right uk-text-line-through">{{number_format($product->price)}}</span>
                                    <span class="uk-float-left uk-label uk-label-danger">{{$product->discount}}%</span>
                                </p>
                                <p class="uk-margin-remove uk-display-inline-block uk-width-1-1">
                                    <span class="uk-float-right uk-text-medium">{{number_format($product->special_price)}}</span>
                                    <span class="uk-float-left uk-text-medium">تومان</span>
                                </p>
                                <p class="uk-display-inline-block uk-width-1-1 uk-margin-small">
                                    <span class="uk-float-right uk-text-meta uk-text-light">
                                        <span class="uk-text-meta uk-display-inline-block"
                                              data-uk-countdown="date: {{$product->special_price_expiration}}">
                                            <span class="uk-countdown-number uk-text-meta uk-countdown-days"></span>
                                            <span class="uk-countdown-separator uk-text-meta">:</span>
                                            <span class="uk-countdown-number uk-text-meta uk-countdown-hours"></span>
                                            <span class="uk-countdown-separator uk-text-meta">:</span>
                                            <span class="uk-countdown-number uk-text-meta uk-countdown-minutes"></span>
                                            <span class="uk-countdown-separator uk-text-meta">:</span>
                                            <span class="uk-countdown-number uk-text-meta uk-countdown-seconds"></span>
                                        </span>
                                    </span>
                                    <span class="uk-float-left uk-text-meta uk-text-light">زمان باقیمانده</span>
                                </p>
                                <a href="/product/{{$product->id}}"
                                   class="uk-button uk-text-white uk-button-success uk-width-expand uk-margin-small-bottom">
                                    <span>افزودن به سبد خرید</span><span class="uk-margin-small-right"
                                                                         data-uk-icon="cart"></span>
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <a class="uk-position-center-left uk-visible@s uk-margin-remove uk-text-white uk-background-secondary uk-text-white uk-position-small"
           href="#"
           uk-slider-item="next"
           style="padding: 4em 0; border-top-left-radius: 0.5rem;border-bottom-left-radius: 0.5rem;    box-shadow: 0 0 5rem 5rem #fff;">
            <i data-uk-icon="icon:chevron-right;ratio:3"></i>
        </a>
        <a class="uk-position-center-right uk-visible@s uk-margin-remove uk-text-white uk-background-secondary uk-text-white uk-position-small"
           href="#"
           uk-slider-item="previous"
           style="padding: 4em 0;border-top-right-radius: 0.5rem;border-bottom-right-radius: 0.5rem;    box-shadow: 0 0 5rem 5rem #fff;">
            <i data-uk-icon="icon:chevron-left;ratio:3"></i>
        </a>
    </div>
</div>