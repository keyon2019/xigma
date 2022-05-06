@extends('dashboard.layouts.dashboard')

@section('title', "ویرایش صفحه $page->name")

@section('content')
    <edit-page :top-menus="{{$topMenus}}" :initial-page="{{$page}}"></edit-page>
@endsection