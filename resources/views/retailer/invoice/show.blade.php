@extends('dashboard.layouts.dashboard')

@section('title', "فاکتور شماره $invoice->id")

@section('content')
    <store-invoice :invoice="{{$invoice}}"></store-invoice>
@endsection
