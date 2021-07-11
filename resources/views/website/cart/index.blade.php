@extends('website.layouts.app')

@section('content')
    <div class="uk-section uk-section-default">
        <div class="uk-container">
            @include('website.partials._invoiceTable', ['items' => $items])
            <div>
                <a href="/checkout" class="uk-button uk-button-small uk-button-secondary">تکمیل سفارش</a>
                <form method="post" action="/invoice" class="uk-display-inline-block">
                    @csrf
                    <button class="uk-button uk-button-small uk-button-primary">صدور پیش‌فاکتور از سبد خرید</button>
                </form>
            </div>
        </div>
    </div>
@endsection