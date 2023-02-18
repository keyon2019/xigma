@extends('dashboard.layouts.dashboard')

@section('title', " سفارش شماره $order->id")

@section('content')
    <div class="uk-border-rounded uk-padding-small uk-background-default uk-margin-small uk-text-small"
         style="border: 1px solid gainsboro">
        <div>
            <div class="uk-grid uk-grid-small uk-child-width-1-3" data-uk-grid>
                <div>
                            <span class="uk-text-muted">
                                تحویل گیرنده
                            </span>
                    <span class="uk-margin-left">
                                {{$order->receiver}}
                            </span>
                </div>
                <div>
                            <span class=" uk-text-muted">
                                شماره موبایل
                            </span>
                    <span class="uk-margin-left">
                                {{$order->receiver_number}}
                            </span>
                </div>
                <div>
                            <span class=" uk-text-muted">
                                تاریخ ثبت سفارش
                            </span>
                    <span class="uk-margin-left">
                                {{$order->created_at}}
                            </span>
                </div>
                <div>
                            <span class=" uk-text-muted">
                                کد ملی
                            </span>
                    <span class="uk-margin-left">
                                {{$order->ssn}}
                            </span>
                </div>
                <div class="">
                            <span class="uk-text-muted">
                                نشانی
                            </span>
                    <span class="uk-margin-left">
                                {{$order->address->directions}}
                            </span>
                </div>
                <div>
                            <span class="uk-text-muted">
                                کد پستی
                            </span>
                    <span class="uk-margin-left">
                                {{$order->address->zip}}
                            </span>
                </div>
            </div>
            <div>

            </div>
        </div>
    </div>
    @foreach($order->groupedByShippings as $shippingId => $group)
        <div class="uk-padding-small uk-box-shadow-small uk-border-rounded uk-margin-small uk-background-default">
            <div>
                <div class="uk-grid uk-grid-collapse uk-text-small">
                    <div class="uk-width-expand">
                        @php($shipping = $order->shippings->firstWhere('id', $shippingId))
                        <div class="uk-margin-small uk-text-medium">
                            مرسوله شماره {{$shippingId}}
                        </div>
                        <div class="uk-margin-small">
                            <span class="uk-text-muted"> فرستنده </span><span
                                class="uk-margin-left">{{$shipping->stock->name ?? (request()->has('rasmi') ? "رایات تجارت گستر دادمهر پارسیان" : "کارخانه مرکزی زیگما")}}</span>
                        </div>
                    </div>
                    <div class="uk-width-2-5">
                        <div class="uk-margin-small">
                            <span class="uk-text-muted"> تاریخ ارسال </span><span
                                class="uk-margin-left">{{$shipping->sailed_at ?? 'در دست اقدام'}}</span>
                        </div>
                        <div class="uk-margin-small">
                            <span class="uk-text-muted"> نحوه ارسال </span><span
                                class="uk-margin-left">{{$shipping->methodName}}</span>
                        </div>
                        <div class="uk-margin-small">
                            <span class="uk-text-muted"> شماره بارنامه / کد مرسوله </span><span
                                class="uk-margin-left">{{$shipping->code ?? 'در دست اقدام'}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-overflow-auto">
                <table
                    class="uk-table uk-table-striped uk-table-small uk-table-middle uk-margin-small-bottom uk-text-small">
                    <thead>
                    <tr class="uk-background-primary">
                        <th class="uk-text-white uk-table-shrink">#</th>
                        <th colspan="2" class="uk-text-white">نام قطعه</th>
                        <th class="uk-text-white">سریال</th>
                        <th class="uk-text-white">مشخصات فنی</th>
                        <th class="uk-text-white">تعداد</th>
                        <th class="uk-text-white">قیمت واحد</th>
                        <th class="uk-text-white">قیمت کل</th>
                        <th class="uk-text-white">تخفیف ردیف</th>
                        <th class="uk-text-white">قیمت نهایی (تومان)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($group as $variation)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td class="">
                                <img uk-img width="50"
                                     src="{{$variation->picture->url ?? '/uploads/xigma_logo.png'}}">
                            </td>
                            <td>
                                <div>{{$variation->product->name}}</div>
                            </td>
                            <td>
                                <div>{{$variation->sku}}</div>
                            </td>
                            <td>{{$variation->name}}</td>
                            <td>{{$variation->pivot->quantity}}</td>
                            <td>{{number_format($variation->pivot->price + $variation->pivot->discount)}}</td>
                            <td>{{number_format(($variation->pivot->price + $variation->pivot->discount) * $variation->pivot->quantity)}}</td>
                            <td>{{number_format($variation->pivot->discount * $variation->pivot->quantity)}}</td>
                            <td>
                                {{number_format($variation->pivot->price * $variation->pivot->quantity)}}
                            </td>
                        </tr>
                    @endforeach
                    @foreach($order->shippings as $shipping)
                        <tr>
                            <td colspan="9">
                                <form method="post" onsubmit="Loading.show()"
                                      action="/dashboard/r/shipping/{{$shipping->id}}/sailed">
                                    @csrf
                                    <div class="uk-text-meta">اطلاعات ارسال مرسوله</div>
                                    <div class="uk-grid uk-child-width-1-3 uk-flex uk-flex-middle uk-grid-small uk-margin-small"
                                         data-uk-grid>
                                        <div>مبدا ارسال: {{optional($shipping->stock)->name ?? 'کارخانه'}}</div>
                                        <div>نحوه ارسال: {{$shipping->methodName}}</div>
                                        <div class="uk-flex uk-flex-middle">
                                            <div class="uk-margin-small-right">تاریخ‌ارسال:</div>
                                            <input class="uk-input uk-border-rounded to"
                                                   value="{{$shipping->sailed_at}}"
                                                   placeholder="زمان ارسال">
                                            <date-picker-wrapper custom-input=".to"
                                                                 type="datetime"
                                                                 format="YYYY-MM-DD HH:mm:00"
                                                                 display-format="jYYYY/jMM/jDD - HH:mm"
                                                                 name="sailed_at"></date-picker-wrapper>
                                        </div>
                                        <div>هزینه ارسال: {{number_format($shipping->cost)}}</div>
                                        <div class="uk-width-expand">شماره مرسوله/بارنامه:
                                            <span class="uk-inline">
                                                <input value="{{$shipping->code}}" class="uk-input uk-border-rounded" name="code"
                                                       type="text">
                                            </span>
                                        </div>
                                        <div>
                                            <button class="uk-button uk-button-primary uk-border-rounded uk-button-small">ثبت
                                                ارسال
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
    <div class="uk-grid uk-margin-small uk-text-small">
        <div class="uk-width-1-2"></div>
        <div class="uk-width-1-2">
            <table class="uk-table uk-table-small">
                <tbody>
                <tr class="uk-background-default">
                    <td>جمع کل مبالغ</td>
                    <td>{{number_format($order->variations->sum(function($v) {return $v->pivot->price * $v->pivot->quantity;}))}}</td>
                </tr>
                {{--                <tr class="uk-background-default">--}}
                {{--                    <td>بن تخفیف</td>--}}
                {{--                    <td>@if($order->orderCoupon)--}}
                {{--                            {{number_format($order->orderCoupon->discount)}}--}}
                {{--                        @else 0--}}
                {{--                        @endif</td>--}}
                {{--                </tr>--}}
                {{--                <tr class="uk-background-default">--}}
                {{--                    <td>هزینه ارسال</td>--}}
                {{--                    <td>{{number_format($order->shippings->sum('cost'))}}</td>--}}
                {{--                </tr>--}}
                {{--                <tr class="uk-background-default">--}}
                {{--                    <td>مبلغ خالص فاکتور</td>--}}
                {{--                    <td>{{number_format($order->total - $order->vat)}}</td>--}}
                {{--                </tr>--}}
                {{--                <tr class="uk-background-default">--}}
                {{--                    <td>مالیات بر ارزش افزوده</td>--}}
                {{--                    <td>{{number_format($order->vat)}}</td>--}}
                {{--                </tr>--}}
                {{--                <tr class="uk-background-default">--}}
                {{--                    <td>مبلغ قابل پرداخت</td>--}}
                {{--                    <td>{{number_format($order->total)}}</td>--}}
                {{--                </tr>--}}
                </tbody>
            </table>
        </div>
    </div>
@endsection
