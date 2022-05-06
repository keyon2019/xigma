@extends('dashboard.layouts.dashboard')

@section('title', 'صفحه جدید')

@section('content')
    <create-page :top-menus="{{$topMenus}}"></create-page>
@endsection