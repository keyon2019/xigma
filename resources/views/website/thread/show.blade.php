@extends('website.layouts.profile')

@section('title', "$thread->title")

@section('profile-content')
    <h4 class="uk-text-muted">پیغام {{$thread->title}}</h4>
    <hr/>
    <div class="uk-container uk-container-small">
        <div class="@if($thread->repliable) uk-clearfix @endif">
            <div class="uk-background-default uk-border-rounded
         uk-box-shadow-small @if($thread->repliable) uk-width-2-3 uk-float-right @endif uk-padding-small">
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
         uk-width-2-3 uk-box-shadow-small @if($reply->user_id != $thread->user_id) uk-float-right @else uk-float-left @endif uk-padding-small">
                    <div class="uk-grid uk-flex uk-flex-middle">
                        <div class="uk-text-bold uk-width-expand"></div>
                        <div class="uk-text-meta">{{$reply->created_at}}</div>
                    </div>
                    <div class="uk-margin-small">{{$reply->message}}</div>
                    <div class="uk-text-small uk-text-bold uk-text-primary">{{$reply->user->name}}</div>
                </div>
            </div>
        @endforeach
        @if($thread->repliable)
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
        @endif
    </div>
@endsection