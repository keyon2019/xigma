@extends('dashboard.layouts.dashboard')

@section('title', 'مرجوعی‌ها')

@section('content')
    <return-requests :statuses="{{$statuses}}"></return-requests>
@endsection