@extends('dashboard.layouts.dashboard')

@section('title', "ویرایش نماینده $retailer->name")

@section('content')
    <edit-retailer :initial-retailer="{{$retailer}}"></edit-retailer>
@endsection