@extends('website.layouts.profile')

@section('title', 'پیغام‌ها')

@section('profile-content')
    <h4 class="uk-text-muted">پیغام‌ها</h4>
    <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small">
        <threads :is-admin="false"></threads>
    </div>
@endsection