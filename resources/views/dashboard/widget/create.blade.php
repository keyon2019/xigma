@extends('dashboard.layouts.dashboard')

@section('title', 'ویجت جدید')

@section('content')
    <form method="post" action="/dashboard/widget">
        <fieldset class="uk-fieldset uk-width-1-2">
            @include('dashboard.widget.form', ['widget' => $widget, 'categories' => $categories])
            <button type="submit" class="uk-button uk-button-secondary">ثبت</button>
        </fieldset>
    </form>
@endsection