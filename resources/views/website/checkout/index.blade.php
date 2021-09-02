@extends('website.layouts.app')

@section('content')
    <div class="uk-section uk-section-default">
        <div class="uk-container">
            <front-checkout :gateways="{{json_encode($gateways)}}"></front-checkout>
        </div>
    </div>
@endsection