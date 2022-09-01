@extends('dashboard.layouts.dashboard')

@section('title', 'پیغام گروهی جدید')

@section('content')
    <form onsubmit="Loading.show()" method="post" action="/dashboard/thread/bulk"
          class="uk-form-horizontal uk-margin">
        @csrf
        <div class="uk-margin">
            <label class="uk-form-label uk-text-bold">موضوع:</label>
            <div class="uk-form-controls">
                <input class="uk-input" type="text" placeholder="موضوع" name="title">
            </div>
        </div>
        <div class="uk-grid uk-child-width-1-2">
            <div>
                <label class="uk-form-label uk-text-bold">نوع وسیله نقلیه:</label>
                <div class="uk-form-controls">
                    <select name="vehicle" class="uk-select">
                        <option value="">انتخاب کنید</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="uk-form-label uk-text-bold">استان: </label>
                <div class="uk-form-controls">
                    <select name="province" class="uk-select">
                        <option value="">انتخاب کنید</option>
                        @foreach($provinces as $province)
                            <option value="{{$province->id}}">{{$province->name}}</option>
                        @endforeach
                    </select>
                </div>
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