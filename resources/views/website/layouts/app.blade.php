<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{auth()->check() ? auth()->user() : '{}'}}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <style>
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
            right: 40px;
        }

        .slider-box.left {
            right: 100%;
            transform: translateX(calc(100% + 40px));
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
</div>
<script src="{{ mix('js/app.js') }}"></script>
<script>
    const app = new Vue({
        el: '#app',
    });
</script>

</body>
</html>
