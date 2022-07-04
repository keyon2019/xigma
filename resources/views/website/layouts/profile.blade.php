@extends('website.layouts.app')

@section('title', 'حساب کاربری')

@section('content')
    <div class="uk-section-muted profile-section">
        <div class="uk-container">
            <div class="uk-grid uk-grid-small">
                <div class="uk-width-1-4@m hidden-in-print" style="">
                    <div class="uk-padding-small uk-padding-remove-top" style="z-index: 8;background: url('/uploads/bg-pattern.png');">
                        <img src="/uploads/xigma-badge.png" class="uk-margin-small-bottom uk-width-expand" alt="xigma_badge">
                        <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-medium uk-margin-small-bottom">
                            <div class="uk-grid uk-grid-small uk-grid-divider uk-flex uk-flex-middle">
                                <div>
                                    <div class="uk-first-column uk-background-muted uk-padding-small uk-border-circle"
                                         data-uk-icon="user"></div>
                                </div>
                                <div>
                                    <p class="uk-margin-remove"><span data-uk-icon="phone"
                                                                      class="uk-margin-small-right"></span>{{auth()->user()->name}}
                                    </p>
                                    <p class="uk-margin-remove uk-text-meta"><span data-uk-icon="mail"
                                                                                   class="uk-margin-small-right"></span>{{auth()->user()->email}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-medium">
                            <ul class="uk-list uk-list-large">
                                <li>
                                    <a href="/profile/edit" class="uk-link-reset uk-flex uk-flex-middle profile-nav-item">
                                        <span data-uk-icon="user"></span>
                                        <span class="uk-margin-small-left uk-text-small">اطلاعات کاربری</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/order" class="uk-link-reset uk-flex uk-flex-middle profile-nav-item">
                                        <span data-uk-icon="tag"></span>
                                        <span class="uk-margin-small-left uk-text-small">سفارش‌های من</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/invoice" class="uk-link-reset uk-flex uk-flex-middle profile-nav-item">
                                        <span data-uk-icon="file-text"></span>
                                        <span class="uk-margin-small-left uk-text-small">پیش‌فاکتور‌ها</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/return_request" class="uk-link-reset uk-flex uk-flex-middle profile-nav-item">
                                        <span data-uk-icon="refresh"></span>
                                        <span class="uk-margin-small-left uk-text-small">مرجوعی‌ها</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/point/overview" class="uk-link-reset uk-flex uk-flex-middle profile-nav-item">
                                        <span data-uk-icon="star"></span>
                                        <span class="uk-margin-small-left uk-text-small">امتیازات</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="uk-link-reset uk-flex uk-flex-middle profile-nav-item" href="/comment">
                                        <span data-uk-icon="comment"></span>
                                        <span class="uk-margin-small-left uk-text-small">نظرات</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="uk-link-reset uk-flex uk-flex-middle profile-nav-item" href="/address">
                                        <span data-uk-icon="location"></span>
                                        <span class="uk-margin-small-left uk-text-small">نشانی‌ها</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="uk-link-reset uk-flex uk-flex-middle profile-nav-item" href="/vehicle">
                                        <span data-uk-icon="bolt"></span>
                                        <span class="uk-margin-small-left uk-text-small">وسایل نقلیه من</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="uk-link-reset uk-flex uk-flex-middle profile-nav-item">
                                        <span data-uk-icon="heart"></span>
                                        <span class="uk-margin-small-left uk-text-small">لیست علاقمندی‌ها</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="uk-link-reset uk-flex uk-flex-middle profile-nav-item">
                                        <span data-uk-icon="mail"></span>
                                        <span class="uk-margin-small-left uk-text-small">پیغام‌ها</span>
                                    </a>
                                </li>
                            </ul>
                            <hr/>
                            <ul class="uk-list uk-list-large">
                                <li>
                                    <a class="uk-link-reset uk-flex uk-flex-middle profile-nav-item" href="/logout">
                                        <span data-uk-icon="sign-out"></span>
                                        <span class="uk-margin-small-left uk-text-small">خروج</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="uk-width-expand">
                    <div class="uk-margin-top">
                        @yield('profile-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection