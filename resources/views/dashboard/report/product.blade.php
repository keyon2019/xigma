@extends('dashboard.layouts.dashboard')

@section('title', 'گزارش پرفروش‌ترین محصولات')

@section('content')
    <report-products :provinces="{{$provinces}}" :vehicles="{{$vehicles}}"></report-products>
@endsection