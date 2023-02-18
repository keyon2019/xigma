
@extends('dashboard.layouts.dashboard')

@section('title', 'انبار و موجودی')

@section('content')
    <stock :categories="{{\App\Models\Category::root()->with('subCategories')->get()}}"></stock>
@endsection
