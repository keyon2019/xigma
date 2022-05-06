@extends('dashboard.layouts.dashboard')

@section('title', " پیش‌فاکتور شماره $invoice->id")

@section('content')
    <edit-invoice :initial-invoice="{{$invoice}}"></edit-invoice>
@endsection