@extends('website.layouts.profile')

@section('profile-content')
    <h4 class="uk-text-muted">آخرین سفارش‌ها</h4>
    <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small">
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