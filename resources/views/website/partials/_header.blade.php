<div data-uk-sticky="top: 500;animation: uk-animation-slide-top" class="sticky-nav uk-box-shadow-small uk-visible@m">
    <div class="uk-background-default">
        <div class="uk-container">
            <div class="uk-grid uk-grid-small uk-flex uk-flex-stretch">
                <div class="uk-width-3-4@m uk-flex uk-flex-middle">
                    <span style="margin-left: 1px"
                          class="uk-flex uk-background-muted-darker uk-height-1-1 uk-padding-small uk-padding-remove-vertical clickable"
                          onclick="window.location.replace('/cart')"
                          data-uk-icon="icon:cart;ratio:1.5"></span>
                    <span class="uk-flex uk-background-muted-darker uk-height-1-1 uk-padding-small uk-padding-remove-vertical clickable"
                          onclick="window.location.replace('/profile')"
                          data-uk-icon="icon:user;ratio:1.5"></span>
                    <search class="uk-margin-left uk-width-expand"></search>
                </div>
                <div class="uk-width-1-4">
                    <div class="uk-background-primary">
                        <img class="uk-width-expand uk-padding uk-padding-remove-vertical"
                             src="/uploads/xigma-typography.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-background-muted">
        <div class="uk-container">
            <div class="arman-sticky-nav">
                <div class="uk-grid uk-flex uk-flex-middle">
                    <div class="uk-width-3-4@m">
                        <ul class="uk-navbar-nav">
                            @foreach($categories as $category)
                                <li>
                                    <a class="uk-text-secondary">{{$category->name}} <span uk-icon="chevron-down"></span></a>
                                    <div style="border-top: 1px solid #ecebeb;"
                                         uk-drop="pos:bottom-justify;boundary: .arman-sticky-nav;boundary-align: true;offset:0;animation: uk-animation-slide-top-small; duration: 300"
                                         class="uk-background-default uk-box-shadow-medium uk-padding">
                                        <div class="uk-grid uk-child-width-expand">
                                            @foreach($category->subCategories as $sCategory)
                                                <div>
                                                    <p class="uk-text-bold">{{strtoupper($sCategory->name)}}</p>
                                                    <ul class="uk-list uk-list-primary uk-list-disc uk-text-small">
                                                        @foreach($sCategory->subCategories as $ssCategory)
                                                            <li><a class="uk-button uk-button-text"
                                                                   href="/category/{{$ssCategory->id}}">{{$ssCategory->name}}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            @foreach($pages as $page)
                                <li><a href="/{{$page->slug}}" class="uk-text-secondary">{{$page->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="uk-width-1-4">
                        <div class="uk-background-muted uk-padding-small uk-text-center">
                            <span class="uk-margin-right uk-text-muted"> XIGMA BOX </span>
                            <span class="uk-text-muted" data-uk-icon="icon:menu;ratio:1.5"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<header class="@if($isHome ?? false) home-nav uk-position-absolute uk-position-top-center @endif">
    <div class="uk-hidden@m uk-background-primary">
        <div class="uk-container">
            <div class="uk-grid uk-grid-collapse uk-flex uk-flex-middle">
                <div class="uk-width-expand">
                    <a class="uk-link-reset" uk-toggle="target: #offcanvas-overlay">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                </div>
                <div>
                    <a href="/">
                        <img class="" uk-img width="60" src="/uploads/xigma-typography.png" alt="xigma_typography">
                        <img class="uk-padding-small uk-padding-remove-horizontal" uk-img width="40"
                             src="/uploads/xigma_favicon.png" alt="xigma_logo">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="@if($isHome ?? false) uk-background-muted @endif">
        @if(!($isHome ?? false))
            <div class="nav-pattern"></div>
        @endif
        <div class="nav uk-position-relative" style="z-index: 10">
            <div class="uk-container uk-padding-small uk-padding-remove-vertical uk-background-default padding-remove@m nav-bound">
                <div class="uk-grid uk-grid-collapse">
                    <div class="uk-width-3-4@m uk-flex uk-flex-column">
                        <div class="uk-flex uk-flex-middle uk-flex-row" style="flex: 0.6 1 0px">
                        <span class="uk-flex uk-background-muted-darker uk-height-1-1 uk-padding-small uk-padding-remove-vertical clickable"
                              onclick="window.location.replace('/cart')"
                              data-uk-icon="icon:cart;ratio:1.5"></span>
                            <div class="uk-margin-left uk-text-muted uk-text-small header-cart-container">
                                <cart></cart>
                            </div>
                            <span class="uk-flex uk-margin-left uk-background-muted-darker uk-height-1-1 uk-padding-small uk-padding-remove-vertical clickable"
                                  onclick="window.location.replace('/profile')"
                                  data-uk-icon="icon:user;ratio:1.5"></span>
                            <div class="uk-text-small uk-text-muted uk-margin-left">
                                <a class="uk-link-reset" href="{{auth()->check() ? '/profile' : '/login'}}">
                                    {{auth()->check() ? auth()->user()->name : 'ورود به حساب کاربری'}}</a>
                            </div>
                        </div>
                        <div class="uk-background-muted uk-flex uk-flex-column uk-flex-center" style="flex: 1 1 0px">
                            <div class="uk-grid uk-grid-small uk-padding-small uk-padding-remove-vertical mobile-search-container">
                                <div class="uk-visible@m">
                                    <button class="uk-button uk-button-primary uk-text-secondary uk-border-rounded">جستجوی پیشرفته
                                        محصولات
                                    </button>
                                </div>
                                <search class="padding-small@m uk-width-expand"></search>
                                {{--<div class="uk-width-expand padding-small@m">--}}
                                    {{--<div class="uk-inline uk-width-expand">--}}
                                        {{--<span class="uk-form-icon" data-uk-icon="search"></span>--}}
                                        {{--<input class="uk-input uk-border-rounded uk-text-muted">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            </div>
                        </div>

                    </div>
                    <div class="uk-width-1-4@m uk-visible@m">
                        <div class="uk-background-primary uk-text-center">
                            <a class="uk-link-reset" href="/">
                                <img uk-img width="90%" src="/uploads/xigma_logo.png"
                                     class="uk-padding uk-padding-remove-vertical">
                            </a>
                        </div>
                    </div>
                    <div class="uk-width-3-4@m uk-text-small uk-flex uk-flex-row uk-flex-middle uk-visible@m">
                        <div class="uk-padding-small uk-padding-remove-vertical">
                            <ul class="uk-navbar-nav">
                                @foreach($categories as $category)
                                    <li>
                                        <a class="uk-text-secondary">{{$category->name}} <span uk-icon="chevron-down"></span></a>
                                        <div style="border-top: 1px solid #ecebeb;"
                                             uk-drop="pos:bottom-justify;boundary: .nav-bound;boundary-align: true;offset:0;animation: uk-animation-slide-top-small; duration: 300"
                                             class="uk-background-default uk-box-shadow-medium uk-padding">
                                            <div class="uk-grid uk-child-width-expand">
                                                @foreach($category->subCategories as $sCategory)
                                                    <div>
                                                        <p class="uk-text-bold">{{strtoupper($sCategory->name)}}</p>
                                                        <ul class="uk-list uk-list-primary uk-list-disc uk-text-small">
                                                            @foreach($sCategory->subCategories as $ssCategory)
                                                                <li><a class="uk-button uk-button-text"
                                                                       href="/category/{{$ssCategory->id}}">{{$ssCategory->name}}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                @foreach($pages as $page)
                                    <li><a href="/{{$page->slug}}" class="uk-text-secondary">{{$page->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="uk-width-1-4@m">
                        <div class="uk-background-muted uk-padding-small uk-text-center uk-visible@m">
                            <span class="uk-margin-right uk-text-muted"> XIGMA BOX </span>
                            <span class="uk-text-muted" data-uk-icon="icon:menu;ratio:1.5"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div id="offcanvas-overlay" uk-offcanvas="overlay: true">
    <div class="uk-offcanvas-bar">
        {{--<button class="uk-offcanvas-close" type="button" uk-close></button>--}}
        <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
            <li><img uk-img width="100" style="filter: invert(100%)" src="/uploads/xigma-typography.png"></li>
            <li class="uk-nav-divider uk-margin-small-top"></li>
            @foreach($categories as $category)
                <li class="uk-parent">
                    <a>{{$category->name}}</a>
                    <ul class="uk-nav-sub">
                        @foreach($category->subCategories as $sCategory)
                            <li class="uk-parent">
                                <a>{{$sCategory->name}}</a>
                                <ul class="uk-list-hyphen">
                                    @foreach($sCategory->subCategories as $ssCategory)
                                        <li>
                                            <a href="/category/{{$ssCategory->id}}">{{$ssCategory->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
            @foreach($pages as $page)
                <li><a href="/{{$page->slug}}">{{$page->name}}</a></li>
            @endforeach
        </ul>
    </div>
</div>