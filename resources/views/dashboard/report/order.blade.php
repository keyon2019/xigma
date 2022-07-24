@extends('dashboard.layouts.dashboard')

@section('title', 'گزارش سفارش')

@section('content')
    <report-orders :provinces="{{$provinces}}"></report-orders>
@endsection