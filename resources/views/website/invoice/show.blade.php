@extends('website.layouts.profile')


@section('profile-content')
    <h4 class="uk-text-muted">جزئیات پیش فاکتور شماره {{$invoice->id}}</h4>
    <div class="uk-background-default uk-border-rounded uk-padding-small uk-box-shadow-small">
        <div class="uk-padding-small uk-background-muted uk-border-rounded">
            @foreach($invoice->variations as $variation)
                <div class="uk-grid uk-flex uk-flex-middle uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-5@m">
                        <img class="uk-width-expand uk-border-rounded"
                             src="{{$variation->picture->url ?? '/uploads/xigma_logo.png'}}">
                    </div>
                    <div class="uk-width-expand@m">
                        <div>
                            <div class="uk-grid uk-flex uk-flex-middle">
                                <div class="uk-width-1-3@m">
                                    <div class="uk-text-bold uk-text-medium">{{$variation->name}}</div>
                                    <div>{{$variation->sku}}</div>
                                    <div>نوع: {{$variation->filters}}</div>
                                </div>
                                <div class="uk-width-expand">
                                    @if($variation->orderPrice != $variation->pivot->price)
                                        <div class="uk-text-small uk-text-danger uk-text-center">
                                            <div class="uk-text-bold">
                                                <span class="uk-margin-small-right"><i
                                                            class="fa-solid fa-triangle-exclamation"></i></span><span>در قیمت یا موجودی کالا تغییری بوجود آمده</span>
                                            </div>
                                            <div style="font-size: 0.7rem">
                                                جهت اصلاح پیش‌فاکتور از کلید "انتقال به سبد خرید" استفاده کنید
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="uk-grid uk-grid-small uk-grid-divider uk-margin-small-top uk-text-small">
                                <div class="uk-first-column">تعداد: {{$variation->pivot->quantity}} عدد</div>
                                <div>قیمت واحد: {{number_format($variation->pivot->price + $variation->pivot->discount)}}</div>
                                @if($variation->pivot->discount > 0)
                                    <div>تخفیف: {{number_format($variation->pivot->discount)}}</div>
                                @endif
                                <div>قیمت کل: {{number_format($variation->pivot->price * $variation->pivot->quantity)}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
            @endforeach
            <table class="uk-table uk-background-default uk-table-striped uk-table-small">
                <tbody>
                <tr>
                    <td class="uk-width-medium">جمع کل خرید</td>
                    <td class="uk-table-expand">{{number_format($invoice->variations->sum(function($v) {return $v->pivot->price * $v->pivot->quantity;}) + $invoice->variations->sum(function($v) {
                        return $v->pivot->quantity * $v->pivot->discount;
                    }))}}</td>
                </tr>
                <tr>
                    <td>مجموع تخفیف</td>
                    <td>{{number_format($invoice->variations->sum(function($v) {
                        return $v->pivot->quantity * $v->pivot->discount;
                    }))}}</td>
                </tr>
                <tr>
                    <td>مالیات بر ارزش افزوده</td>
                    <td>{{number_format($invoice->vat)}}</td>
                </tr>
                <tr>
                    <td>مبلغ قابل پرداخت</td>
                    <td>{{number_format($invoice->total)}}</td>
                </tr>
                </tbody>
            </table>
            <div class="uk-text-center">
                <a href="/invoice/{{$invoice->id}}/invoice"
                   class="uk-button uk-button-secondary uk-background-gray uk-border-rounded">چاپ پیش فاکتور</a>
                <invoice-to-cart :invoice="{{$invoice}}"></invoice-to-cart>
            </div>
        </div>
    </div>


@endsection