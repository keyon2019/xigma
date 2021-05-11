@extends('dashboard.layouts.dashboard')

@section('title', "ویرایش وسیله نقیله $vehicle->name")

@section('content')
    <edit-vehicle :initial-vehicle="{{$vehicle}}"></edit-vehicle>
@endsection