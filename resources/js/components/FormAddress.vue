<template>
    <form-container :button-class="buttonClass" :button-text="buttonText"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <div class="uk-grid" data-uk-grid>
            <div class="uk-width-expand">
                <div class="uk-grid uk-grid-small uk-grid-match" data-uk-grid>
                    <div class="uk-width-1-2@m">
                        <label class="uk-form-label">استان</label>
                        <select class="uk-select" name="province_id" v-model="form.province_id.value">
                            <option value="" disabled>انتخاب کنید</option>
                            <option v-for="province in provinces" :value="province.id">{{province.name}}</option>
                        </select>
                        <div v-if="form.errors.has('province_id')"
                             class="uk-text-danger uk-text-small">{{form.errors['province_id']}}
                        </div>
                        <label class="uk-form-label">شهر</label>
                        <select class="uk-select" name="city_id" v-model="form.city_id.value">
                            <option value="" disabled>لطفا یک استان را انتخاب کنید</option>
                            <option v-for="city in cities" :value="city.id">{{city.name}}</option>
                        </select>
                        <div v-if="form.errors.has('city_id')"
                             class="uk-text-danger uk-text-small">{{form.errors['city_id']}}
                        </div>
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
                    <div class="uk-width-1-2@m">
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
                    province_id: {
                        value: '',
                        rules: 'required|numeric'
                    },
                    city_id: {
                        value: '',
                        rules: 'required|numeric'
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
                provinces: []
            }
        },
        mounted() {
            if (this.address) {
                this.form.fill(this.address);
            }
            axios.post('/province').then((response) => {
                this.provinces = response.data;
            }).catch((e) => Toast.message(e.response.data.message).danger().show())
                .then(() => Loading.hide());
        },
        computed: {
            cities() {
                return this.form.province_id.value ? _.find(this.provinces, {id: this.form.province_id.value}).cities : [];
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