<template>
    <form-container :button-class="buttonClass" :button-text="buttonText"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <div class="uk-grid" data-uk-grid>
            <div class="uk-width-expand">
                <div class="uk-grid uk-grid-small uk-grid-match" data-uk-grid>
                    <div class="uk-width-1-2">
                        <form-input label="استان" classes="uk-input"
                                    type="input"
                                    name="province"
                                    :errors="form.errors"
                                    v-model="form.province.value">
                        </form-input>
                        <form-input label="شهر" classes="uk-input"
                                    type="input"
                                    name="city"
                                    :errors="form.errors"
                                    v-model="form.city.value">
                        </form-input>
                        <form-input label="آدرس" classes="uk-input"
                                    type="input"
                                    name="directions"
                                    :errors="form.errors"
                                    v-model="form.directions.value">
                        </form-input>
                        <form-input label="کد پستی" classes="uk-input"
                                    type="input"
                                    name="zip"
                                    :errors="form.errors"
                                    v-model="form.zip.value">
                        </form-input>
                        <form-input label="تلفن" classes="uk-input"
                                    type="input"
                                    name="phone"
                                    :errors="form.errors"
                                    v-model="form.phone.value">
                        </form-input>
                        <form-input label="موبایل" classes="uk-input"
                                    type="input"
                                    name="mobile"
                                    :errors="form.errors"
                                    v-model="form.mobile.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-2">
                        <div class="uk-form-label">آدرس روی نقشه</div>
                        <mapbox :interactive="true" v-model="form.coords.value"></mapbox>
                        <div v-if="form.errors.has('coords')"
                             class="uk-text-danger uk-text-small">{{form.errors['coords']}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form-container>
</template>

<script>

    export default {
        props: ['address', 'button-class', 'button-text'],
        data() {
            return {
                categories: [],
                form: new Form({
                    province: {
                        value: '',
                        rules: 'required|string'
                    },
                    city: {
                        value: '',
                        rules: 'required|string'
                    },
                    directions: {
                        value: '',
                        rules: 'required|string'
                    },
                    zip: {
                        value: '',
                        rules: 'required|numeric|digits:10'
                    },
                    coords: {
                        value: null,
                        rules: 'required|object'
                    },
                    phone: {
                        value: null,
                        rules: 'required|numeric|digits:11'
                    },
                    mobile: {
                        value: null,
                        rules: 'required|numeric|digits:11'
                    }
                }),
            }
        },
        mounted() {
            if (this.address) {
                this.form.fill(this.address);
            }
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