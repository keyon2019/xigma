<div class="uk-section @if($muted ?? false) uk-section-muted @endif">
    <div class="uk-container">
        <div class="uk-grid uk-flex uk-flex-middle">
            <div class="uk-width-expand"><h2 class="uk-text-large uk-text-center uk-text-left@s">{{$title}}</h2></div>
            <div class="uk-width-auto uk-visible@s"><a href="{{$link ?? '#'}}" class="uk-text-primary"><span>نمایش تمام قطعات</span><span
                            data-uk-icon="chevron-left" class="uk-margin-small-left"></span></a></div>
        </div>
        <div data-uk-slider dir="ltr">
            <div class="uk-position-relative uk-visible-toggle">
                <div class="uk-slider-container" style="padding: 2rem 1em">
                    <ul class="uk-slider-items uk-child-width-1-4@m uk-child-width-1-3@s uk-child-width-1-1 uk-grid uk-grid-small">
                        @foreach($items as $number)
                            <li>
                                <div class="uk-card product-card uk-box-shadow-hover-medium" style="border-radius: 0.6em;">
                                    <a href="#">
                                        <img src="/uploads/card-image.png" class="uk-width-expand">
                                    </a>
                                    <div class="uk-padding-small">
                                        <p class="uk-text-secondary uk-margin-remove uk-text-medium uk-text-center">باک
                                            انژکتور خارجی</p>
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
                                        <p class="uk-margin-remove uk-display-inline-block uk-width-1-1">
                                            <span class="uk-float-left uk-text-meta">مقبولیت</span>
                                            <span class="uk-float-right uk-text-meta">
                                                <span data-uk-icon="icon:star;ratio:0.7"></span>
                                                <span data-uk-icon="icon:star;ratio:0.7"></span>
                                                <span data-uk-icon="icon:star;ratio:0.7"></span>
                                                <span data-uk-icon="icon:star;ratio:0.7"></span>
                                                <span data-uk-icon="icon:star;ratio:0.7"></span>
                                            </span>
                                        </p>
                                        <p class="uk-margin-remove uk-display-inline-block uk-width-1-1">
                                            <span class="uk-float-right uk-text-medium">45,000,000</span>
                                            <span class="uk-float-left uk-text-medium uk-text-normal">تومان</span>
                                        </p>
                                        <button class="uk-button uk-button-success uk-text-white uk-width-expand uk-margin-small-bottom">
                                            <span>اضافه به سبد خرید</span><span class="uk-margin-small-right"
                                                                                data-uk-icon="cart"></span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <a class="uk-position-center-left-out uk-visible@s uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
                <a class="uk-position-center-right-out uk-visible@s uk-position-small" href="#" uk-slidenav-previous
                   uk-slider-item="previous"></a>
                <a class="uk-position-center-left uk-hidden@s uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
                <a class="uk-position-center-right uk-hidden@s uk-position-small" href="#" uk-slidenav-previous
                   uk-slider-item="previous"></a>
            </div>
        </div>
        <div class="uk-width-expand uk-hidden@s uk-text-center uk-text-left@s"><a href="{{$link ?? '#'}}" class="uk-text-primary"><span>نمایش تمام قطعات</span><span
                        data-uk-icon="chevron-left" class="uk-margin-small-left"></span></a></div>
    </div>
</div>