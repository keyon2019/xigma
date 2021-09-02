<div data-uk-sticky="top: .nav;animation: uk-animation-slide-top" class="sticky-nav uk-box-shadow-small">
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
                    <span class="uk-margin-left uk-margin-right">
                            <button class="uk-button uk-button-primary uk-text-secondary uk-border-rounded">جستجوی پیشرفته
                                    محصولات
                                </button>
                        </span>
                    <span class="uk-width-expand uk-inline">
                        <span class="uk-form-icon" data-uk-icon="search"></span>
                        <input class="uk-input uk-background-muted uk-border-rounded">
                    </span>
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
            <div class="uk-grid uk-flex uk-flex-middle">
                <div class="uk-width-3-4@m">
                    <div>
                        @foreach($categories as $category)
                            <a href="/category/{{$category->id}}" class="uk-margin-right uk-link-reset uk-text-small">
                                <span>{{$category->name}}</span>
                                <span data-uk-icon="chevron-down"></span>
                            </a>
                        @endforeach
                        <a class="uk-margin-right uk-link-reset uk-text-small">
                            <span>امور نمایندگان</span>
                            <span data-uk-icon="chevron-down"></span>
                        </a>
                        <a class="uk-margin-right uk-link-reset uk-text-small">
                            <span>ارتباط با ما</span>
                            <span data-uk-icon="chevron-down"></span>
                        </a>
                    </div>
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

<header class="@if($isHome ?? false) uk-position-absolute uk-position-top-center @endif"
        style="z-index: 10">
    <div class="@if($isHome ?? false) uk-background-muted @endif">
        @if(!($isHome ?? false))
            <div style="height: 11.5em;position: absolute;z-index: 8;background: url('/uploads/bg-pattern.png');margin-top:4.5em;width:100%;"></div>
        @endif
        <div class="nav uk-position-relative" style="z-index: 10">
            <div class="uk-container uk-padding-small uk-padding-remove-vertical uk-background-default">
                <div class="uk-grid uk-grid-collapse">
                    <div class="uk-width-3-4@m uk-flex uk-flex-column">
                        <div class="uk-flex uk-flex-middle uk-flex-row" style="flex: 0.6 1 0px">
                        <span class="uk-flex uk-background-muted-darker uk-height-1-1 uk-padding-small uk-padding-remove-vertical clickable"
                              onclick="window.location.replace('/cart')"
                              data-uk-icon="icon:cart;ratio:1.5"></span>
                            <div class="uk-margin-left uk-text-muted uk-text-small">
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
                            <div class="uk-grid uk-grid-small uk-padding-small uk-padding-remove-vertical">
                                <div>
                                    <button class="uk-button uk-button-primary uk-text-secondary uk-border-rounded">جستجوی پیشرفته
                                        محصولات
                                    </button>
                                </div>
                                <div class="uk-width-expand">
                                    <input class="uk-input uk-border-rounded">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="uk-width-1-4@m">
                        <div class="uk-background-primary uk-text-center">
                            <a class="uk-link-reset" href="/">
                                <img uk-img width="90%" src="/uploads/xigma_logo.png"
                                     class="uk-padding uk-padding-remove-vertical">
                            </a>
                        </div>
                    </div>
                    <div class="uk-width-3-4@m uk-text-small uk-flex uk-flex-row uk-flex-middle">
                        <div class="uk-padding-small uk-padding-remove-vertical">
                            @foreach($categories as $category)
                                <a href="/category/{{$category->id}}" class="uk-margin-right uk-link-reset">
                                    <span>{{$category->name}}</span>
                                    <span data-uk-icon="chevron-down"></span>
                                </a>
                            @endforeach
                            <a class="uk-margin-right uk-link-reset">
                                <span>امور نمایندگان</span>
                                {{--<span data-uk-icon="chevron-down"></span>--}}
                            </a>
                            <a class="uk-margin-right uk-link-reset">
                                <span>ارتباط با ما</span>
                                {{--<span data-uk-icon="chevron-down"></span>--}}
                            </a>
                        </div>
                    </div>
                    <div class="uk-width-1-4@m">
                        <div class="uk-background-muted uk-padding-small uk-text-center">
                            <span class="uk-margin-right uk-text-muted"> XIGMA BOX </span>
                            <span class="uk-text-muted" data-uk-icon="icon:menu;ratio:1.5"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>