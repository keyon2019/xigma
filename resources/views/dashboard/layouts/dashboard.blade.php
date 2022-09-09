<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Xigma Dashboard</title>

    <meta name="user" content="{{auth()->check() ? auth()->user() : '{}'}}">

    <meta name="csrf-token" content="{{csrf_token()}}">

    <meta name="notifications" content="{{$notifications}}">

    <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">

    <style>
        @media print {
            #content {
                margin-top: 0 !important;
            }

            table tfoot {
                display: table-row-group;
            }
        }

        .red-dot {
            position: relative;
        }

        .red-dot::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 4px;
            background: #c70e0e;
            position: absolute;
            top: 0;
            left: -12px;
        }

        .badge {
            box-sizing: border-box;
            min-width: 22px;
            height: 22px;
            padding: 0 5px;
            border-radius: 500px;
            vertical-align: middle;
            background: #c70e0e;
            color: #fff;
            font-size: 0.875rem;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
<div class="uk-position-cover uk-background-muted loading-cover">
    <div class="lds-ellipsis uk-position-center">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<div id="app" v-cloak>
    <header id="top-head" class="uk-position-fixed uk-box-shadow-medium hidden-in-print">
        <div class="uk-container uk-container-expand uk-background-secondary">
            <nav class="uk-navbar uk-light" data-uk-navbar="mode:click; duration: 250">
                <div class="uk-navbar-left uk-hidden@m">
                    <ul class="uk-navbar-nav">
                        <li><a uk-toggle="target: #offcanvas-overlay" href="#" data-uk-icon="icon: menu"></a></li>
                    </ul>
                </div>
                <div class="uk-navbar-right">
                    <ul class="uk-navbar-nav">
                        <notification-bell :initial-notifications="{{$notifications}}"></notification-bell>
                        <li><a href="#" data-uk-icon="icon: settings" title="تنظیمات" data-uk-tooltip></a></li>
                        <li><a href="/logout" data-uk-icon="icon: sign-out" title="خروچ" data-uk-tooltip></a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    @include('dashboard.partials._sideMenu')

    <div id="content" data-uk-height-viewport="expand: true" class="uk-position-relative">
        <div class="uk-container uk-container-expand uk-padding uk-padding-remove-top">
            <h2 class="uk-margin-remove-bottom uk-text-bolder">@yield('title','عنوان صفحه')</h2>
            <hr class="uk-margin-small-top uk-margin-small-bottom"/>
            @yield('content')
        </div>
    </div>
    <loading></loading>
    <toast class="hidden-in-print"
           message="@if($errors->any()){{json_encode(['message' => $errors->first(), 'type' => 'danger'])}}@else{{session('flash_message')}}@endif">
    </toast>
</div>

</body>
</html>
<script src="{{ mix('js/dashboard.js') }}"></script>
