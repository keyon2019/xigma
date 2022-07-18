@extends('website.layouts.profile')

<style>
    .clearfix:after {
        clear: both;
        content: "";
        display: block;
        height: 0;
    }

    .arrow-steps .step {
        font-size: 14px;
        text-align: center;
        color: #777;
        cursor: default;
        padding: 26px 0px 26px 0px;
        width: 15%;
        float: left;
        position: relative;
        background-color: #ddd;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .arrow-steps .step:not(:first-child) {
        margin: 0 10px 0 0;
    }

    .arrow-steps .step a {
        color: #777;
        text-decoration: none;
    }

    .arrow-steps .step:not(:last-child)::after,
    .arrow-steps .step:before {
        content: "";
        position: absolute;
        top: 0;
        left: -17px;
        width: 0;
        height: 0;
        border-top: 40px solid transparent;
        border-bottom: 40px solid transparent;
        border-right: 17px solid #ddd;
        z-index: 2;
    }

    .arrow-steps .step:before {
        left: auto;
        right: 0;
        border-right: 17px solid #f3f3f3;
        z-index: 0;
    }

    .arrow-steps .step:first-child:before {
        border: none;
    }

    .arrow-steps .step:last-child:after {
    / / border: none;
    }

    .arrow-steps .step:first-child {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    .arrow-steps .step:last-child {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .arrow-steps .step span {
        position: relative;
    }

    *.arrow-steps .step.done span:before {
        opacity: 1;
        content: "";
        position: absolute;
        top: -2px;
        right: -10px;
        font-size: 11px;
        line-height: 21px;
    }

    .arrow-steps .step.current {
        color: #fff;
        background-image: linear-gradient(to left, #fbc569, #FFAA1A);
    }

    .arrow-steps .step.current a {
        color: #fff;
        text-decoration: none;
    }

    .arrow-steps .step.current:after {
        border-right: 17px solid #FFAA1A;
    }

    .arrow-steps .step.done {
        color: #FFF;
        background-image: linear-gradient(to left, #fbc569, #FFAA1A);
    }

    .arrow-steps .step.done a {
        color: #173352;
        text-decoration: none;
    }

    .arrow-steps .step.done:after {
        border-right: 17px solid #FFAA1A;
    }

    .arrow-steps {
        flex-direction: row;
    }

    .step {
        flex: 1;
    }
</style>

@section('profile-content')
    <h4 class="uk-text-muted">جزئیات سفارش شماره XGM-{{$order->id}}</h4>
    <ul class="uk-list uk-hidden@m">
        <li class="uk-text-small">وضعیت سفارش: <strong>{{$order->statusName}}</strong></li>
    </ul>

    <div class="uk-background-default uk-border-rounded uk-padding-small uk-box-shadow-small">
        <div class="uk-padding-small uk-background-muted uk-border-rounded">
            <order-progress status="{{$order->getRawOriginal('status')}}" class="uk-width-expand uk-visible@m"></order-progress>
            @foreach($order->groupedVariations as $variation)
                <div class="uk-grid uk-flex uk-flex-middle uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-5@m">
                        <img class="uk-width-expand uk-border-rounded"
                             src="{{$variation->picture->url ?? '/uploads/xigma_logo.png'}}">
                    </div>
                    <div class="uk-width-expand@m">
                        <div class="uk-text-bold uk-text-medium">{{$variation->name}}</div>
                        <div><span>کد محصول: </span>{{$variation->sku}}</div>
                        @foreach($variation->values as $value)
                            <div class="uk-text-meta">
                                {{$value->option->name}} : <span class="uk-text-bold">{{$value->name}}</span>
                            </div>
                        @endforeach
                        <div>
                            <div class="uk-grid uk-grid-small uk-grid-divider uk-margin-small-top uk-text-small">
                                <div class="uk-first-column">تعداد: {{$variation->quantity}} عدد</div>
                                <div>قیمت واحد: {{number_format($variation->price + $variation->discount)}}</div>
                                @if($variation->discount > 0)
                                    <div>تخفیف: {{number_format($variation->discount)}}</div>
                                @endif
                                <div>قیمت کل: {{number_format($variation->price * $variation->quantity)}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-6@m uk-text-small">
                        <div>
                            <a href="/product/{{$variation->product_id}}"
                               class="uk-button uk-button-link uk-button-small uk-border-rounded uk-flex uk-flex-middle">
                                <i class="fa-solid fa-plus uk-margin-small-right"></i>
                                <span>خرید مجدد کالا</span>
                            </a>
                        </div>
                        <div class="uk-margin-top">
                            <return-request
                                    @if($r = $order->returnRequests->firstWhere('variation_id', $variation->id)) :initial-return-request="{{$r}}"
                                    @endif :enquiries="{{$enquiries}}" :reasons="{{$reasons}}" :order="{{$order}}"
                                    :variation="{{$variation}}"></return-request>
                        </div>
                    </div>
                </div>
                <hr/>
            @endforeach
            <table class="uk-table uk-background-default uk-table-striped uk-table-small">
                <tbody>
                <tr>
                    <td class="uk-width-medium">جمع کل خرید</td>
                    <td class="uk-table-expand">{{number_format($order->variations->sum(function($v) {return $v->pivot->price * $v->pivot->quantity;}))}}</td>
                </tr>
                <tr>
                    <td>هزینه ارسال</td>
                    <td>{{number_format($order->shippings->sum('cost'))}}</td>
                </tr>
                <tr>
                    <td>مجموع تخفیف</td>
                    <td>{{number_format($order->variations->sum(function($v) {
                        return $v->pivot->quantity * $v->pivot->discount;
                    }) + $order->discount)}}</td>
                </tr>
                {{--<tr>--}}
                    {{--<td>قابل پرداخت (بدون احتساب مالیات)</td>--}}
                    {{--<td>{{number_format($order->total - $order->vat)}}</td>--}}
                {{--</tr>--}}
                <tr>
                    <td>مالیات بر ارزش افزوده</td>
                    <td>{{number_format($order->vat)}}</td>
                </tr>
                <tr>
                    <td>مبلغ قابل پرداخت</td>
                    <td>{{number_format($order->total)}}</td>
                </tr>
                @foreach($order->returnRequests as $returnRequest)
                    <tr>
                        <td>مرجوعی</td>
                        <td>{{number_format($returnRequest->total)}} - <a class="uk-link-reset uk-text-small" href="/return_request/{{$returnRequest->id}}">فاکتور مرجوعی {{$returnRequest->id}}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small uk-margin">
                <accordion title="اطلاعات پرداخت">
                    <div class="uk-grid uk-grid-collapse uk-child-width-1-2@m uk-margin-small-top uk-text-meta"
                         data-uk-grid>
                        <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">وضعیت
                            پرداخت: {{$order->paid ? 'پرداخت شده' : 'در انتظار پرداخت'}}</div>
                        <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">تاریخ
                            پرداخت: {{$order->successfulPayment->created_at ?? null}}</div>
                        <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">درگاه
                            پرداخت: {{$order->successfulPayment->gatewayName ?? null}}</div>
                        <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">شماره
                            پیگیری: {{$order->successfulPayment->reference_number ?? null}}</div>
                    </div>
                </accordion>
            </div>
            <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small uk-margin">
                <accordion title="اطلاعات ارسال">
                    @foreach($order->shippings as $shipping)
                        <div class="uk-grid uk-grid-collapse uk-child-width-1-2@m uk-margin-small-top uk-text-meta" data-uk-grid>
                            <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">
                                مرسوله: {{$loop->iteration}}
                            </div>
                            <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">مبدا
                                ارسال: {{$shipping->stock->name ?? 'کارخانه زیگما'}}
                            </div>
                            <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">نحوه
                                ارسال: {{$shipping->methodName}}
                            </div>
                            <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">تاریخ
                                ارسال: {{$shipping->sailed_at}}
                            </div>
                            <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">شماره مرسوله /
                                بارنامه: {{$shipping->code}}
                            </div>
                            <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">هزینه
                                ارسال: {{number_format($shipping->cost)}}
                            </div>
                        </div>
                    @endforeach
                </accordion>
            </div>
            <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small uk-margin">
                <accordion title="اطلاعات گیرنده">
                    <div class="uk-grid uk-grid-collapse uk-child-width-1-2@m uk-margin-small-top uk-text-meta"
                         data-uk-grid>
                        <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">نام و نام
                            خانوادگی: {{$order->receiver}}</div>
                        <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">شماره
                            تماس: {{$order->receiver_number}}</div>
                        <div class="uk-padding-small uk-background-muted uk-width-1-1" style="border: 1px solid white">آدرس
                            گیرنده: {{$order->address->directions}}
                        </div>
                    </div>
                </accordion>
            </div>
            <div class="uk-text-center">
                <a href="/order/{{$order->id}}/invoice"
                   class="uk-button uk-button-secondary uk-background-gray uk-button-large uk-border-rounded">چاپ فاکتور</a>
            </div>
        </div>
    </div>


@endsection