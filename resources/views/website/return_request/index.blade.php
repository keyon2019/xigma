@extends('website.layouts.profile')

@section('profile-content')
    <h4 class="uk-text-muted">درخواست‌های مرجوعی من</h4>
    <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small">
        <front-return-requests></front-return-requests>
    </div>
@endsection