@extends('website.layouts.profile')

@section('profile-content')
    <create-coupon :total-points="{{$points}}"></create-coupon>
@endsection