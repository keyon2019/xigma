@extends('dashboard.layouts.dashboard')

@section('title', " مرجوعی شماره $returnRequest->id")

@section('content')
    <div>اطلاعات کاربری</div>
    <div class="uk-background-default uk-border-rounded uk-padding-small uk-box-shadow-small uk-margin-small-top">
        <div class="uk-grid uk-child-width-1-2 uk-grid-small" data-uk-grid>
            <div>نام کاربر: {{$returnRequest->user->name}}</div>
            <div>تاریخ ثبت مرجوعی: {{$returnRequest->created_at}}</div>
            <div>شماره تماس: {{$returnRequest->user->mobile}}</div>
            <div>شماره سفارش: {{$returnRequest->order_id}}</div>
        </div>
    </div>

    <div class="uk-margin-top">اطلاعات محصول مرجوعی</div>
    <div class="uk-background-default uk-border-rounded uk-padding-small uk-box-shadow-small uk-margin-small-top">
        <table class="uk-table uk-table-divider uk-table-striped uk-table-middle">
            <thead>
            <tr>
                <th>تصویر</th>
                <th>کد محصول</th>
                <th>نام محصول</th>
                <th>نوع</th>
                <th>قیمت</th>
                <th>تعداد</th>
                <th>تخفیف</th>
                <th>قیمت کل</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <img class="uk-border-rounded" uk-img width="60" src="{{$returnRequest->variation->picture->url}}">
                </td>
                <td>
                    {{$returnRequest->variation->sku}}
                </td>
                <td>
                    {{$returnRequest->variation->name}}
                </td>
                <td>
                    {{$returnRequest->variation->filters}}
                </td>
                <td>
                    {{number_format($returnRequest->price)}}
                </td>
                <td>
                    {{$returnRequest->quantity}}
                </td>
                <td>
                    {{number_format($returnRequest->discount)}}
                </td>
                <td>
                    {{number_format($returnRequest->price * $returnRequest->quantity)}} تومان
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="uk-margin-top">
        <div>علت مرجوعی</div>
        <input class="uk-input uk-width-large uk-border-rounded" readonly value="{{$returnRequest->reasonName}}">
    </div>
    <div class="uk-margin-top">
        <div>شرح مشکل</div>
        <textarea rows="4" class="uk-textarea uk-border-rounded" readonly>{{$returnRequest->elaboration}}</textarea>
    </div>
    <div class="uk-margin-top">
        <div>تصاویر ارسالی</div>
        <modal :close="true" name="slideshowmodal" class="" :transparent-dialog="true">
            <slideshow
                    :images="{{json_encode(collect($returnRequest->images)->map(function($v) {return "/$v";}))}}"></slideshow>
        </modal>
        <div class="uk-grid uk-grid-small">
            @foreach($returnRequest->images as $index => $image)
                <div>
                    <img class="uk-border-rounded clickable" uk-img
                         onclick="Modal.show('slideshowmodal')"
                         style="width:100px;height:100px;object-position: center;object-fit: cover" src="/{{$image}}">
                </div>
            @endforeach
        </div>
    </div>
    <form method="post" action="/dashboard/return_request/{{$returnRequest->id}}">
        @csrf
        @method('patch')
        <div class="uk-margin-top">درخواست کاربر: {{$returnRequest->enquiryName}}</div>
        <div class="uk-margin uk-form-horizontal">
            <label class="uk-form-label">نظر کارشناس</label>
            <div class="uk-form-controls">
                <select name="technical_status" class="uk-select uk-width-large uk-border-rounded">
                    <option value="">نظر کارشناس</option>
                    @foreach($technicalStatuses->keyValues() as $key => $status)
                        <option @if($returnRequest->technical_status === $key) selected
                                @endif value="{{$key}}">{{$status}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label">
                <span class="uk-margin-large-right">نظر فنی کارشناس</span>
                <span>نام کارشناس: {{$returnRequest->technician ? $returnRequest->technician->name : auth()->user()->name}}</span>
            </label>
            <div class="uk-form-controls uk-margin-small-top">
                <textarea name="technical_comment" rows="5"
                          class="uk-textarea uk-border-rounded">{{$returnRequest->technical_comment}}</textarea>
            </div>
            <input type="hidden" name="technician_id" value="{{auth()->id()}}">
        </div>
        <div class="uk-margin uk-form-horizontal">
            <label class="uk-form-label">وضعیت مرجوعی</label>
            <div class="uk-form-controls">
                <select name="status" class="uk-select uk-width-large uk-border-rounded">
                    @foreach($statuses->keyValues() as $key => $status)
                        <option @if($returnRequest->status === $key) selected
                                @endif value="{{$key}}">{{$status}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small uk-margin">
            <accordion :open="true" title="اطلاعات گیرنده">
                <div class="uk-grid uk-grid-collapse uk-child-width-1-2 uk-margin-small-top uk-text-meta"
                     data-uk-grid>
                    <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">نام و نام
                        خانوادگی: {{$returnRequest->receiver_name}}</div>
                    <div class="uk-padding-small uk-background-muted" style="border: 1px solid white">شماره
                        تماس: {{$returnRequest->receiver_number}}</div>
                    <div class="uk-padding-small uk-background-muted uk-width-1-1" style="border: 1px solid white">آدرس
                        گیرنده: {{$returnRequest->address->directions ?? ''}}
                    </div>
                </div>
            </accordion>
        </div>
        <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small uk-margin">
            <accordion :open="true" title="اطلاعات پرداخت">
                <div class="uk-grid uk-grid-collapse uk-child-width-1-2 uk-margin-small-top uk-text-meta"
                     data-uk-grid>
                    <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle" style="border: 1px solid white">وضعیت
                        پرداخت:
                        {{$returnRequest->payed_at != null ? 'پرداخت شده' : 'در انتظار پرداخت'}}</div>
                    <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle" style="border: 1px solid white">
                        <div class="uk-margin-small-right">تاریخ‌پرداخت:</div>
                        <input class="uk-input uk-border-rounded payed_at"
                               value="{{$returnRequest->payed_at}}">
                        <date-picker-wrapper custom-input=".payed_at" name="payed_at"
                                             value="{{$returnRequest->payed_at}}"></date-picker-wrapper>
                    </div>
                    <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle" style="border: 1px solid white">
                        <div class="uk-margin-small-right">درگاه‌پرداخت:</div>
                        <select name="gateway" class="uk-select uk-border-rounded">
                            <option value="">درگاه پرداخت</option>
                            @foreach(config('gateway') as $gateway)
                                <option @if($returnRequest->gateway === $gateway['id']) selected
                                        @endif value="{{$gateway['id']}}">{{$gateway['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="uk-padding-small uk-flex uk-flex-middle uk-background-muted" style="border: 1px solid white">
                        <div class="uk-margin-small-right">شماره‌پیگیری:</div>
                        <input class="uk-input uk-border-rounded" name="reference_number"
                               value="{{$returnRequest->reference_number}}">
                    </div>
                </div>
            </accordion>
        </div>
        <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small uk-margin">
            <accordion :open="true" title="اطلاعات ارسال">
                <div class="uk-grid uk-grid-collapse uk-child-width-1-2 uk-margin-small-top uk-text-meta"
                     data-uk-grid>
                    <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle" style="border: 1px solid white">
                        <div class="uk-margin-small-right">نحوه‌ارسال:</div>
                        <select name="shipping_method" class="uk-select uk-border-rounded">
                            <option value="">انتخاب کنید...</option>
                            @foreach($shippingMethods->keyValues() as $key => $method)
                                <option @if($returnRequest->shipping_method === $key) selected
                                        @endif value="{{$key}}">{{$method}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle" style="border: 1px solid white">
                        <div class="uk-margin-small-right">تاریخ‌ارسال:</div>
                        <input class="uk-input uk-border-rounded shipped_at"
                               value="{{$returnRequest->shipped_at}}">
                        <date-picker-wrapper custom-input=".shipped_at" name="shipped_at"
                                             value="{{$returnRequest->shipped_at}}"></date-picker-wrapper>
                    </div>
                    <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle" style="border: 1px solid white">هزینه
                        ارسال: رایگان
                    </div>
                    <div class="uk-padding-small uk-flex uk-flex-middle uk-background-muted" style="border: 1px solid white">
                        <div class="uk-margin-small-right">شماره‌مرسوله:</div>
                        <input class="uk-input uk-border-rounded" name="shipping_code"
                               value="{{$returnRequest->shipping_code}}">
                    </div>
                </div>
            </accordion>
        </div>
        <div class="uk-grid hidden-in-print">
            <div class="uk-width-expand"></div>
            <div>
                <button type="submit" class="uk-button uk-button-success uk-border-rounded uk-text-white">ثبت اطلاعات</button>
                <button type="button" onclick="window.print()" class="uk-button uk-button-primary uk-border-rounded">چاپ فاکتور مرجوعی</button>
            </div>
        </div>
    </form>
@endsection

