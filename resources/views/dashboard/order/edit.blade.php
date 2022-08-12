@extends('dashboard.layouts.dashboard')

@section('title', " سفارش شماره $order->id")

@section('content')
    <edit-order :statuses="{{$orderStatuses}}" :initial-order="{{$order}}"></edit-order>
    <form method="post" action="/dashboard/order/{{$order->id}}">
        @method('patch')
        @csrf
        <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small uk-margin">
            <accordion :open="true" title="اطلاعات استرداد">
                <div class="uk-grid uk-grid-collapse uk-child-width-1-2 uk-margin-small-top uk-text-meta"
                     data-uk-grid>
                    <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle" style="border: 1px solid white">وضعیت
                        پرداخت:
                        {{$order->refunded_at != null ? 'مسترد شده' : 'در انتظار استرداد'}}</div>
                    <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle" style="border: 1px solid white">
                        <div class="uk-margin-small-right">تاریخ‌پرداخت:</div>
                        <input class="uk-input uk-border-rounded refunded_at"
                               value="{{$order->refunded_at}}">
                        <date-picker-wrapper custom-input=".refunded_at" name="refunded_at"
                                             value="{{$order->refunded_at}}"></date-picker-wrapper>
                    </div>
                    <div class="uk-padding-small uk-background-muted uk-flex uk-flex-middle" style="border: 1px solid white">
                        <div class="uk-margin-small-right">درگاه‌پرداخت:</div>
                        <select name="refund_gateway" class="uk-select uk-border-rounded">
                            <option value="">درگاه پرداخت</option>
                            @foreach(config('gateway') as $gateway)
                                <option @if($order->refund_gateway === $gateway['id']) selected
                                        @endif value="{{$gateway['id']}}">{{$gateway['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="uk-padding-small uk-flex uk-flex-middle uk-background-muted" style="border: 1px solid white">
                        <div class="uk-margin-small-right">شماره‌پیگیری:</div>
                        <input class="uk-input uk-border-rounded" name="refund_reference_number"
                               value="{{$order->refund_reference_number}}">
                    </div>
                </div>
            </accordion>
        </div>
        <button class="uk-button uk-button-primary uk-border-rounded hidden-in-print">ثبت استرداد</button>
    </form>
@endsection