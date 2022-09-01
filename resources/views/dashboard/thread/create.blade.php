@extends('dashboard.layouts.dashboard')

@section('title', 'پیغام جدید')

@section('content')
    <form onsubmit="Loading.show()"
          method="post" action="/dashboard/thread" class="uk-form-horizontal uk-margin">
        @csrf
        <div class="uk-margin">
            <label class="uk-form-label uk-text-bold">موضوع:</label>
            <div class="uk-form-controls">
                <input class="uk-input" type="text" placeholder="موضوع" name="title">
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label uk-text-bold">انتخاب کاربر:</label>
            <div class="uk-form-controls">
                <auto-complete name="user_id" value-key="id" api-result-key="users" method="get"
                               api="/dashboard/user/search" placeholder="کاربر"></auto-complete>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label uk-text-bold">متن پیام:</label>
            <div class="uk-form-controls">
                <textarea class="uk-textarea" name="message" rows="4" placeholder="متن پیام">

                </textarea>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label uk-text-bold"></label>
            <div class="uk-form-controls">
                <label><input class="uk-checkbox" type="checkbox" value="1" name="repliable"> قابل پاسخ </label>
            </div>
        </div>
        <div class="uk-margin">
            <button class="uk-button uk-width-medium uk-float-right uk-border-rounded uk-button-primary">ارسال</button>
        </div>
    </form>
@endsection