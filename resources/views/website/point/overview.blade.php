@extends('website.layouts.profile')

@section('profile-content')
    <h4 class="">امتیازات من</h4>
    <div class="uk-border-rounded uk-padding-small uk-background-default uk-box-shadow-small uk-inline">
        <span>مجموع امتیاز من</span><span class="uk-margin-left uk-margin-right">{{$points}}</span>
    </div>
    <front-points class="uk-margin-top" fetch-url="/point"></front-points>
    <h4 class="">از امتیازهات استفاده کن</h4>
    <div class="uk-grid uk-grid-match uk-grid-small uk-child-width-1-3@m uk-child-width-1-2" data-uk-grid>
        <div class="uk-flex uk-flex-column">
            <div class="uk-background-default uk-border-rounded bordered uk-box-shadow-medium">
                <div class="uk-padding-small">
                    <img class="uk-width-expand" uk-img src="/uploads/xigma_logo.png">
                    <div class="uk-text-center uk-text-muted">اعتبار خرید از فروشگاه آنلاین زیگما</div>
                </div>
            </div>
            <a href="/coupon" class="uk-width-expand uk-margin-small-top uk-button uk-button-primary uk-border-rounded">دریافت
                جایزه</a>
        </div>
        <div class="uk-flex uk-flex-column">
            <div class="uk-background-default uk-border-rounded bordered uk-box-shadow-medium">
                <div class="uk-padding-small">
                    <img class="uk-width-expand" uk-img src="/uploads/xigma_logo.png">
                    <div class="uk-text-center uk-text-muted">شرکت در قرعه‌کشی بزرگ فصلی موتورسیکلت زیگما</div>
                </div>
            </div>
            <button disabled class="uk-width-expand uk-margin-small-top uk-button uk-button-primary uk-border-rounded">دریافت
                جایزه</button>
        </div>
        <div class="uk-flex uk-flex-column">
            <div class="uk-background-default uk-border-rounded bordered uk-box-shadow-medium">
                <div class="uk-padding-small">
                    <img class="uk-width-expand" uk-img src="/uploads/xigma_logo.png">
                    <div class="uk-text-center uk-text-muted">بلیط استفاده از پیست موتورسواری تختی تهران</div>
                </div>
            </div>
            <button disabled class="uk-width-expand uk-margin-small-top uk-button uk-button-primary uk-border-rounded">دریافت
                جایزه</button>
        </div>
        <div class="uk-flex uk-flex-column">
            <div class="uk-background-default uk-border-rounded bordered uk-box-shadow-medium">
                <div class="uk-padding-small">
                    <img class="uk-width-expand" uk-img src="/uploads/xigma_logo.png">
                    <div class="uk-text-center uk-text-muted">۱۰۰ هزارتومان کمک هزینه معاینه فنی موتورسیکلت</div>
                </div>
            </div>
            <button disabled class="uk-width-expand uk-margin-small-top uk-button uk-button-primary uk-border-rounded">دریافت
                جایزه</button>
        </div>
        <div class="uk-flex uk-flex-column">
            <div class="uk-background-default uk-border-rounded bordered uk-box-shadow-medium">
                <div class="uk-padding-small">
                    <img class="uk-width-expand" uk-img src="/uploads/xigma_logo.png">
                    <div class="uk-text-center uk-text-muted">بلیط شرکت در تماشای مسابقات سرعت قهرمانی کشوری</div>
                </div>
            </div>
            <button disabled class="uk-width-expand uk-margin-small-top uk-button uk-button-primary uk-border-rounded">دریافت
                جایزه</button>
        </div>
        <div class="uk-flex uk-flex-column">
            <div class="uk-background-default uk-border-rounded bordered uk-box-shadow-medium">
                <div class="uk-padding-small">
                    <img class="uk-width-expand" uk-img src="/uploads/xigma_logo.png">
                    <div class="uk-text-center uk-text-muted">تخفیف ویژه خرید تجهیزات جانبی موتورسیکلت</div>
                </div>
            </div>
            <button disabled class="uk-width-expand uk-margin-small-top uk-button uk-button-primary uk-border-rounded">دریافت
                جایزه</button>
        </div>
    </div>
@endsection