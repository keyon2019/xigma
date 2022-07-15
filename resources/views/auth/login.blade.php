@extends('website.layouts.app')
@section('content')
    <div class="uk-background-default uk-section uk-padding uk-width-1-1">
        <div class="uk-container">
            <div class="uk-text-center">
                <img uk-img width="200" src="/uploads/xigma_logo.png">
                <h3 class="uk-margin-small">ورود به زیــــگما</h3>
            </div>
            <div class="uk-width-large uk-margin-auto">
                <div>
                    <form method="post" class="toggle-class" action="/login">
                        @csrf
                        <fieldset class="uk-fieldset">
                            <div class="uk-margin-small">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: phone"></span>
                                    <input class="uk-input uk-border-rounded" name="email" required
                                           placeholder="تلفن همراه"
                                           type="text">
                                </div>
                            </div>
                            <div class="uk-margin-top">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: lock"></span>
                                    <input class="uk-input uk-border-rounded" name="password" required
                                           placeholder="رمز عبور"
                                           type="password">
                                </div>
                            </div>
                            <div class="uk-grid uk-margin-top uk-margin-bottom uk-text-muted">
                                <div class="uk-margin-small uk-width-expand uk-text-small">
                                    <label><input class="uk-checkbox" name="remember" type="checkbox"> مرا به خاطر بسپار</label>
                                </div>
                                <div>
                                    <a class="uk-margin uk-margin-bottom uk-button uk-button-text uk-text-muted">فراموشی کلمه عبور</a>
                                </div>
                            </div>
                            <div class="uk-margin-bottom uk-text-center">
                                <button type="submit"
                                        class="uk-button uk-button-primary uk-border-rounded uk-width-expand uk-text-bolder">ورود
                                </button>
                            </div>
                            <div class="uk-margin-bottom uk-text-center">
                                <a href="/register"
                                   class="uk-button uk-background-muted uk-button-default uk-border-rounded uk-width-expand uk-text-bolder">ثبت
                                    نام
                                </a>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection