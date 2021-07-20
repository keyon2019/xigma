<template>
    <div>
        <progress class="uk-progress" :value="step" max="3"></progress>
        <div v-if="step === 1">
            <h3 class="uk-margin-remove">انتخاب آدرس</h3>
            <hr class="uk-margin-small"/>
            <template v-if="addresses && addresses.length > 0">
                <div v-for="address in addresses" class="uk-grid uk-grid-small">
                    <div class="uk-width-auto">
                        <label><input @click="selectedAddress = address" class="uk-radio" type="radio" :value="address.id"
                                      name="address_id" v-model="form.address_id.value"></label>
                    </div>
                    <div class="uk-width-expand">
                        <p v-text="address.province"></p>
                        <p v-text="address.city"></p>
                        <p v-text="address.directions"></p>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="uk-text-center">
                    <p class="uk-text-small uk-text-center">شما هیج آدرس ثبت شده‌ای ندارید</p>
                </div>
            </template>
            <div class="uk-margin uk-text-center">
                <button class="uk-button uk-button-secondary uk-margin-small-top uk-border-rounded"
                        @click="showNewAddressModal()">ثبت آدرس
                    جدید
                </button>
                <modal name="address">
                    <h2>ثبت آدرس جدید</h2>
                    <form-address @submit="createAddress"></form-address>
                </modal>
            </div>
        </div>
        <div v-if="step === 2">
            <div class="uk-grid">
                <div class="uk-width-1-3">
                    <div>
                        <label><input @change="getRoutes" class="uk-radio" type="radio" value="2"
                                      name="cost_preference" v-model="form.cost_preference.value">سریع‌ترین</label>
                    </div>
                    <div>
                        <label><input @change="getRoutes" class="uk-radio" type="radio" value="1"
                                      name="cost_preference" v-model="form.cost_preference.value">مقرون به صرفه‌ترین</label>
                    </div>
                </div>
                <div class="uk-width-1-3">
                    <mapbox :key="mapKey" :markers="markers"></mapbox>
                </div>
            </div>
        </div>
        <div v-if="step === 3">
            روش ارسال/دریافت سفارش
            <div>
                <label><input :disabled="!availableShippingMethods.includes(1)" class="uk-radio" type="radio" value="1"
                              name="shipping_method" v-model="form.shipping_method.value">دریافت در محل</label>
            </div>
            <div>
                <label><input :disabled="!availableShippingMethods.includes(2)" class="uk-radio" type="radio" value="2"
                              name="shipping_method" v-model="form.shipping_method.value">ارسال با پیک</label>
            </div>
            <div>
                <label><input :disabled="!availableShippingMethods.includes(3)" class="uk-radio" type="radio" value="3"
                              name="shipping_method" v-model="form.shipping_method.value">ارسال با باربری</label>
            </div>
        </div>
        <div>
            <div class="uk-float-left">
                <button :disabled="step <= 1" @click="step--"
                        class="uk-button uk-border-rounded uk-button-default">مرحله قبل
                </button>
            </div>
            <div class="uk-float-right">
                <button @click="goToStep(step + 1)"
                        class="uk-button uk-border-rounded uk-button-primary"
                        v-text="step >= 3 ? 'پرداخت' : 'مرحله بعد'"></button>
            </div>
        </div>
        <form ref="gatewayForm" :method="gateway.method" :action="gateway.url">
            <input type="hidden" v-for="(value, key) in gateway.fields" :name="key" :value="value">
        </form>
    </div>
</template>

<script>
    import FormAddress from "./FormAddress";

    export default {
        components: {FormAddress},
        data() {
            return {
                step: 1,
                mapKey: 1,
                addressModal: new Modal('address'),
                addresses: null,
                routes: null,
                selectedAddress: null,
                factory: [51.5286869, 35.8243285, 'factory'],
                methods: null,
                methodNames: ['دریافت در محل', 'پیک موتوری', 'حمل با باربری'],
                form: new Form({
                    address_id: {
                        value: null,
                        rules: 'required|numeric'
                    },
                    cost_preference: {
                        value: 1,
                        rules: 'required|numeric'
                    },
                    shipping_method: {
                        value: null,
                        rules: 'required|numeric'
                    },
                    gateway_id: {
                        value: 1,
                        rules: 'required|numeric'
                    }
                }),
                gateway: {
                    method: "POST",
                    url: "",
                    fields: []
                }
            }
        },
        mounted() {
            axios.get('/address').then((response) => {
                this.addresses = response.data.addresses;
            }).catch((e) => Toast.message(e.response.data.message).danger().show());
        },
        methods: {
            goToStep(step) {
                switch (step) {
                    case 2:
                        if (this.form.validate(['address_id'])) {
                            this.getRoutes();
                            this.step++;
                        }
                        break;
                    case 3:
                        if (this.form.validate(['cost_preference'])) {
                            this.step++;
                        }
                        break;
                    case 4:
                        if (this.form.validate()) {
                            Loading.show();
                            axios.post('/order', this.form.asFormData()).then((response) => {
                                this.gateway.fields = response.data.gateway.post_parameters;
                                this.gateway.method = response.data.gateway.method;
                                this.gateway.url = response.data.gateway.url;
                                this.$nextTick(() => {
                                    this.$refs.gatewayForm.submit();
                                })
                            }).catch((e) => {
                                Toast.message(e.response.data.message).danger().show();
                            }).then(() => {
                                Loading.hide();
                            })
                        }
                }
            },
            getRoutes() {
                axios.post('/checkout', this.form.asFormData()).then((response) => {
                    this.routes = response.data.stocks;
                    this.methods = response.data.methods;
                }).catch((e) => Toast.message(e.response.data.message).danger().show())
            },
            intersect(a, b) {
                var setB = new Set(b);
                return [...new Set(a)].filter(x => setB.has(x));
            },
            showNewAddressModal() {
                this.addressModal.show();
            },
            createAddress(form) {
                Loading.show();
                axios.post('/address', form.asFormData()).then((response) => {
                    this.addresses.unshift(response.data.address);
                    Toast.message('آدرس جدید با موفقیت ثبت شد').success().show();
                }).catch((e) => {
                    Toast.message(e.response.data.message).danger().show();
                }).then(() => {
                    Loading.hide();
                })
            }
        },
        computed: {
            markers() {
                this.mapKey++;
                let selectedAddress = this.selectedAddress;
                if (selectedAddress) {
                    if (!this.routes)
                        return [[selectedAddress.longitude, selectedAddress.latitude, 'pin']];
                    return [..._.map(this.routes, (r) => {
                        if (r.stock_id)
                            return [r.longitude, r.latitude];
                        return this.factory;
                    }),
                        ...[[selectedAddress.longitude, selectedAddress.latitude, 'pin']]];
                }
                return [];
            },
            availableShippingMethods() {
                let allMethods = [1, 2, 3];
                return this.intersect(allMethods, this.methods);
            }
        }
    }
</script>

<style scoped>

</style>