<aside id="left-col" class="uk-light uk-visible@m">
    @include('dashboard.partials._menus')
    <div class="bar-bottom">
        <ul class="uk-subnav uk-flex uk-flex-center uk-child-width-1-5" data-uk-grid>
            <li>
                <a href="#" class="uk-icon-link" data-uk-icon="icon: home" title="Home" data-uk-tooltip></a>
            </li>
            <li>
                <a href="#" class="uk-icon-link" data-uk-icon="icon: settings" title="Settings" data-uk-tooltip></a>
            </li>
            <li>
                <a href="#" class="uk-icon-link" data-uk-icon="icon: social" title="Social" data-uk-tooltip></a>
            </li>
            <li>
                <a href="#" class="uk-icon-link" data-uk-tooltip="Sign out" data-uk-icon="icon: sign-out"></a>
            </li>
        </ul>
    </div>
</aside>

<div id="offcanvas-overlay" uk-offcanvas="overlay: true">
    <div class="uk-offcanvas-bar">
        <div>
            @include('dashboard.partials._menus')
        </div>
    </div>
</div>