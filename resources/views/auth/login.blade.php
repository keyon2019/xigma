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
<body style="background: url('/uploads/login-bg.jpeg') center no-repeat;background-size:cover;"
      class="login uk-cover-container uk-background-secondary uk-flex uk-flex-center uk-flex-middle uk-height-viewport uk-overflow-hidden uk-light"
      data-uk-height-viewport>
<div class="uk-position-cover uk-overlay-primary"></div>
<div class="uk-position-bottom-center uk-position-small uk-visible@m uk-position-z-index">
    <span class="uk-text-small uk-text-muted">© {{\Carbon\Carbon::now()->year}} {{config('app.name')}} - All rights reserved</span>
</div>
<div id="app" class="uk-width-medium uk-padding-small uk-position-z-index" uk-scrollspy="cls: uk-animation-fade">

    <div class="uk-text-center">
        <img src="/uploads/xigma_logo_inverse.png" alt="Logo">
    </div>
    <form method="post" class="toggle-class" action="{{route('login')}}">
        @csrf
        <fieldset class="uk-fieldset">
            <div class="uk-margin-small">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: mail"></span>
                    <input class="uk-input uk-border-pill" name="email" required placeholder="ایمیل" type="text">
                </div>
            </div>
            <div class="uk-margin-small">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: lock"></span>
                    <input class="uk-input uk-border-pill" name="password" required placeholder="رمز عبور" type="password">
                </div>
            </div>
            <div class="uk-margin-small">
                <label><input class="uk-checkbox" name="remember" type="checkbox"> به خاطر سپاری</label>
            </div>
            <div class="uk-margin-bottom">
                <button type="submit" class="uk-button uk-button-primary uk-border-pill uk-width-1-1">ورود</button>
            </div>
        </fieldset>
    </form>
    <!-- /login -->
</div>

</body>
</html>