<footer>
    <div class="uk-section services-container uk-section-muted uk-text-center" style="text-align-last: center;">
        <div class="uk-container">
            <div class="uk-heading-small uk-text-bold">گــروه صنعتـــی زیگمـا</div>
            <div data-uk-grid class="uk-grid uk-child-width-1-4@m uk-child-width-1-2@s uk-margin-large-top">
                <div>
                    <img src="/uploads/guarantee.svg">
                    <p class="uk-text-lead">گــارانتـــی ســلامت</p>
                    <p class="uk-text-justify uk-text-light">کلیه کالاهای برند زیگما پیش از ارسال در حداقل سه مرحله جهت اطمینان از
                        سلامت کالا و صحت عملکردآن‌ها
                        مورد
                        بررسی کارشناسان کنترل کیفی ما قرار می‌گیرند و از این رو می‌توانید با اطمینان خاطر از سلامت کالا‌ها اقدام
                        به
                        خرید
                        فرمایید</p>
                </div>
                <div>
                    <img src="/uploads/fast-delivery.svg">
                    <p class="uk-text-lead">ارســال سریــع</p>
                    <p class="uk-text-justify uk-text-light">کلیه کالاهای برند زیگما پیش از ارسال در حداقل سه مرحله جهت اطمینان از
                        سلامت کالا و صحت عملکردآن‌ها
                        مورد
                        بررسی کارشناسان کنترل کیفی ما قرار می‌گیرند و از این رو می‌توانید با اطمینان خاطر از سلامت کالا‌ها اقدام
                        به
                        خرید
                        فرمایید</p>
                </div>
                <div>
                    <img src="/uploads/quality.svg">
                    <p class="uk-text-lead">کیـــفیــت بالا</p>
                    <p class="uk-text-justify uk-text-light">کلیه کالاهای برند زیگما پیش از ارسال در حداقل سه مرحله جهت اطمینان از
                        سلامت کالا و صحت عملکردآن‌ها
                        مورد
                        بررسی کارشناسان کنترل کیفی ما قرار می‌گیرند و از این رو می‌توانید با اطمینان خاطر از سلامت کالا‌ها اقدام
                        به
                        خرید
                        فرمایید</p>
                </div>
                <div>
                    <img src="/uploads/support.svg">
                    <p class="uk-text-lead">پشتیبــانی مشتــریالن</p>
                    <p class="uk-text-justify uk-text-light">کلیه کالاهای برند زیگما پیش از ارسال در حداقل سه مرحله جهت اطمینان از
                        سلامت کالا و صحت عملکردآن‌ها
                        مورد
                        بررسی کارشناسان کنترل کیفی ما قرار می‌گیرند و از این رو می‌توانید با اطمینان خاطر از سلامت کالا‌ها اقدام
                        به
                        خرید
                        فرمایید</p>
                </div>
            </div>
            <div class="uk-heading-large uk-text-bolder uk-margin-large">QUALITY IS INFINITY</div>
        </div>
    </div>
    <div class="uk-section uk-section-default uk-text-center">
        <div class="uk-container">
            <div>
                <a class="uk-link-reset uk-margin-large-right" href="#"><img src="/uploads/instagram.svg"></a>
                <a class="uk-link-reset uk-margin-large-right" href="#"><img src="/uploads/telegram.svg"></a>
                <a class="uk-link-reset" href="#"><img src="/uploads/whatsapp.svg"></a>
            </div>
            <p class="uk-text-large text-small@m">با ما در شبکه‌های اجتماعی همراه باشید.</p>
        </div>
    </div>
    <div class="uk-section uk-section-secondary uk-padding-remove-bottom">
        <div class="uk-container">
            <div class="uk-grid uk-child-width-1-4@m uk-child-width-1-2 uk-text-light">
                <div>
                    <p class="uk-text-large text-small@m uk-text-primary">ابــزارهای خریــد</p>
                    @foreach($pages->filter(function($page) { return $page->position === 3;}) as $page)
                        <p class="uk-margin-small">
                            <a href="/{{$page->slug}}" class="uk-link-reset uk-text-meta">{{$page->name}}</a>
                        </p>
                    @endforeach
                </div>
                <div>
                    <p class="uk-text-large text-small@m uk-text-primary">دسته‌بندی محصولات</p>
                    @foreach($pages->filter(function($page) { return $page->position === 3;}) as $page)
                        <p class="uk-margin-small">
                            <a href="/{{$page->slug}}" class="uk-link-reset uk-text-meta">{{$page->name}}</a>
                        </p>
                    @endforeach
                </div>
                <div>
                    <p class="uk-text-large text-small@m uk-text-primary">لینک‌های مفید</p>
                    @foreach($pages->filter(function($page) { return $page->position === 4;}) as $page)
                        <p class="uk-margin-small">
                            <a href="/{{$page->slug}}" class="uk-link-reset uk-text-meta">{{$page->name}}</a>
                        </p>
                    @endforeach
                </div>
                <div>
                    <p class="uk-text-large text-small@m uk-text-primary">تماس با ما</p>
                    <p class="uk-text-meta" style="line-height: 1.5rem">
                        دفتر مرکزی <br/>تهران، خیابان دماوند، بعد از چهارراه آیت پلاک ۲۸۶، ساختمان زیگما، واحد ۱۵
                    </p>
                    <p class="">
                        <a href="" class="uk-link-reset uk-text-meta">تلفن تماس: ۳۳ ۳۳ ۴۰ ۷۷ - ۰۲۱</a>
                    </p>
                </div>
            </div>
            <hr class="uk-margin-large-top uk-background-default uk-margin-remove-bottom"/>
            <p class="uk-text-light uk-margin-small-top uk-margin-small-bottom text-small@m">کلیه حقوق مادی و معنوی، همچنین حق اثر این سایت
                متعلق به گروه زیگما می‌باید و هر نوع کپی برداری از آن پیگرد قانونی خواهد داشت.</p>
        </div>
    </div>
</footer>