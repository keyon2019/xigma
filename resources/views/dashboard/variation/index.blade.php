@extends('dashboard.layouts.dashboard')

@section('title', 'انبار و موجودی')

@section('content')
    <variations :categories="{{$categories}}"></variations>
@endsection