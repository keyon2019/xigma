@extends('website.layouts.app')

@section('content')
    <div class="uk-section uk-section-default uk-section-small">
        <div class="uk-container">
            <front-checkout :gateways="{{json_encode($gateways)}}"></front-checkout>
        </div>
    </div>
@endsection