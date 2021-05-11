<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Xigma Dashboard</title>

    <script src="{{ mix('js/app.js') }}" defer></script>

    <meta name="csrf-token" content="{{csrf_token()}}">

    <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">
</head>
<body>

<div id="app">
    <header id="top-head" class="uk-position-fixed uk-box-shadow-medium">
        <div class="uk-container uk-container-expand uk-background-secondary">
            <nav class="uk-navbar uk-light" data-uk-navbar="mode:click; duration: 250">
                <div class="uk-navbar-right">
                    <ul class="uk-navbar-nav">
                        <li><a href="#" data-uk-icon="icon: settings" title="تنظیمات" data-uk-tooltip></a></li>
                        <li><a href="#" data-uk-icon="icon: sign-out" title="خروچ" data-uk-tooltip></a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    @include('dashboard.partials._sideMenu')

    <div id="content" data-uk-height-viewport="expand: true" class="uk-position-relative">
        <div class="uk-container uk-container-expand">
            <h2 class="uk-margin-remove-bottom uk-text-bolder">@yield('title','عنوان صفحه')</h2>
            <hr class="uk-margin-small-top uk-margin-small-bottom"/>
            @yield('content')
        </div>
    </div>
    <loading-modal></loading-modal>
    <toast message="{{session('flash_message')}}"></toast>
</div>

</body>
</html>
<script>

</script>