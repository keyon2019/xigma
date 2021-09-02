<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{config('app.name')}}</title>
    <link rel="icon" href="/uploads/favicon.png">
    <script src="{{ mix('js/app.js') }}" defer></script>

    <meta name="csrf-token" content="{{csrf_token()}}">

    <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="uk-background-muted-darker uk-height-viewport uk-flex uk-flex-middle">
    <div class="uk-background-default uk-padding uk-width-1-1">
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
</div>
</body>
{{--<body style="background: url('/uploads/login-bg.jpeg') center no-repeat;background-size:cover;"--}}
{{--class="login uk-cover-container uk-background-secondary uk-flex uk-flex-center uk-flex-middle uk-height-viewport uk-overflow-hidden uk-light"--}}
{{--data-uk-height-viewport>--}}
{{--<div class="uk-position-cover uk-overlay-primary"></div>--}}
{{--<div class="uk-position-bottom-center uk-position-small uk-visible@m uk-position-z-index">--}}
{{--<span class="uk-text-small uk-text-muted">© {{\Carbon\Carbon::now()->year}} {{config('app.name')}} - All rights reserved</span>--}}
{{--</div>--}}
{{--<div id="app" class="uk-width-medium uk-padding-small uk-position-z-index" uk-scrollspy="cls: uk-animation-fade">--}}

{{--<div class="uk-text-center">--}}
{{--<img src="/uploads/xigma_logo_inverse.png" alt="Logo">--}}
{{--</div>--}}
{{--<form method="post" class="toggle-class" action="{{route('login')}}">--}}
{{--@csrf--}}
{{--<fieldset class="uk-fieldset">--}}
{{--<div class="uk-margin-small">--}}
{{--<div class="uk-inline uk-width-1-1">--}}
{{--<span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: mail"></span>--}}
{{--<input class="uk-input uk-border-pill" name="email" required placeholder="ایمیل" type="text">--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="uk-margin-small">--}}
{{--<div class="uk-inline uk-width-1-1">--}}
{{--<span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: lock"></span>--}}
{{--<input class="uk-input uk-border-pill" name="password" required placeholder="رمز عبور" type="password">--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="uk-margin-small">--}}
{{--<label><input class="uk-checkbox" name="remember" type="checkbox"> به خاطر سپاری</label>--}}
{{--</div>--}}
{{--<div class="uk-margin-bottom">--}}
{{--<button type="submit" class="uk-button uk-button-primary uk-border-pill uk-width-1-1">ورود</button>--}}
{{--</div>--}}
{{--</fieldset>--}}
{{--</form>--}}
{{--<!-- /login -->--}}
{{--</div>--}}

{{--</body>--}}
</html>