@extends('website.layouts.profile')

@section('profile-content')
    <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small uk-margin">
        <h4 class="uk-text-muted">اطلاعات کاربری</h4>
        <form class="uk-form-horizontal" method="post" action="/profile">
            @csrf
            @method('patch')
            <div class="uk-margin-bottom">
                <label class="uk-form-label" for="form-horizontal-text">نام و نام خانوادگی</label>
                <div class="uk-form-controls">
                    <input required name="name" class="uk-input uk-border-rounded" id="form-horizontal-text" type="text"
                           value="{{$user->name}}"
                           placeholder="نام و نام خانواداگی">
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-text">شماره موبایل</label>
                <div class="uk-form-controls">
                    <input required name="mobile" disabled class="uk-input uk-border-rounded" id="form-horizontal-text"
                           type="text" value="{{$user->mobile}}"
                           placeholder="شماره موبایل">
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-text">تاریخ تولد</label>
                <div class="uk-form-controls uk-flex uk-flex-bottom">
                    <input class="uk-input uk-border-rounded birthday"
                           value="{{$user->birthday}}">
                    <date-picker-wrapper
                            format="YYYY-MM-DD"
                            display-format="jYYYY/jMM/jDD"
                            custom-input=".birthday"
                            name="birthday"
                            value="{{$user->birthday}}"></date-picker-wrapper>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-text">شماره تلفن ثابت</label>
                <div class="uk-form-controls uk-flex uk-flex-bottom">
                    <input name="telephone" class="uk-input uk-width-medium@m uk-form-blank" id="form-horizontal-text"
                           style="border-bottom: 1px solid gainsboro" type="text" value="{{$user->telephonePart}}"
                           placeholder="شماره تلفن">
                    <span class="uk-padding-small uk-padding-remove-vertical">--</span>
                    <input name="area_code" class="uk-input uk-width-small@m uk-form-blank" id="form-horizontal-text"
                           style="border-bottom: 1px solid gainsboro" type="number" max="100" value="{{$user->areaCode}}"
                           placeholder="کد شهر">
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-text">شماره موبایل اضطراری</label>
                <div class="uk-form-controls">
                    <input name="emergency_mobile" class="uk-input uk-border-rounded" id="form-horizontal-text" type="text"
                           value="{{$user->emergency_mobile}}" placeholder="شماره موبایل اضطراری">
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-horizontal-text">آدرس ایمیل</label>
                <div class="uk-form-controls">
                    <input name="email" class="uk-input uk-border-rounded" id="form-horizontal-text" type="email" required
                           value="{{$user->email}}"
                           placeholder="آدرس ایمیل ">
                </div>
            </div>
            <div class="uk-text-center">
                <button class="uk-button uk-button-success uk-border-rounded uk-text-white">ثبت اصلاحات</button>
            </div>
        </form>
    </div>
    <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small uk-margin">
        <div class="uk-text-small uk-text-bold uk-margin uk-margin-remove-bottom">انتخاب وسیله نقلیه</div>
        <div class="uk-text-meta"> شما می‌توانید جهت سهولت در استفاده از امکانات و جستجوی دقیق‌تر بین محصولات وسیله نقلیه خود را
            انتخاب و سیستم را هوشمند‌تر ساز سازید
        </div>
        <div class="uk-grid uk-flex uk-flex-middle uk-margin-top uk-padding">
            <div class="uk-width-1-4 uk-flex uk-flex-middle uk-text-muted">
                افزودن <span class="uk-margin-left uk-border-rounded uk-padding-small clickable"
                             style="border: 1px solid gainsboro"><i class="fa-solid fa-4x fa-plus"></i></span>
            </div>
            <div class="uk-width-expand">
                @foreach($user->vehicles as $vehicle)
                    <div class="uk-flex uk-flex-middle uk-margin" style="justify-content: flex-end;">
                        <span>{{$vehicle->name}}</span><span><img uk-img width="100"
                                                                  class="uk-margin-left uk-margin-right uk-border-rounded"
                                                                  src="{{$vehicle->splashUrl}}"></span><a class="uk-link-reset"><i
                                    uk-icon="trash"></i></a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-small uk-margin">
        <h4 class="uk-text-muted">تغییر رمز عبور</h4>
        <div class="uk-text-small">
            <p>رمز عبور باید دارای حداقل ۸ کاراکتر باشد</p>
        </div>
        <div class="uk-padding-small uk-border-rounded">
            <form class="uk-form-horizontal" method="post" action="/password">
                @csrf
                @method('patch')
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">رمز عبور فعلی</label>
                    <div class="uk-form-controls">
                        <input name="current_password" class="uk-input uk-border-rounded" id="form-horizontal-text"
                               type="password"
                               placeholder="رمز عبور فعلی">
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">رمز عبور جدید</label>
                    <div class="uk-form-controls">
                        <input name="password" class="uk-input uk-border-rounded" id="form-horizontal-text" type="password"
                               placeholder="رمز عبور جدید">
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">تکرار رمز عبور</label>
                    <div class="uk-form-controls">
                        <input name="password_confirmation" class="uk-input uk-border-rounded" id="form-horizontal-text"
                               type="password"
                               placeholder="تکرار رمز عبور">
                    </div>
                </div>
                <div class="uk-text-center">
                    <button class="uk-button uk-button-success uk-border-rounded uk-text-white">تغییر رمز عبور</button>
                </div>
            </form>
        </div>
    </div>
@endsection