<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="title" content="{{config('app.name')}} | @yield('meta_title', 'زیگما')">
    <meta name="description" content="@yield('meta_description')">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{auth()->check() ? auth()->user() : '{}'}}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title', 'زیگما')</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <script defer src="{{ mix('js/app.js') }}"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1FDWMWX2ZC"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-1FDWMWX2ZC');
    </script>

    @laravelPWA

    <style>
        .uk-modal-page {
            overflow: unset !important;
        }

        @media print {
            header {
                display: none;
            }

            footer {
                display: none;
            }

            .hidden-in-print {
                display: none;
            }

            .avoid-pb {
                page-break-inside: avoid;
            }

            .uk-box-shadow-small {
                border: 1px solid gainsboro;
            }


        }

        .animating-line {
            width: 1px;
            height: 100vh;
            background: white;
            position: absolute;
            top: 0;
            transition: all 1s ease;
        }

        .slider-box.left > .leading {
            right: calc(100% + 1px);
        }

        .slider-box.left > .trailing {
            left: calc(100% + 1px);
        }

        .slider-box.right > .trailing {
            left: -1px;
        }

        .slider-box.right > .leading {
            right: -1px;
        }

        .fade .content {
            animation: fade 3s;
        }

        .fade::after {
            animation: fade 3s;
        }

        @keyframes fade {
            0% {
                opacity: 1;
            }
            5% {
                opacity: 0;
            }
            70% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        .slider-box {
            transition: all 1s ease;
        }

        .slider-box.right {
            right: 3.8rem;
        }

        .slider-box.left {
            right: 100%;
            transform: translateX(calc(100% + 3.8rem));
        }

        .services-container {
            background: url("/uploads/services-bg.png");
            background-size: cover;
            background-position: center;
        }

        .sticky-nav {
            visibility: hidden;
            position: absolute;
        }

        .sticky-nav.uk-active {
            visibility: visible;
            position: fixed;
        }

        .uk-breadcrumb > :nth-child(n+2):not(.uk-first-column)::before {
            margin: 0 3px;
        }

        .uk-background-gray {
            background: gray;
        }

        .uk-notification {
            direction: rtl;
        }

    </style>
</head>
<body>
<div class="site" id="app">
    @include('website.partials._header')
    <main class="site-content">
        @yield('content')
    </main>
    @include('website.partials._footer')
    <loading></loading>
    <toast class="hidden-in-print"
           dir="rtl"
           message="@if($errors->any()){{json_encode(['message' => $errors->first(), 'type' => 'danger'])}}@else{{session('flash_message')}}@endif">
    </toast>
</div>
</body>
</html>
