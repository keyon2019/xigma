@extends('website.layouts.profile')

@section('profile-content')
    <h4 class="uk-text-muted">جزئیات درخواست مرجوعی شماره XGM-{{$returnRequest->id}}</h4>

    <div class="uk-background-default uk-border-rounded uk-padding-small uk-box-shadow-small">
        <div class="uk-padding-small uk-background-muted uk-border-rounded">
            <div class="uk-grid uk-flex uk-flex-middle uk-grid-small" data-uk-grid>
                <div class="uk-width-1-5">
                    <img class="uk-width-expand uk-border-rounded"
                         src="{{$returnRequest->variation->picture->url ?? '/uploads/xigma_logo.png'}}">
                </div>
                <div class="uk-width-expand">
                    <div class="uk-text-bold uk-text-medium">{{$returnRequest->variation->name}}</div>
                    <div><span>کد محصول: </span>{{$returnRequest->variation->sku}}</div>
                    @foreach($returnRequest->variation->values as $value)
                        <div class="uk-text-meta">
                            {{$value->option->name}} : <span class="uk-text-bold">{{$value->name}}</span>
                        </div>
                    @endforeach
                    <div>
                        <div class="uk-grid uk-grid-small uk-grid-divider uk-margin-small-top uk-text-small">
                            <div class="uk-first-column">تعداد: {{$returnRequest->quantity}} عدد</div>
                            <div>قیمت واحد: {{number_format($returnRequest->price + $returnRequest->discount)}}</div>
                            @if($returnRequest->discount > 0)
                                <div>تخفیف: {{number_format($returnRequest->discount)}}</div>
                            @endif
                            <div>قیمت کل: {{number_format($returnRequest->price * $returnRequest->quantity)}}</div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-6@m uk-text-small hidden-in-print">
                    <div>
                        <a href="/product/{{$returnRequest->variation->product_id}}"
                           class="uk-button uk-button-link uk-button-small uk-border-rounded uk-flex uk-flex-middle">
                            <i class="fa-solid fa-plus uk-margin-small-right"></i>
                            <span>خرید مجدد کالا</span>
                        </a>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="uk-grid uk-margin-small-bottom" data-uk-grid>
                <div class="uk-width-expand">
                    علت مرجوعی: {{$returnRequest->reasonName}}
                </div>
                <div>
                    شماره سفارش: <a href="/order/{{$returnRequest->order_id}}">{{$returnRequest->order_id}}</a>
                </div>
            </div>
            <div>درخواست کاربر: {{$returnRequest->enquiryName}}</div>
            <div class="uk-background-default uk-border-rounded uk-padding-small uk-text-small uk-box-shadow-small uk-margin-top">
                <div class="uk-margin-small-bottom uk-text-bold">توضیحات</div>
                <div class="uk-grid uk-grid-small uk-flex uk-flex-middle">
                    <div class="uk-width-1-6@m">توضیحات کاربر</div>
                    <div class="uk-width-expand">
                        <textarea disabled class="uk-textarea uk-border-rounded"
                                  rows="3">{{$returnRequest->elaboration}}</textarea>
                    </div>
                </div>
                <div class="uk-grid uk-grid-small uk-flex uk-flex-middle">
                    <div class="uk-width-1-6@m">نظر کارشناسی</div>
                    <div class="uk-width-expand">
                        <textarea disabled class="uk-textarea uk-border-rounded"
                                  rows="3">{{$returnRequest->technical_comment}}</textarea>
                    </div>
                </div>
            </div>
            <div class="uk-background-default uk-border-rounded uk-padding-small uk-text-small uk-box-shadow-small uk-margin-top">
                <div class="uk-margin-small-bottom uk-text-bold">تصاویر ارسالی</div>
                <div class="uk-grid uk-grid-small">
                    @foreach($returnRequest->images as $image)
                        <div>
                            <img class="uk-border-rounded" uk-img
                                 style="width:100px;height:100px;object-position: center;object-fit: cover" src="/{{$image}}">
                        </div>
                    @endforeach
                </div>
            </div>
            @if($returnRequest->status == \App\Enum\ReturnRequestStatus::WAITING_FOR_ADDRESS && !$returnRequest->address_id)
                <address-component :return-request="{{$returnRequest}}"
                                   class="uk-background-default uk-border-rounded uk-box-shadow-small uk-padding-small uk-margin-top">
                    @CSRF
                </address-component>
            @elseif($returnRequest->address_id)
                <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small uk-margin">
                    <accordion :open="true" title="اطلاعات دریافت مرجوعی">
                        <div class="uk-grid uk-grid-collapse uk-child-width-1-2@m uk-margin-small-top uk-text-meta"
                             data-uk-grid>
                            <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">نام و نام
                                خانوادگی: {{$returnRequest->receiver_name}}</div>
                            <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">شماره
                                تماس: {{$returnRequest->receiver_number}}</div>
                            <div class="uk-padding-small uk-background-muted uk-width-1-1" style="border: 1px solid white">آدرس
                                گیرنده: {{$returnRequest->address->province}} - {{$returnRequest->address->city}} - {{$returnRequest->address->directions}}
                            </div>
                        </div>
                    </accordion>
                </div>
            @endif
            @if($returnRequest->shipping_method != null)
                <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small uk-margin">
                    <accordion :open="true" title="اطلاعات ارسال">
                        <div class="uk-grid uk-grid-collapse uk-child-width-1-2 uk-margin-small-top uk-text-meta"
                             data-uk-grid>
                            <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle"
                                 style="border: 1px solid white">
                                <div class="uk-margin-small-right">نحوه‌ارسال:</div>
                                <div>{{$returnRequest->shipping_method_name}}</div>
                            </div>
                            <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle"
                                 style="border: 1px solid white">
                                <div class="uk-margin-small-right">تاریخ‌ارسال:</div>
                                <div>{{$returnRequest->shipped_at}}</div>
                            </div>
                            <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle"
                                 style="border: 1px solid white">هزینه
                                ارسال: رایگان
                            </div>
                            <div class="uk-padding-small uk-flex uk-flex-middle uk-background-muted"
                                 style="border: 1px solid white">
                                <div class="uk-margin-small-right">شماره‌مرسوله:</div>
                                <div>{{$returnRequest->shipping_code}}</div>
                            </div>
                        </div>
                    </accordion>
                </div>
            @endif
            @if($returnRequest->payed_at)
                <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small uk-margin">
                    <accordion :open="true" title="اطلاعات پرداخت استرداد وجه">
                        <div class="uk-grid uk-grid-collapse uk-child-width-1-2 uk-margin-small-top uk-text-meta"
                             data-uk-grid>
                            <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle"
                                 style="border: 1px solid white">وضعیت
                                پرداخت:
                                {{$returnRequest->payed_at != null ? 'پرداخت شده' : 'در انتظار پرداخت'}}</div>
                            <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle"
                                 style="border: 1px solid white">
                                <div class="uk-margin-small-right">تاریخ‌پرداخت:</div>
                                <div>{{$returnRequest->payed_at}}</div>
                            </div>
                            <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle"
                                 style="border: 1px solid white">
                                <div class="uk-margin-small-right">درگاه‌پرداخت:</div>
                                <div>{{collect(config('gateway'))->firstWhere('id', $returnRequest->gateway)['name']}}</div>
                            </div>
                            <div class="uk-padding-small uk-flex uk-flex-middle uk-background-muted"
                                 style="border: 1px solid white">
                                <div class="uk-margin-small-right">شماره‌پیگیری:</div>
                                <div>{{$returnRequest->reference_number}}</div>
                            </div>
                        </div>
                    </accordion>
                </div>
            @endif
            @if(in_array($returnRequest->status, [4,6,7], true))
                <div class="uk-text-center hidden-in-print">
                    <button class="uk-button uk-button-secondary uk-border-rounded"
                            onclick="window.scrollTo(0,0);setTimeout(() => {window.print()}, 500)">چاپ فاکتور مرجوعی
                    </button>
                </div>
            @endif
        </div>
    </div>


@endsection