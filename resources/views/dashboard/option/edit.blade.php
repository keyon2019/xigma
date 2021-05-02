@extends('dashboard.layouts.dashboard')

@section('title', "ویرایش فیلتر $option->name")

@section('content')
    <edit-option :initial-option="{{$option}}"></edit-option>
@endsection