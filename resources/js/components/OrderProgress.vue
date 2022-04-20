<template>
    <div class="uk-border-rounded uk-overflow-hidden uk-box-shadow-small uk-margin uk-inline"
         style="border: 1px solid rgb(218 144 18);">
        <div class="arrow-steps clearfix uk-flex uk-flex-between">
            <div class="step current"><span class="uk-flex uk-flex-middle uk-flex-center">
                    ثبت فاکتور <i class="fa-regular fa-2x fa-credit-card uk-margin-small-left"></i>
                </span></div>
            <div class="step" :class="status >= 2 ? 'current' : ''"><span class="uk-flex uk-flex-middle uk-flex-center">
                    بررسی سفارش <i class="fa-solid fa-magnifying-glass fa-2x uk-margin-small-left"></i>
                </span></div>
            <div class="step" :class="status >= 3 ? 'current' : ''"><span class="uk-flex uk-flex-middle uk-flex-center">
                    آماده‌سازی <i class="fa-solid fa-truck-ramp-box fa-2x uk-margin-small-left"></i>
                </span></div>
            <div class="step" :class="status >= 4 ? 'current' : ''"><span class="uk-flex uk-flex-middle uk-flex-center">
                    ارسال شد <i class="fa-solid fa-truck-fast fa-2x uk-margin-small-left"></i>
                </span></div>
        </div>
        <div v-if="status == 5" class="uk-overlay uk-overlay-default uk-position-cover uk-light" style="z-index:20;background: rgba(163,163,163,0.6);">
            <div class="uk-position-center uk-background-danger uk-text-emphasis uk-padding-small uk-border-rounded uk-box-shadow-small">
                <div class="uk-grid uk-grid-small uk-flex uk-flex-middle">
                    <div class="uk-width-expand uk-text-small">
                        <div>این سفارش لغو گردیده</div>
                        <div>اطلاعات بیشتر</div>
                    </div>
                    <div><i class="fa-solid fa-2x fa-ban"></i></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "OrderProgress",
        props: ['status']
    }
</script>

<style scoped>

</style>