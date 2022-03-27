@extends('dashboard.layouts.dashboard')

@section('title', "ویرایش ویجت $widget->name")

@section('content')
    <form method="post" action="/dashboard/widget/{{$widget->id}}">
        <fieldset class="uk-fieldset uk-width-1-2">
            @include('dashboard.widget.form', [
            'widget' => $widget,
            'categories' => $categories
            ])
            @method('patch')
            <button type="submit" class="uk-button uk-button-primary">ویرایش</button>
        </fieldset>
    </form>
@endsection