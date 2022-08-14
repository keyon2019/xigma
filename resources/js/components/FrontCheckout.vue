<template>
    <div>
        <div class="uk-grid uk-grid-small" data-uk-grid>
            <div class="uk-width-3-4@m">
                <a href="/cart" class="uk-button uk-button-secondary uk-background-gray uk-border-rounded">
                    <i uk-icon="chevron-right" class="uk-margin-small-right"></i><span>بازگشت به سبد خرید</span>
                </a>
                <div class="uk-padding-small address-container uk-border-rounded uk-margin">
                    <div class="uk-text-bold">مشخصات گیرنده کالا</div>
                    <div class="uk-margin-small">
                        <label><input v-model="alternateReceiver" :true-value="false" :false-value="true"
                                      class="uk-checkbox uk-margin-small-right" type="checkbox"
                                      name="available">گیرنده کالا خودم هستم</label>
                    </div>
                    <template v-if="alternateReceiver">
                        <div class="uk-margin-small">
                            <input name="receiver" class="uk-input uk-border-rounded" v-model="form.receiver.value"
                                   placeholder="نام گیرنده">
                            <div v-if="form.errors.has('receiver')"
                                 class="uk-text-danger uk-text-small">{{form.errors['receiver']}}
                            </div>
                        </div>
                        <div class="uk-margin-small">
                            <input class="uk-input uk-border-rounded" v-model="form.receiver_number.value"
                                   placeholder="شماره گیرنده">
                            <div v-if="form.errors.has('receiver_number')"
                                 class="uk-text-danger uk-text-small">{{form.errors['receiver_number']}}
                            </div>
                        </div>
                    </template>
                </div>
                <div class="address-container uk-padding-small uk-border-rounded">
                    <div class="uk-grid uk-child-width-1-3@m uk-grid-small uk-grid-match" data-uk-grid>
                        <div v-for="address in addresses">
                            <div class="address-container uk-border-rounded uk-padding-small">
                                <div class="uk-flex">
                                    <div class="uk-margin-small-right">
                                        <label><input @click="selectedAddress = address" class="uk-radio" type="radio"
                                                      :value="address.id"
                                                      name="address_id" v-model="form.address_id.value"></label>
                                    </div>
                                    <div>
                                        <p class="uk-margin-small"><span class="uk-text-bold">استان: </span>
                                            {{address.provinceName}}
                                        </p>
                                        <p class="uk-margin-small"><span class="uk-text-bold">شهر: </span> {{address.cityName}}
                                        </p>
                                        <p class="uk-margin-small"><span class="uk-text-bold">آدرس: </span> {{address.directions}}
                                        <p class="uk-margin-small"><span class="uk-text-bold">کدپستی: </span> {{address.zip}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-text-center uk-border-rounded uk-width-1-5@s">
                            <div class="address-container uk-border-rounded uk-padding-small clickable uk-flex uk-flex-middle uk-flex-center"
                                 @click="showAddressModal">
                                <div>
                                    <i class="uk-margin-small-bottom uk-text-primary" data-uk-icon="icon:plus;ratio:2"></i>
                                    <p class="uk-margin-remove uk-text-small uk-text-primary">افزودن آدرس جدید</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <template v-if="form.address_id.value">
                    <hr/>
                    <div class="uk-grid uk-grid-small uk-child-width-1-2@m" data-uk-grid>
                        <div>
                            <ul class="uk-child-width-expand uk-subnav uk-subnav-pill uk-text-center" uk-switcher>
                                <li><a @click="form.cost_preference.value = 1" class="uk-border-rounded"
                                       style="padding: 10px;border:1px solid gainsboro" href="#">کم‌هزینه‌ترین
                                    روش ارسال</a></li>
                                <li><a @click="form.cost_preference.value = 2" class="uk-border-rounded"
                                       style="padding: 10px;border:1px solid gainsboro" href="#">سریع‌ترین
                                    روش ارسال</a></li>
                            </ul>
                        </div>
                        <div>
                            <button class="uk-button uk-button-secondary uk-float-right uk-border-rounded" @click="getRoutes()">
                                راهنمای ارسال کالا
                            </button>
                        </div>
                    </div>
                    <div class="uk-margin-small-top">
                        <table class="uk-table uk-table-middle uk-table-large full-bordered uk-table-responsive">
                            <thead>
                            <tr class="uk-background-muted">
                                <th>ردیف</th>
                                <th>شرح کالا</th>
                                <th>تعداد</th>
                                <th class="uk-text-center@m">قیمت کل (تومان)</th>
                                <th class="uk-width-1-4">فرستنده</th>
                                <th>نحوه ارسال</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(group, retailerName) in shippings">
                                <td class="uk-table-shrink">
                                    <p class="uk-margin-large" v-for="(item, index) in group.items">{{item.id}}</p>
                                </td>
                                <td class="uk-table-expand">
                                    <p class="uk-margin-large" v-for="item in group.items" v-text="item.name"></p>
                                </td>
                                <td>
                                    <p class="uk-margin-large uk-text-center@m" v-for="item in group.items"
                                       v-text="item.quantity"></p>
                                </td>
                                <td>
                                    <p class="uk-margin-large uk-text-center@m" v-for="item in group.items"
                                       v-text="(item.price * item.quantity).toLocaleString()"></p>
                                </td>
                                <td>
                                    <dl>
                                        <dt>{{retailerName}}</dt>
                                        <dd class="uk-text-meta">{{group.retailerAddress}}</dd>
                                    </dl>

                                </td>
                                <td>
                                    <p v-for="method in group.shippingMethods">
                                        <label class="uk-text-small uk-flex uk-flex-middle"><input :disabled="method.id === 1"
                                                                                                   class="uk-radio" type="radio"
                                                                                                   :value="{
                                                                                           'stock_id' : group.retailer_id,
                                                                                           'method': method.id,
                                                                                           'cost': method.id === 2 ? group.delivery_cost : 0
                                                                                           }"
                                                                                                   :name="`shipping_methods[${group.retailer_id}]`"
                                                                                                   v-model="form.shipping_methods.value[group.retailer_id]">
                                            <div class="uk-margin-small-left">
                                                <div>{{method.name}}</div>
                                                <div class="uk-text-meta" v-if="method.id === 2">هزینه ارسال
                                                    {{group.delivery_cost.toLocaleString()}} تومان
                                                </div>
                                            </div>
                                        </label>
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </template>
            </div>
            <div class="uk-width-1-4@m">
                <div class="uk-background-muted uk-padding-small uk-border-rounded uk-text-small"
                     style="border: 1px solid gainsboro">
                    <div class="uk-grid-small uk-text-muted" uk-grid>
                        <div class="uk-width-expand">جمع قیمت اقلام</div>
                        <div>{{(cart.total() + cart.totalDiscount()).toLocaleString()}}</div>
                    </div>
                    <div class="uk-grid-small uk-text-muted" uk-grid>
                        <div class="uk-width-expand">جمع تخفیفات</div>
                        <div>{{cart.totalDiscount().toLocaleString()}}</div>
                    </div>
                    <hr class="uk-text-muted"/>
                    <div class="uk-grid-small uk-text-muted" uk-grid>
                        <div class="uk-width-expand">جمع مبلغ</div>
                        <div>{{cart.total().toLocaleString()}}</div>
                    </div>
                    <div class="uk-grid-small uk-text-muted" uk-grid>
                        <div class="uk-width-expand">هزینه ارسال</div>
                        <div>{{totalDeliveryCost.toLocaleString()}}</div>
                    </div>
                    <hr class="uk-text-muted"/>
                    <template v-if="!this.coupon">
                        <p class="uk-margin-small-bottom uk-text-muted">ثبت کد تخفیف</p>
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-expand">
                                <input class="uk-input uk-border-rounded uk-form-small" v-model="form.coupon.value"
                                       placeholder="کد تخفیف">
                            </div>
                            <div>
                                <button @click="checkCoupon"
                                        class="uk-button uk-border-rounded uk-button-primary uk-button-small uk-button-default">
                                    ثبت
                                </button>
                            </div>
                        </div>
                    </template>
                    <div v-else>
                        <div class="uk-grid-small uk-text-muted" uk-grid>
                            <div class="uk-width-expand">کد تخفیف</div>
                            <div>{{this.coupon.discount.toLocaleString()}}</div>
                        </div>
                    </div>
                    <div class="uk-grid-small uk-margin uk-text-bolder" uk-grid>
                        <div class="uk-width-expand">جمع کل (بدون احتساب مالیات)</div>
                        <div>{{totalOrderCost.toLocaleString()}}</div>
                    </div>
                    <div class="uk-grid-small uk-margin uk-text-bolder" uk-grid>
                        <div class="uk-width-expand">مالیات (۹٪)</div>
                        <div>{{vat.toLocaleString()}}</div>
                    </div>
                    <div class="uk-grid-small uk-margin uk-text-bolder" uk-grid>
                        <div class="uk-width-expand">مبلغ قابل پرداخت</div>
                        <div>{{totalPayable.toLocaleString()}}</div>
                    </div>
                    <div class="uk-grid uk-grid-small uk-child-width-1-3 uk-flex uk-flex-center">
                        <div v-for="gateway in gateways" class="uk-text-center">
                            <img class="uk-margin-small-bottom" :src="gateway.icon">
                            <label>
                                <input v-model="form.gateway_id.value" class="uk-radio" type="radio"
                                       :value="gateway.id">
                            </label>
                        </div>
                    </div>
                    <div class="uk-margin-top">
                        <button @click="placeOrder" class="uk-button uk-button-danger uk-border-rounded uk-width-expand">پرداخت
                            مبلغ و ثبت نهایی
                            فاکتور
                        </button>
                    </div>
                </div>
                <div class="uk-margin-small-top uk-padding-small uk-border-rounded" style="border: 1px solid gainsboro"
                     v-if="shippings">
                    <div class="uk-light uk-margin-small">
                        <div class="uk-text-center uk-background-secondary uk-border-rounded uk-padding-small">نمایش مسیر ارسال
                            کالا
                        </div>
                    </div>
                    <mapbox class="uk-border-rounded" :key="mapKey" :markers="markers"></mapbox>
                </div>
            </div>
        </div>
        <modal class="uk-modal-container" name="address">
            <h2>ثبت آدرس جدید</h2>
            <form-address v-if="showModalMap" @submit="createAddress"></form-address>
        </modal>
        <form ref="gatewayForm" :method="gateway.method" :action="gateway.url">
            <input type="hidden" v-for="(value, key) in gateway.fields" :name="key" :value="value">
        </form>
    </div>
</template>

<script>

    export default {
        props: ['gateways'],
        data() {
            return {
                step: 1,
                mapKey: 1,
                addressModal: new Modal('address'),
                addresses: null,
                selectedAddress: null,
                factory: [51.5286869, 35.8243285, 'factory'],
                methods: null,
                coupon: null,
                alternateReceiver: false,
                showModalMap: false,
                shippings: null,
                cart: window.Cart,
                form: new Form({
                    address_id: {
                        value: null,
                        rules: 'required|numeric'
                    },
                    cost_preference: {
                        value: 1,
                        rules: 'required|numeric'
                    },
                    shipping_methods: {
                        value: {},
                        rules: 'required|object'
                    },
                    gateway_id: {
                        value: 2,
                        rules: 'required|numeric'
                    },
                    receiver: {
                        value: '',
                        rules: 'required|string'
                    },
                    receiver_number: {
                        value: '',
                        rules: 'required|numeric'
                    },
                    coupon: {
                        value: '',
                        rules: 'string'
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
            placeOrder() {
                if (this.form.address_id.value == null) {
                    Toast.message("لطفا آدرس ارسال سفارش را مشخص بفرمایید").danger().show();
                    return;
                }
                if (Object.values(this.form.shipping_methods.value).length !== Object.values(this.shippings).length) {
                    Toast.message("لطفا نحوه ارسال تمامی مرسولات را مشخص نمایید").danger().show();
                    return;
                }
                if (this.form.validate()) {
                    Loading.show();
                    axios.post('/order', this.form.asFormData()).then((response) => {
                        if (this.totalOrderCost > 0) {
                            this.gateway.fields = response.data.gateway.post_parameters;
                            this.gateway.method = response.data.gateway.method;
                            this.gateway.url = response.data.gateway.url;
                            this.$nextTick(() => {
                                this.$refs.gatewayForm.submit();
                            })
                        } else {
                            window.location.replace(`/order/${response.data.id}`);
                        }
                    }).catch((e) => {
                        Toast.message(e.response.data.message).danger().show();
                    }).then(() => {
                        Loading.hide();
                    })
                }
            },
            getRoutes() {
                Loading.show();
                axios.post('/checkout', this.form.asFormData()).then((response) => {
                    this.shippings = response.data;
                }).catch((e) => Toast.message(e.response.data.message).danger().show())
                    .then(() => Loading.close());
            },
            createAddress(form) {
                Loading.show();
                axios.post('/address', form.asFormData()).then((response) => {
                    this.addresses.unshift(response.data.address);
                    Toast.message('آدرس جدید با موفقیت ثبت شد').success().show();
                    this.addressModal.hide();
                }).catch((e) => {
                    Toast.message(e.response.data.message).danger().show();
                }).then(() => {
                    Loading.hide();
                })
            },
            showAddressModal() {
                this.addressModal.show(() => {
                    this.showModalMap = true;
                })
            },
            checkCoupon() {
                if (this.form.coupon.value !== "") {
                    Loading.show();
                    axios.post('/coupon/validate', {'coupon': this.form.coupon.value}).then((response) => {
                        this.coupon = response.data;
                        Toast.message('کد تخفیف با موفقیت اعمال شد').success().show();
                    }).catch((e) => Toast.message(e.response.data.message).danger().show()).then(() => Loading.hide())
                }
            }
        },
        computed: {
            markers() {
                this.mapKey++;
                let selectedAddress = this.selectedAddress;
                if (selectedAddress) {
                    if (!this.shippings)
                        return [[selectedAddress.longitude, selectedAddress.latitude, 'pin']];
                    return [..._.map(this.shippings, (r) => {
                        if (r.retailer_id)
                            return [r.longitude, r.latitude];
                        return this.factory;
                    }),
                        ...[[selectedAddress.longitude, selectedAddress.latitude, 'pin']]];
                }
                return [];
            },
            totalDeliveryCost() {
                return _.sumBy(Object.values(this.form.shipping_methods.value), 'cost')
            },
            totalOrderCost() {
                let orderDiscount = this.coupon ? this.coupon.discount : 0;
                return Math.max(this.cart.total() + this.totalDeliveryCost - orderDiscount, 0);
            },
            vat() {
                return Math.round(this.totalOrderCost * 0.09);
            },
            totalPayable() {
                return Math.round(this.totalOrderCost + this.vat);
            }
        },
        watch: {
            'form.address_id.value': function () {
                this.getRoutes();
            },
            'form.cost_preference.value': function () {
                this.getRoutes();
            },
            'alternateReceiver': {
                immediate: true,
                handler(value) {
                    if (!value) {
                        this.form.receiver.value = this.user.name;
                        this.form.receiver_number.value = this.user.mobile;
                    } else {
                        this.form.receiver.value = '';
                        this.form.receiver_number.value = '';
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .address-container {
        border: 1px solid #474747;
    }
</style>