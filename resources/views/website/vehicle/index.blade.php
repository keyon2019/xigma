@extends('website.layouts.profile')

@section('profile-content')
    <h4 class="uk-text-muted">وسایل نقلیه من</h4>
    <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small">
        <front-vehicles :user-vehicles="{{$vehicles}}"></front-vehicles>
    </div>
@endsection