@extends('dashboard.layouts.dashboard')

@section('title', "فاکتور درب فروشگاه جدید")

@section('content')
    <create-store-invoice :retailers="{{$retailers}}"></create-store-invoice>
@endsection
