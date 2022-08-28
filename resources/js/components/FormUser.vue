<template>
    <form-container :button-class="buttonClass" :button-text="buttonText"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <div class="uk-grid" data-uk-grid>
            <div class="uk-width-expand">
                <div class="uk-grid uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-2">
                        <form-input label="نام کاربر" classes="uk-input"
                                    type="input"
                                    name="name"
                                    :disabled="!$user.is_admin"
                                    :errors="form.errors"
                                    v-model="form.name.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-2">
                        <form-input label="کد ملی" classes="uk-input"
                                    type="input"
                                    name="ssn"
                                    :errors="form.errors"
                                    v-model="form.ssn.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-2">
                        <form-input label="ایمیل" classes="uk-input"
                                    type="input"
                                    name="email"
                                    :errors="form.errors"
                                    v-model="form.email.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-2">
                        <form-input :disabled="!$user.is_admin" label="موبایل" classes="uk-input"
                                    type="input"
                                    name="mobile"
                                    :errors="form.errors"
                                    v-model="form.mobile.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-2">
                        <form-input label="تلفن ثابت" classes="uk-input"
                                    type="input"
                                    name="telephone"
                                    :errors="form.errors"
                                    v-model="form.telephone.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-2">
                        <label class="uk-form-label">تاریخ تولد</label>
                        <div class="uk-form-controls uk-flex uk-flex-bottom">
                            <input class="uk-input uk-border-rounded sailed_at" v-model="form.birthday.value">
                            <date-picker ref="picker" custom-input=".sailed_at"
                                         type="date"
                                         format="YYYY-MM-DD"
                                         display-format="jYYYY/jMM/jDD"
                                         v-model="form.birthday.value"></date-picker>
                        </div>
                    </div>
                    <div class="uk-width-1-2">
                        <form-input label="تلفن اضطراری" classes="uk-input"
                                    type="input"
                                    name="emergency_mobile"
                                    :errors="form.errors"
                                    v-model="form.emergency_mobile.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-2">
                        <label class="uk-form-label">رمز عبور</label>
                        <div class="uk-form-controls">
                            <input class="uk-input " type="password" v-model="form.password.value" name="password">
                        </div>
                    </div>
                    <div class="uk-width-1-1">
                        <div class="uk-flex uk-flex-middle uk-margin-small">
                            <label><input v-model="form.is_retailer.value" class="uk-checkbox" type="checkbox">
                                فروشنده</label>
                        </div>
                        <div class="uk-flex uk-flex-middle uk-margin-small">
                            <label><input v-model="form.is_active.value" class="uk-checkbox" type="checkbox">
                                فعال</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form-container>
</template>

<script>

    import AutoComplete from "./AutoComplete";

    export default {
        components: {AutoComplete},
        props: ['user', 'button-class', 'button-text'],
        data() {
            return {
                categories: [],
                form: new Form({
                    name: {
                        value: '',
                        rules: 'required|string'
                    },
                    mobile: {
                        value: '',
                        rules: 'required|numeric'
                    },
                    telephone: {
                        value: '',
                        rules: 'numeric'
                    },
                    emergency_mobile: {
                        value: '',
                        rules: 'numeric'
                    },
                    birthday: {
                        value: '',
                        rules: 'string'
                    },
                    ssn: {
                        value: '',
                        rules: 'numeric'
                    },
                    email: {
                        value: '',
                        rules: 'string',
                    },
                    password: {
                        value: '',
                        rules: 'string',
                    },
                    is_retailer: {
                        value: '',
                        rules: 'boolean',
                    },
                    is_active: {
                        value: '',
                        rules: 'boolean',
                    },
                }),
            }
        },
        mounted() {
            if (this.user) {
                this.form.fill(this.user);
            }
            axios.get('/dashboard/user').then((response) => {
                this.users = response.data.data;
            }).catch((e) => {
                Toast.message(e.response.data.message).danger().show();
            })
        },
        methods: {
            submit() {
                if (this.form.validate()) {
                    this.$emit('submit', this.form);
                }
            },
        }
    }
</script>

<style scoped>

</style>