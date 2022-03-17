@extends('dashboard.layouts.dashboard')

@section('title', "ویرایش صفحه $page->name")

@section('content')
    <edit-page :initial-page="{{$page}}"></edit-page>
@endsection