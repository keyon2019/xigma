@extends('dashboard.layouts.dashboard')

@section('title', "ثبت تخفیف محصولات")

@section('content')
    <create-discount :categories="{{$categories}}"></create-discount>
@endsection