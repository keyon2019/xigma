@extends('dashboard.layouts.dashboard')

@section('title', "ویرایش اسلایدر $slider->name")

@section('content')
    <edit-slider :initial-slider="{{$slider}}"></edit-slider>
@endsection