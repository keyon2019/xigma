<template>
    <form-container :button-class="buttonClass" :button-text="buttonText"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <div class="uk-grid" data-uk-grid>
            <div class="uk-width-expand">
                <div class="uk-grid uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-2">
                        <form-input label="نام نمایندگی" classes="uk-input"
                                    type="input"
                                    name="name"
                                    :errors="form.errors"
                                    v-model="form.name.value">
                        </form-input>
                        <form-input label="شهر" classes="uk-input"
                                    type="input"
                                    name="city"
                                    :errors="form.errors"
                                    v-model="form.city.value">
                        </form-input>
                        <form-input label="آدرس" classes="uk-input"
                                    type="input"
                                    name="address"
                                    :errors="form.errors"
                                    v-model="form.address.value">
                        </form-input>
                        <div class="uk-margin-small">
                            <auto-complete :initial-input="retailer ? retailer.user.name : ''" v-model="form.user_id.value" value-key="id" api-result-key="users" method="get"
                                           api="/dashboard/user/search?retailer=1" placeholder="کاربر"></auto-complete>
                        </div>
                        <div class="uk-margin">
                            <label><input class="uk-checkbox" v-model="form.available.value" name="available" type="checkbox">
                                محاسبه در الگوریتم</label>
                        </div>
                    </div>
                    <div class="uk-width-1-2">
                        <div class="uk-form-label">آدرس روی نقشه</div>
                        <mapbox :interactive="true" v-model="form.coords.value" lat-name="latitude" lng-name="longitude"></mapbox>
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

    import AutoComplete from "./AutoComplete";

    export default {
        components: {AutoComplete},
        props: ['retailer', 'button-class', 'button-text'],
        data() {
            return {
                categories: [],
                form: new Form({
                    name: {
                        value: '',
                        rules: 'required|string'
                    },
                    city: {
                        value: '',
                        rules: 'string',
                    },
                    address: {
                        value: '',
                        rules: 'string',
                    },
                    available: {
                        value: 1,
                        rules: 'boolean'
                    },
                    coords: {
                        value: null,
                        rules: 'required|object'
                    },
                    user_id: {
                        value: null,
                        rules: 'numeric'
                    }
                }),
            }
        },
        mounted() {
            if (this.retailer) {
                this.form.fill(this.retailer);
            }
            axios.get('/dashboard/retailer').then((response) => {
                this.retailers = response.data.data;
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