<template>
    <form-container :button-class="buttonClass" :button-text="buttonText"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <div class="uk-grid" data-uk-grid>
            <div class="uk-width-expand">
                <div class="uk-grid uk-grid-small" data-uk-grid>
                    <div class="uk-width-expand">
                        <form-input label="نام کاربر" classes="uk-input"
                                    type="input"
                                    name="name"
                                    :disabled="!$user.is_admin"
                                    :errors="form.errors"
                                    v-model="form.name.value">
                        </form-input>
                        <form-input :disabled="!$user.is_admin" label="موبایل" classes="uk-input"
                                    type="input"
                                    name="mobile"
                                    :errors="form.errors"
                                    v-model="form.mobile.value">
                        </form-input>
                        <form-input label="ایمیل" classes="uk-input"
                                    type="input"
                                    name="email"
                                    :errors="form.errors"
                                    v-model="form.email.value">
                        </form-input>
                        <div>
                            <label class="uk-form-label">رمز عبور</label>
                            <div class="uk-form-controls">
                                <input class="uk-input " type="password" v-model="form.password.value" name="password">
                            </div>
                        </div>
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