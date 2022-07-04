<template>
    <div>
        <h4>تبدیل امتیاز به کد تخفیف</h4>
        <div class="uk-border-rounded uk-padding-small uk-background-default uk-box-shadow-small">
            <div class="uk-grid uk-flex uk-flex-middle" uk-grid>
                <div class="uk-width-2-5@m">
                    <div class="bordered uk-inline uk-padding-small uk-border-rounded uk-width-expand uk-flex uk-flex-middle">
                        <div class="uk-flex-1">مجموع امتیاز من</div>
                        <div class="uk-margin-right">{{availablePoints}}</div>
                    </div>
                    <div class="uk-margin-small">هر ۵۰ امتیاز یک بن خرید</div>
                    <incrementer :min="0" :max="250" :step="step" :increment-disabled="incrementDisabled" v-model="selectedAmount"
                                 class="bordered uk-padding-small uk-width-expand uk-border-rounded"></incrementer>
                    <div class="bordered uk-inline uk-padding-small uk-border-rounded uk-width-expand uk-text-center uk-margin">
                        اعتبار خرید {{discount.toLocaleString()}} تومان
                    </div>
                    <button :disabled="selectedAmount <= 0" @click="createCoupon()"
                            class="uk-button uk-button-primary uk-width-expand uk-border-rounded">دریافت کد تخفیف
                    </button>
                </div>
                <div class="uk-width-expand uk-text-meta">
                    <p>هر ۵۰ امتیاز معادل یک بن خرید می‌باشد</p>
                    <p>هر بن خرید مبلغ ۲۰۰۰۰ تومان اعتبار خرید در فروشگاه آنلاین زیگما محسوب می‌شود</p>
                    <p>در صورت تبدیل امتیاز به کد تخفیف، امتیاز کسر شده قابل بازیابی نمی‌باشد</p>
                    <p>مدت زمان استفاده از کد تخفیف ۶ ماه است</p>
                    <p>هر کد تخفیف فقط برای شخص قابل استفاده است</p>
                    <p>مهلت استفاده از امتیاز‌ها حداکثر یکسال از تاریخ ثبت می‌باشد</p>
                </div>
            </div>
        </div>
        <h4>تخفیفات من</h4>
        <front-coupons ref="list"></front-coupons>
        <modal name="coupon">
            <div>کد تخفیف</div>
            <input ref="codeInput" class="uk-text-center uk-input uk-border-rounded uk-width-expand uk-margin-small" readonly v-model="code">
            <div class="uk-margin-small uk-text-center uk-text-meta">این کد تخفیف در پنل کاربری شما هم ذخیره می‌شود</div>
            <button @click="copyToClipboard" class="uk-button uk-button-primary uk-width-expand">کپی</button>
        </modal>
    </div>
</template>

<script>
    export default {
        props: ['total-points'],
        data() {
            return {
                availablePoints: this.totalPoints,
                selectedAmount: 0,
                step: 50,
                code: "",
                modal: new Modal('coupon'),
            }
        },
        computed: {
            incrementDisabled() {
                return this.selectedAmount + this.step > this.availablePoints;
            },
            discount() {
                return (this.selectedAmount / 50) * 20000;
            }
        },
        methods: {
            createCoupon() {
                if (this.selectedAmount > 0) {
                    Loading.show();
                    axios.post("/coupon", {amount: this.selectedAmount}).then((response) => {
                        this.code = response.data.code;
                        this.$refs.list.add(response.data);
                        this.availablePoints = parseInt(this.availablePoints) - parseInt(response.data.points);
                        this.selectedAmount = 0;
                        this.modal.show();
                    }).catch((e) => Toast.message(e.response.data.message))
                        .then(() => Loading.hide())
                }
            },
            copyToClipboard() {
                this.$refs.codeInput.focus();
                this.$refs.codeInput.select();
                document.execCommand('copy');
                Toast.message("کد تخفیف به کلیپ‌بورد افزوده شد").success().show();
            }
        }
    }
</script>

<style scoped>

</style>