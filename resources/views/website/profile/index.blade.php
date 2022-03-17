@extends('website.layouts.profile')

@section('profile-content')
    <h5 class="uk-text-muted uk-margin-small-bottom">وضعیت حساب کاربری</h5>
    <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small">
        <div class="uk-grid uk-child-width-1-4@m uk-flex uk-flex-middle uk-flex-center">
            <div>
                <p class="uk-text-small uk-text-meta uk-margin-remove uk-text-center"><span data-uk-icon="icon:user;ratio:0.8"></span> نوع حساب</p>
                <p class="uk-margin-small uk-text-center">مشتری عادی</p>
            </div>
            <div>
                <p class="uk-text-small uk-text-meta uk-margin-remove uk-text-center"><span data-uk-icon="icon:star;ratio:0.8"></span> مجموع امتیازات</p>
                <p class="uk-margin-small uk-text-center">۲۷۰۰</p>
            </div>
            <div>
                <p class="uk-text-small uk-text-meta uk-margin-remove uk-text-center"><span data-uk-icon="icon:bolt;ratio:0.8"></span> وسایل نقلیه</p>
                <p class="uk-margin-small uk-text-center"><a href="/vehicle">{{auth()->user()->vehicles()->count()}} وسیله نقلیه ثبت شده</a></p>
            </div>
            <div>
                <p class="uk-text-small uk-text-meta uk-margin-remove uk-text-center"><span data-uk-icon="icon:calendar;ratio:0.8"></span> تاریخ عضویت</p>
                <p class="uk-margin-small uk-text-center">{{auth()->user()->created_at}}</p>
            </div>
        </div>
    </div>
    <h5 class="uk-text-muted uk-margin-small-bottom">آخرین سفارش‌ها</h5>
    <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small uk-overflow-auto">
        <table class="uk-table uk-table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>شماره سفارش</th>
                <th>تاریخ ثبت</th>
                <th>مبلغ</th>
                <th>وضعیت پرداخت</th>
                <th>وضعیت سفارش</th>
                <th>جزئیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{$loop->index + 1}}</td>
                    <td>XGM-{{$order->id}}</td>
                    <td>{{$order->created_at}}</td>
                    <td>{{number_format($order->total)}}</td>
                    <td>{{$order->paid ? 'پرداخت شده' : 'پرداخت نشده'}}</td>
                    <td>{{$order->statusName}}</td>
                    <td class="uk-text-center"><a href="/order/{{$order->id}}" data-uk-icon="chevron-left"></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection