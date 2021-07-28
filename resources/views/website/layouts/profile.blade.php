@extends('website.layouts.app')

@section('content')
    <div class="uk-section-xsmall uk-section-muted profile-section">
        <div class="uk-container">
            <div class="uk-grid">
                <div class="uk-width-1-4">
                    <div data-uk-sticky="top:120px;offset: 120;animation: uk-animation-fade;bottom:.profile-section" style="z-index: 8">
                        <div
                                class="uk-background-default uk-padding-small uk-border-rounded uk-box-shadow-medium">
                            <div class="uk-flex uk-flex-middle">
                                <div class="uk-margin-right uk-background-muted uk-padding-small uk-border-circle"
                                     data-uk-icon="user"></div>
                                <div>
                                    <p class="uk-margin-remove">{{auth()->user()->name}}</p>
                                    <p class="uk-margin-remove uk-text-meta">{{auth()->user()->email}}</p>
                                </div>
                            </div>
                            <hr/>
                            <ul class="uk-list uk-list-large">
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
                                    <a class="uk-link-reset uk-flex uk-flex-middle profile-nav-item">
                                        <span data-uk-icon="comment"></span>
                                        <span class="uk-margin-small-left uk-text-small">نظرات</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="uk-link-reset uk-flex uk-flex-middle profile-nav-item">
                                        <span data-uk-icon="location"></span>
                                        <span class="uk-margin-small-left uk-text-small">نشانی‌ها</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="uk-link-reset uk-flex uk-flex-middle profile-nav-item">
                                        <span data-uk-icon="bolt"></span>
                                        <span class="uk-margin-small-left uk-text-small">وسایل نقلیه من</span>
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
                                    <a class="uk-link-reset uk-flex uk-flex-middle profile-nav-item">
                                        <span data-uk-icon="sign-out"></span>
                                        <span class="uk-margin-small-left uk-text-small">خروج</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="uk-width-expand">
                    @yield('profile-content')
                </div>
            </div>
        </div>
    </div>
@endsection