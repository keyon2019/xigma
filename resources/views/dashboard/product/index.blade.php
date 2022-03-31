@extends('dashboard.layouts.dashboard')

@section('title', 'محصولات')

@section('content')
    <products :options="{{$options}}"></products>
@endsection