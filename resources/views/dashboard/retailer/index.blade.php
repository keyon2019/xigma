@extends('dashboard.layouts.dashboard')

@section('title', 'نمایندگی‌ها')

@section('content')
    <div class="uk-grid">
        <div class="uk-width-1-2@m">
            <mapbox :interactive="true"></mapbox>
        </div>
    </div>
@endsection