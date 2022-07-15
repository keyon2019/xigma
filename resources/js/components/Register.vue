<template>
    <div class="uk-width-large uk-margin-auto">
        <div class="uk-text-center">
            <img uk-img width="200" src="/uploads/xigma_logo.png">
            <h3 class="uk-margin-small">ثبت نام در زیگما</h3>
        </div>
        <div v-if="step === 1" class="uk-text-center">
            <div class="uk-margin-small">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: phone"></span>
                    <input class="uk-input uk-border-rounded" name="mobile" v-model="form.mobile.value"
                           placeholder="شماره تلفن همراه خود را وارد کنید"
                           type="text">
                </div>
            </div>
            <div class="uk-text-center uk-margin">
                <button @click="getOtp" class="uk-button uk-button-primary uk-border-rounded uk-width-expand">تایید</button>
            </div>
        </div>
        <div v-if="step === 2" class="uk-text-center">
            <digit-input :digits="4" v-model="form.otp.value"></digit-input>
            <div class="uk-text-center uk-margin">
                <button @click="verifyOtp" class="uk-button uk-button-primary uk-border-rounded uk-width-expand">تایید</button>
            </div>
            <div class="uk-grid uk-grid-collapse uk-text-muted">
                <div class="uk-width-expand uk-text-left">
                    <button @click="resend()" :disabled="countdown.time() > 0" class="uk-button uk-button-text">ارسال مجدد
                    </button>
                </div>
                <div><p v-if="countdown.time() > 0" class="mt-2">{{ countdown.formattedTime() }}</p></div>
            </div>
        </div>
        <div v-if="step === 3">
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: phone"></span>
                    <input disabled class="uk-input uk-border-rounded" name="mobile" v-model="form.mobile.value"
                           placeholder="شماره تلفن همراه خود را وارد کنید"
                           type="text">
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: user"></span>
                    <input class="uk-input uk-border-rounded" name="name" v-model="form.name.value"
                           placeholder="نام و نام خانوادگی"
                           type="text">
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: lock"></span>
                    <input class="uk-input uk-border-rounded" name="password" v-model="form.password.value"
                           placeholder="رمز عبور"
                           type="password">
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: lock"></span>
                    <input class="uk-input uk-border-rounded" name="password_confirmation" v-model="form.password_confirmation.value"
                           placeholder="تکرار رمز عبور"
                           type="password">
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-text-small"><input class="uk-checkbox" type="checkbox" name="agreed" v-model="form.agreed.value">
                    کلیه <a class="uk-text-primary" href="/Rules">قوانین و مقررات</a> عضویت در سایت زیگما را مطالعه کرده و با آن
                    موافقم
                </label>
            </div>
            <div class="uk-text-center uk-margin">
                <button @click="register" class="uk-button uk-button-primary uk-border-rounded uk-width-expand">ثبت نام</button>
            </div>
        </div>
    </div>
</template>

<script>

    class Countdown {
        constructor(seconds) {
            this.initialSeconds = seconds;
            this.seconds = seconds;
        }

        time() {
            return this.seconds;
        }

        formattedTime() {
            return `${this.addLeadingZeros(parseInt(this.seconds / 60))}:${this.addLeadingZeros(this.seconds % 60)}`
        }

        start() {
            this.counter = setInterval(() => {
                this.seconds = this.seconds - 1;
                if (this.seconds <= 0) {
                    this.stop();
                }
            }, 1000);
        }

        restart() {
            this.stop();
            this.seconds = this.initialSeconds;
            this.start();
        }

        stop() {
            clearInterval(this.counter);
        }

        addLeadingZeros(n) {
            return ('00' + n).substr(-2);
        }
    }

    import DigitInput from "./DigitInput";

    export default {
        name: "Register",
        components: {DigitInput},
        data() {
            return {
                step: 1,
                countdown: new Countdown(120),
                form: new Form({
                    mobile: {
                        value: '',
                        rules: 'required|numeric|digits:11'
                    },
                    otp: {
                        value: '',
                        rules: 'required|numeric|digits:4'
                    },
                    name: {
                        value: '',
                        rules: 'required|string'
                    },
                    password: {
                        value: '',
                        rules: 'required|string'
                    },
                    password_confirmation: {
                        value: '',
                        rules: 'required|string'
                    },
                    agreed: {
                        value: false,
                        rules: 'required|boolean'
                    }
                })
            }
        },
        methods: {
            getOtp() {
                Loading.show();
                if (this.form.validate(['mobile'])) {
                    axios.post('otp', {mobile: this.form.mobile.value}).then(() => {
                        this.step = 2;
                        this.countdown.restart();
                    }).catch((e) => Toast.message(e.response.data.message).danger().show())
                        .then(() => Loading.hide());
                }
            },
            verifyOtp() {
                Loading.show();
                if (this.form.validate(['mobile', 'otp'])) {
                    axios.post('verify_otp', {mobile: this.form.mobile.value, otp: this.form.otp.value}).then(() => {
                        this.step = 3;
                    }).catch((e) => Toast.message(e.response.data.message).danger().show())
                        .then(() => Loading.hide());
                }
            },
            register() {
                if (this.form.validate()) {
                    Loading.show();
                    axios.post("/register", this.form.asFormData()).then(() => {
                        Toast.message("ثبت نام با موفقیت انجام شد").success().show();
                        window.location.href = "/";
                    }).catch((e) => Toast.message(e.response.data.message).danger().show())
                        .then(() => Loading.hide())
                } else {
                    Toast.message("لطفا تمامی فیلدها را به دقت تکمیل بفرمایید").danger().show();
                }
            },
            resend() {
                this.countdown.stop();
                this.step = 1;
            }
        }
    }
</script>

<style scoped>

</style>