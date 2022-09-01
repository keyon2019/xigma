@extends('dashboard.layouts.dashboard')

@section('title', "$thread->title")

@section('content')
    <div class="uk-margin-small-bottom">
        کاربر: {{$thread->user->name}}
    </div>
    <div class="uk-container uk-container-small">

        <div class="uk-clearfix">
            <div class="uk-background-default uk-border-rounded
         uk-width-2-3 uk-box-shadow-small uk-float-left uk-padding-small">
                <div class="uk-grid uk-flex uk-flex-middle">
                    <div class="uk-text-bold uk-width-expand">{{$thread->title}}</div>
                    <div class="uk-text-meta">{{$thread->created_at}}</div>
                </div>
                <div class="uk-margin-small">{{$thread->message}}</div>
                <div class="uk-text-small uk-text-bold uk-text-primary">زیــگما</div>
            </div>
        </div>
        @foreach($thread->replies as $reply)
            <div class="uk-clearfix uk-margin-top">
                <div class="uk-background-default uk-border-rounded
         uk-width-2-3 uk-box-shadow-small uk-float-right uk-padding-small">
                    <div class="uk-grid uk-flex uk-flex-middle">
                        <div class="uk-text-bold uk-width-expand"></div>
                        <div class="uk-text-meta">{{$reply->created_at}}</div>
                    </div>
                    <div class="uk-margin-small">{{$reply->message}}</div>
                    <div class="uk-text-small uk-text-bold @if($reply->user_id == $thread->user_id) uk-float-right @else uk-float-left @endif uk-text-primary">{{$reply->user->name}}</div>
                </div>
            </div>
        @endforeach

        <form class="uk-margin-top" onsubmit="Loading.show()" method="POST" action="/thread/{{$thread->id}}/reply"
              class="uk-margin-auto uk-margin-bottom">
            @csrf
            <div class=" uk-background-default uk-border-rounded uk-box-shadow-small uk-padding-small">
                <div class="uk-text-bold">ارسال پاسخ</div>
                <textarea rows="5" class="uk-textarea uk-margin-small" name="message"
                          placeholder="متن پاسخ" required></textarea>
                <button class="uk-button uk-button-primary uk-border-rounded">ارسال</button>
            </div>
        </form>
    </div>
@endsection