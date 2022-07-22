@extends('website.layouts.app')

@section('content')
    <div class="uk-section uk-section-default uk-section-xsmall">
        <div class="uk-container">
            <a href="/invoice/{{$invoice->id}}" class="uk-button uk-border-rounded uk-button-secondary hidden-in-print">بازگشت به  پیش‌فاکتور</a>
            <div class="uk-grid uk-flex uk-flex-middle">
                <div class="uk-width-expand">
                    <div class="uk-text-bold">پیش فاکتور فروش آنلاین قطعات زیگما</div>
                    <div>پیش فاکتور شماره {{$invoice->id}}</div>
                </div>
                <div>
                    <img uk-img src="/uploads/xigma_invoice_logo.png">
                </div>
            </div>
            <div class="uk-border-rounded uk-padding-small uk-background-default uk-margin-small uk-text-small"
                 style="border: 1px solid gainsboro">
                <div>
                    <div class="uk-grid uk-grid-small uk-child-width-1-3" data-uk-grid>
                        <div>
                            <span class="uk-text-muted">
                                تحویل گیرنده
                            </span>
                            <span class="uk-margin-left">
                                {{auth()->user()->name}}
                            </span>
                        </div>
                        <div>
                            <span class=" uk-text-muted">
                                شماره موبایل
                            </span>
                            <span class="uk-margin-left">
                                {{auth()->user()->mobile}}
                            </span>
                        </div>
                        <div>
                            <span class=" uk-text-muted">
                                 تاریخ ثبت
                            </span>
                            <span class="uk-margin-left">
                                {{$invoice->created_at}}
                            </span>
                        </div>
                        <div class="uk-width-expand">
                            <span class="uk-text-muted">
                                نشانی
                            </span>
                            <span class="uk-margin-left">

                            </span>
                        </div>
                    </div>
                    <div>

                    </div>
                </div>
            </div>
            <table class="uk-table uk-table-striped uk-table-small uk-table-middle uk-margin-small-bottom uk-text-small">
                <thead>
                <tr class="uk-background-primary">
                    <th class="uk-text-white uk-table-shrink">#</th>
                    <th class="uk-text-white">نام قطعه</th>
                    <th class="uk-text-white">نوع</th>
                    <th class="uk-text-white">تعداد</th>
                    <th class="uk-text-white">شماره سریال</th>
                    <th class="uk-text-white">قیمت واحد</th>
                    <th class="uk-text-white">قیمت کل</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoice->variations as $variation)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td class="">
                            <div class="uk-grid uk-grid-small uk-flex uk-flex-middle">
                                <div>
                                    <img uk-img width="50" src="{{$variation->picture->url ?? '/uploads/xigma_logo.png'}}">
                                </div>
                                <div class="uk-width-expand">
                                    <div>{{$variation->name}}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{$variation->filters}}</td>
                        <td>{{$variation->pivot->quantity}}</td>
                        <td>
                            <div>{{$variation->sku}}</div>
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
                            <td>{{number_format($invoice->variations->sum(function($v) {return $v->pivot->price * $v->pivot->quantity;}))}}</td>
                        </tr>
                        <tr class="uk-background-muted">
                            <td>جمع کل تخیفات</td>
                            <td>{{number_format($invoice->variations->sum(function($v) {
                        return $v->pivot->quantity * $v->pivot->discount;
                    }))}}</td>
                        </tr>
                        <tr class="uk-background-muted">
                            <td>جمع کل قیمت</td>
                            <td>{{number_format($invoice->variations->sum(function($v) {return $v->pivot->price * $v->pivot->quantity;}))}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="uk-margin-large-top uk-text-meta">
                <ul class="uk-list uk-list-disc">
                    <li>این پیش فاکتور به منزله خرید شما بصورت آنلاین از وب‌سایت زیگما نمی‌باشد</li>
                    <li>با توجه به تنوع در اقلام فنی، مسئولیت متناسب بودن قطعه خریداری شده با وسیله نقلیه بر عهده خریدار می‌باشد و وب‌سایت زیگما هیچگونه مسئولیتی در قبال آن نمی‌پذیرد</li>
                    <li>لغو خرید و یا مرجوعی کالای سالم برای هیچ فاکتوری در هیچ شرایطی امکان پذیر نمی‌باشد</li>
                </ul>
            </div>
            <div class="uk-margin-large-top uk-text-center hidden-in-print">
                <button onclick="window.print()" class="uk-button uk-button-secondary uk-background-gray uk-border-rounded">چاپ پیش فاکتور</button>
            </div>
        </div>
    </div>
@endsection