@extends('dashboard.layouts.dashboard')

@section('title', "ویرایش دسته‌بندی $category->name")

@section('content')
    <edit-category :initial-category="{{$category}}"></edit-category>
@endsection