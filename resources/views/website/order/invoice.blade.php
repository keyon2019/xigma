@extends('website.layouts.app')

@section('content')
    <div class="uk-section uk-section-default uk-section-xsmall">
        <div class="uk-container">
            <div class="uk-grid uk-flex uk-flex-middle">
                <div class="uk-width-expand">
                    <div class="uk-text-bold">فاکتور فروش آنلاین قطعات زیگما</div>
                    <div>فاکتور شماره {{$order->id}}</div>
                </div>
                <div>
                    <img uk-img src="/uploads/xigma_invoice_logo.png">
                </div>
            </div>
            <div class="uk-border-rounded uk-padding-small uk-text-small" style="border: 1px solid gainsboro">
                <div class="uk-grid uk-child-width-1-2" data-uk-grid>
                    <div>
                        <div class="uk-grid uk-grid-small" data-uk-grid>
                            <div class="uk-width-1-3 uk-text-muted">
                                تحویل گیرنده
                            </div>
                            <div class="uk-width-2-3">
                                {{$order->receiver}}
                            </div>
                            <div class="uk-width-1-3 uk-text-muted">
                                شماره موبایل
                            </div>
                            <div class="uk-width-2-3">
                                {{$order->receiver_number}}
                            </div>
                            <div class="uk-width-1-3 uk-text-muted">
                                نشانی
                            </div>
                            <div class="uk-width-2-3">
                                {{$order->address->directions}}
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="uk-grid uk-grid-small" data-uk-grid>
                            <div class="uk-width-1-4 uk-text-muted">
                                تاریخ ثبت
                            </div>
                            <div class="uk-width-3-4">
                                {{$order->created_at}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table class="uk-table uk-table-striped uk-table-small uk-table-middle uk-margin-small-bottom uk-text-small">
                <thead>
                <tr class="uk-background-primary">
                    <th class="uk-text-white uk-table-shrink">#</th>
                    <th class="uk-text-white">نام قطعه</th>
                    <th class="uk-text-white uk-width-small">نوع</th>
                    <th class="uk-text-white">تعداد</th>
                    <th class="uk-text-white">شماره سریال</th>
                    <th class="uk-text-white">قیمت واحد</th>
                    <th class="uk-text-white">قیمت کل</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->variations as $variation)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td class="uk-width-medium">
                            <div class="uk-grid uk-grid-small uk-flex uk-flex-middle">
                                <div>
                                    <img uk-img width="50" src="{{$variation->picture->url ?? '/uploads/xigma_logo.png'}}">
                                </div>
                                <div class="uk-width-expand">
                                    <div>{{$variation->name}}</div>
                                    <div class="uk-text-meta">{{$variation->sku}}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{$variation->filters}}</td>
                        <td>{{$variation->pivot->quantity}}</td>
                        <td>
                            @foreach($order->items->filter(function($i) use($variation) {return $i->variation_id == $variation->id;})->pluck('barcode')->chunk(2) as $tuple)
                                <div>{{$tuple[0] ?? ''}} @if($tuple[1] ?? false)-@endif {{$tuple[1] ?? ''}}</div>
                            @endforeach
                        </td>
                        <td>
                            @if($variation->pivot->discount > 0)
                                <div class="uk-text-line-through uk-text-muted">{{number_format($variation->pivot->price + $variation->pivot->discount)}}</div>
                            @endif
                            <div>{{number_format($variation->pivot->price)}}</div>
                        </td>
                        <td>{{number_format($variation->pivot->price * $variation->pivot->quantity)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="uk-grid uk-margin-small uk-text-small">
                <div class="uk-width-2-3"></div>
                <div class="uk-width-1-3">
                    <table class="uk-table uk-table-small">
                        <tbody>
                        <tr class="uk-background-muted">
                            <td>جمع کل قیمت</td>
                            <td>{{number_format($order->variations->sum(function($v) {return $v->pivot->price * $v->pivot->quantity;}))}}</td>
                        </tr>
                        <tr class="uk-background-muted">
                            <td>جمع کل تخیفات</td>
                            <td>{{number_format($order->variations->sum(function($v) {
                        return $v->pivot->quantity * $v->pivot->discount;
                    }))}}</td>
                        </tr>
                        <tr class="uk-background-muted">
                            <td>هزینه ارسال</td>
                            <td>{{number_format($order->shippings->sum('cost'))}}</td>
                        </tr>
                        <tr class="uk-background-muted">
                            <td>جمع کل قیمت</td>
                            <td>{{number_format($order->variations->sum(function($v) {return $v->pivot->price * $v->pivot->quantity;}))}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="uk-border-rounded uk-padding-small uk-text-small" style="border: 1px solid gainsboro">
                <div class="uk-grid uk-child-width-1-2" data-uk-grid>
                    <div>
                        <div class="uk-grid uk-grid-small" data-uk-grid>
                            <div class="uk-width-1-3 uk-text-muted">
                                وضعیت پرداخت
                            </div>
                            <div class="uk-width-2-3">
                                {{$order->paid ? 'پرداخت با موفقیت انجام شده' : 'در انتظار پرداخت'}}
                            </div>
                            <div class="uk-width-1-3 uk-text-muted">
                                درگاه پرداخت
                            </div>
                            <div class="uk-width-2-3">
                                {{$order->successfulPayment->gatewayName ?? ''}}
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="uk-grid uk-grid-small" data-uk-grid>
                            <div class="uk-width-1-4 uk-text-muted">
                                تاریخ پرداخت
                            </div>
                            <div class="uk-width-3-4">
                                {{$order->successfulPayment->created_at ?? ''}}
                            </div>
                            <div class="uk-width-1-4 uk-text-muted">
                                شماره پیگیری
                            </div>
                            <div class="uk-width-3-4">
                                {{$order->successfulPayment->reference_number ?? ''}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-margin-large-top uk-text-meta">
                <ul class="uk-list uk-list-disc">
                    <li>این فاکتور به منزله خرید شما بصورت آنلاین از وب‌سایت زیگما می‌باشد</li>
                    <li>با توجه به تنوع در اقلام فنی، مسئولیت متناسب بودن قطعه خریداری شده با وسیله نقلیه بر عهده خریدار می‌باشد و وب‌سایت زیگما هیچگونه مسئولیتی در قبال آن نمی‌پذیرد</li>
                    <li>لغو خرید و یا مرجوعی کالای سالم برای هیچ فاکتوری در هیچ شرایطی امکان پذیر نمی‌باشد</li>
                </ul>
            </div>
            <div class="uk-margin-large-top uk-text-center hidden-in-print">
                <button onclick="window.print()" class="uk-button uk-button-secondary uk-background-gray uk-border-rounded">چاپ فاکتور</button>
            </div>
        </div>
    </div>
@endsection