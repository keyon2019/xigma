@extends('dashboard.layouts.dashboard')

@section('title', "ویرایش محصول $product->name")

@section('content')
    <edit-product :initial-product="{{$product}}"></edit-product>
@endsection