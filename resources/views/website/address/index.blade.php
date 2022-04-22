@extends('website.layouts.profile')

@section('profile-content')
    <h4 class="uk-text-muted uk-margin-remove">نشانی‌های ثبت شده</h4>
    <p class="uk-margin-small uk-text-small">شما می‌توانید با ثبت نشانی‌هایی که بیشتر از آنها استفاده می‌کنید، هنگام خرید کالا در قسمت درج آدرس گیرنده به سادگی از آنها استفاده کنید.</p>
    <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small">
        <front-addresses></front-addresses>
    </div>
@endsection