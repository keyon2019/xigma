@extends('website.layouts.app')
@section('content')
    <div class="uk-background-default uk-section uk-padding uk-width-1-1">
        <div class="uk-container">
            <div class="uk-text-center">
                <img src="/uploads/xigma_typography.png">
            </div>
            <hr class="uk-margin-small"/>
            <div class="uk-grid uk-child-width-1-2@m">
                <div>
                    <form method="post" class="toggle-class" action="{{route('login')}}">
                        @csrf
                        <fieldset class="uk-fieldset">
                            <div class="uk-margin-small">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: mail"></span>
                                    <input class="uk-input uk-form-large uk-border-rounded" name="email" required
                                           placeholder="ایمیل"
                                           type="text">
                                </div>
                            </div>
                            <div class="uk-margin-small uk-text-right">
                                <label><input class="uk-checkbox" name="remember" type="checkbox"> به خاطر سپاری</label>
                            </div>
                            <div class="uk-margin-top">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: lock"></span>
                                    <input class="uk-input uk-form-large uk-border-rounded" name="password" required
                                           placeholder="رمز عبور"
                                           type="password">
                                </div>
                            </div>
                            <a class="uk-margin uk-margin-bottom uk-button uk-button-text">کلمه عبور خود را فراموش کردم</a>
                            <div class="uk-margin-bottom uk-text-center">
                                <button type="submit"
                                        class="uk-button uk-button-large uk-button-primary uk-border-rounded uk-width-1-2@m uk-text-bolder"
                                        style="border: 1px solid black">ورود به پروفایل کاربری
                                </button>
                            </div>
                        </fieldset>
                    </form>
                    <div class="uk-grid uk-grid-large uk-child-width-1-2@m uk-margin-top uk-margin-bottom" data-uk-grid>
                        <div>
                            <img src="/uploads/google-login.png" class="uk-width-expand@m">
                        </div>
                        <div>
                            <img src="/uploads/mobile-login.png" class="uk-width-expand@m">
                        </div>
                    </div>
                </div>
                <div>
                    <img src="/uploads/group.png">
                </div>
            </div>
            <hr class="uk-margin-small"/>
            <div class="uk-grid uk-flex uk-flex-center uk-grid-divider uk-margin-top">
                <div class="uk-first-column">
                    <a href="#" class="uk-button uk-button-text">ثبت نام در سایت</a>
                </div>
                <div>
                    <a href="#" class="uk-button uk-button-text">قوانین و مقررات</a>
                </div>
            </div>
        </div>
    </div>
@endsection