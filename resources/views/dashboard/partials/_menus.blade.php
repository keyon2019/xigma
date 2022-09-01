<div class="left-logo uk-flex uk-flex-middle uk-flex-center">
    <span class="uk-text-large uk-text-light">{{config('app.name')}}</span>
</div>
<div class="left-content-box content-box-dark">
    <div class="uk-text-center uk-margin-small-bottom uk-margin-top">
        <a href="{{config('app.url')}}">
            <img src="/uploads/favicon.png" alt="logo">
        </a>
    </div>
    <h4 class="uk-text-center uk-margin-remove-top text-light">{{auth()->user()->name}}</h4>
</div>

<div class="left-nav-wrap">
    <ul class="uk-nav uk-nav-default uk-nav-parent-icon" data-uk-nav>
        <li class="uk-nav-header">تنظیمات</li>
        @if(auth()->user()->is_admin
        || auth()->user()->hasRole(\App\Enum\Role::SUPPORT)
        || auth()->user()->hasRole(\App\Enum\Role::STOCK))
            <li class="uk-parent"><a href="#"><span data-uk-icon="icon: tag"
                                                    class="uk-margin-small-right"></span>سفارش‌</a>
                <ul class="uk-nav-sub uk-text-light">
                    <li><a href="/dashboard/order" title="همه سفارشات">سفارش‌ها</a></li>
                    @if(!auth()->user()->hasRole(\App\Enum\Role::STOCK))
                        <li><a href="/dashboard/invoice" title="همه پیش‌فاکتورها">پیش‌فاکتورها</a></li>
                    @endif
                    <li><a href="/dashboard/return_request" title="همه درخواست‌های مرجوعی">مرجوعی</a></li>
                </ul>
            </li>
        @endif
        @if(auth()->user()->is_admin)
            <li class="uk-parent"><a href="#"><span data-uk-icon="icon: image"
                                                    class="uk-margin-small-right"></span>تنظیمات ظاهری</a>
                <ul class="uk-nav-sub uk-text-light">
                    <li><a href="/dashboard/widget/all" title="محصولات صفحه اصلی">ویجت‌ها</a></li>
                    <li><a href="/dashboard/widget/create" title="">ویجت جدید</a></li>
                    <li><a href="/dashboard/page" title="صفحات">صفحات</a></li>
                    <li><a href="/dashboard/page/create">صفحه جدید</a></li>
                    <li><a href="/dashboard/slider" title="اسلایدر اصلی">اسلایدر اصلی</a></li>
                    <li><a href="/dashboard/slider/create">اسلایدر جدید</a></li>
                </ul>
            </li>
        @endif
        @if(auth()->user()->is_admin || auth()->user()->hasRole(\App\Enum\Role::OPERATOR))
            <li class="uk-parent"><a href="#"><span data-uk-icon="icon: thumbnails"
                                                    class="uk-margin-small-right"></span>محصولات</a>
                <ul class="uk-nav-sub uk-text-light">
                    <li><a href="/dashboard/product" title="همه محصولات">نمایش محصولات</a></li>
                    <li><a href="/dashboard/product/create" title="همه محصولات">محصول جدید</a></li>
                    @if(auth()->user()->is_admin)
                        <li><a href="/dashboard/variation" title="انبار و موجودی">موجودی</a></li>
                    @endif
                    <li><a href="/dashboard/stock_transaction" title="تراکنش انبار">تراکنش انبار</a></li>
                    <li><a href="/dashboard/discount" title="تخفیفات">تخفیفات</a></li>
                </ul>
            </li>

            <li class="uk-parent"><a href="#"><span data-uk-icon="icon: social" class="uk-margin-small-right"></span>دسته‌بندی‌ها</a>
                <ul class="uk-nav-sub uk-text-light">
                    <li><a href="/dashboard/category" title="دسته‌بندی‌ها">نمایش دسته بندی‌ها</a></li>
                    <li><a href="/dashboard/category/create" title="دسته‌بندی‌ها">دسته‌بندی‌ جدید</a></li>
                </ul>
            </li>
            <li class="uk-parent"><a href="#"><span data-uk-icon="icon: settings" class="uk-margin-small-right"></span>فیلترها</a>
                <ul class="uk-nav-sub uk-text-light">
                    <li><a href="/dashboard/option" title="فیلترها">نمایش فیلترها</a></li>
                    <li><a href="/dashboard/option/create" title="دسته‌بندی‌ها">فیلتر جدید</a></li>
                </ul>
            </li>
            <li class="uk-parent"><a href="#"><span data-uk-icon="icon: bolt" class="uk-margin-small-right"></span>وسایل نقلیه</a>
                <ul class="uk-nav-sub uk-text-light">
                    <li><a href="/dashboard/vehicle" title="وسایل نقلیه">نمایش وسایل نقلیه</a></li>
                    <li><a href="/dashboard/vehicle/create" title="وسیله نقلیه جدید">وسیله نقلیه جدید</a></li>
                </ul>
            </li>
        @endif
        @if(auth()->user()->is_admin)
            <li class="uk-parent"><a href="#"><span data-uk-icon="icon: location" class="uk-margin-small-right"></span>نمایندگی‌ها</a>
                <ul class="uk-nav-sub uk-text-light">
                    <li><a href="/dashboard/retailer" title="نمایندگی‌ها">نمایش نمایندگی‌ها</a></li>
                    <li><a href="/dashboard/retailer/create" title="نمایندگی جدید">نمایندگی جدید</a></li>
                    <li><a href="/dashboard/retailer/item" title="ارسال محصول">ارسال محصول</a></li>
                </ul>
            </li>
        @endif
        @if(auth()->user()->is_admin || auth()->user()->hasRole(\App\Enum\Role::SUPPORT))
            <li class="uk-parent"><a href="#"><span data-uk-icon="icon: users"
                                                    class="uk-margin-small-right"></span>کاربران</a>
                <ul class="uk-nav-sub uk-text-light">
                    <li><a href="/dashboard/user" title="کاربران">لیست کاربران</a></li>
                    <li><a href="/dashboard/user/create" title="کاربر جدید">کاربر جدید</a></li>
                </ul>
            </li>
            <li><a href="/dashboard/comment">
                    <span data-uk-icon="icon: comment" class="uk-margin-small-right"></span>نظرات</a>
            </li>
            <li><a href="/dashboard/contact">
                    <span data-uk-icon="icon: comment" class="uk-margin-small-right"></span>ارتباط با ما</a>
            </li>
        @endif
        @if(auth()->user()->is_admin)
            <li><a href="/dashboard/thread">
                    <span data-uk-icon="icon: mail" class="uk-margin-small-right"></span>پیغام‌ها</a>
            </li>
            <li class="uk-parent"><a href="#"><span data-uk-icon="icon: info" class="uk-margin-small-right"></span>گزارش</a>
                <ul class="uk-nav-sub uk-text-light">
                    <li><a href="/dashboard/report/order" title="گزارش سفارش‌ها">سفارشات</a></li>
                    <li><a href="/dashboard/report/point" title="گزارش امتیاز">امتیازات</a></li>
                    <li><a href="/dashboard/report/product" title="گزارش محصولات">پرفروش‌ترین محصولات</a></li>
                    <li><a href="/dashboard/report/category" title="گزارش دسته‌بندی‌ها">پرفروش‌ترین دسته‌بندی‌ها</a></li>
                    <li><a href="/dashboard/report/return_request" title="گزارش مرجوعی‌ها">مرجوعی‌ها</a></li>
                    <li><a href="/dashboard/report/shipping" title="گزارش ارسال‌ها">هزینه ارسال</a></li>
                    <li><a href="/dashboard/report/shipping_average" title="گزارش متوسط زمان ارسال">متوسط زمان ارسال</a></li>
                    <li><a href="/dashboard/report/reminder" title="درخواست موجودی">درخواست موجودی</a></li>
                    <li><a href="/dashboard/report/product_exit_average" title="نرخ خروج">نرخ خروج</a></li>
                </ul>
            </li>
        @endif
    </ul>

</div>