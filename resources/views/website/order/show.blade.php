@extends('website.layouts.profile')

@section('profile-content')
    <h4 class="uk-text-muted">جزئیات سفارش شماره XGM-{{$order->id}}</h4>
    <ul class="uk-list">
        <li class="uk-text-small">وضعیت پرداخت: <strong>{{$order->paid ? 'پرداخت شده' : 'در انتظار پرداخت'}}</strong></li>
        <li class="uk-text-small">وضعیت سفارش: <strong>{{$order->statusName}}</strong></li>
    </ul>

    <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small">
        @include('website.partials._invoiceTable', ['items' => $order->variations])
    </div>
@endsection