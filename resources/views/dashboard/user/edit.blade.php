@extends('dashboard.layouts.dashboard')

@section('title', "ویرایش کاربر $user->name")

@section('content')
    <edit-user :initial-user="{{$user}}"></edit-user>
@endsection