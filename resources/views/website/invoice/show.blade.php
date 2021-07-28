@extends('website.layouts.app')

@section('content')
    <div class="uk-section uk-section-default">
        <div class="uk-container">
            <div class="uk-grid uk-flex uk-flex-middle uk-margin">
                <div class="uk-width-1-3"></div>
                <div class="uk-width-1-3 uk-text-center">
                    <img uk-img width="100" src="/uploads/xigma_logo.png">
                </div>
                <div class="uk-width-1-3 uk-text-small">
                    <p class="uk-margin-small"><strong>شماره فاکتور: </strong>{{$invoice->id}}</p>
                    <p class="uk-margin-small"><strong>تاریخ: </strong>{{$invoice->created_at}}</p>
                </div>
            </div>
            @include('website.partials._invoiceTable', ['items' => $invoice->variations])
            <div class="uk-margin-top hidden-in-print">
                <button class="uk-button uk-button-secondary uk-border-rounded" onclick="print()">چاپ فاکتور</button>
                <button class="uk-button uk-button-primary uk-border-rounded">ثبت سفارش فاکتور</button>
            </div>
        </div>
    </div>
@endsection