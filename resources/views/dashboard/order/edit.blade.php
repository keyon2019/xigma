@extends('dashboard.layouts.dashboard')

@section('title', " سفارش شماره $order->id")

@section('content')
    <edit-order :statuses="{{$orderStatuses}}" :initial-order="{{$order}}"></edit-order>
@endsection