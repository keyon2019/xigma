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
                            <input name="receiver" class="uk-input uk-border-rounded" v-model="form.receiver.value" placeholder="نام گیرنده">
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
                                        <p class="uk-margin-small"><span class="uk-text-bold">استان: </span> {{address.province}}
                                        </p>
                                        <p class="uk-margin-small"><span class="uk-text-bold">شهر: </span> {{address.city}}</p>
                                        <p class="uk-margin-small"><span class="uk-text-bold">آدرس: </span> {{address.directions}}
                                        <p class="uk-margin-small"><span class="uk-text-bold">کدپستی: </span> {{address.zip}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-text-center uk-border-rounded uk-width-1-5@s">
                            <div class="address-container uk-border-rounded uk-padding-small clickable uk-flex uk-flex-middle uk-flex-center"
                                 @click="addressModal.show()">
                                <div>
                                    <i class="uk-margin-small-bottom uk-text-primary" data-uk-icon="icon:plus;ratio:2"></i>
                                    <p class="uk-margin-remove uk-text-small uk-text-primary">افزودن آدرس جدید</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <tr v-for="(retailer,id) in tableItems">
                            <td class="uk-table-shrink">
                                <p class="uk-margin-large" v-for="(item, index) in retailer.items">{{item.id}}</p>
                            </td>
                            <td class="uk-table-expand">
                                <p class="uk-margin-large" v-for="item in retailer.items" v-text="item.name"></p>
                            </td>
                            <td>
                                <p class="uk-margin-large uk-text-center@m" v-for="item in retailer.items"
                                   v-text="item.quantity"></p>
                            </td>
                            <td>
                                <p class="uk-margin-large uk-text-center@m" v-for="item in retailer.items"
                                   v-text="item.price.toLocaleString()"></p>
                            </td>
                            <td>
                                <dl>
                                    <dt>{{retailer.retailer}}</dt>
                                    <dd class="uk-text-meta">{{retailer.address}}</dd>
                                </dl>

                            </td>
                            <td>
                                <p v-for="method in retailer.shippingMethods">
                                    <label class="uk-text-small uk-flex uk-flex-middle"><input class="uk-radio" type="radio"
                                                                                               :value="{
                                                                                           'stock' : id,
                                                                                           'method': method.id,
                                                                                           'cost': method.id === 2 ? retailer.delivery_cost : 0
                                                                                           }"
                                                                                               :name="`shipping_methods[${id}]`"
                                                                                               v-model="form.shipping_methods.value[id]">
                                        <div class="uk-margin-small-left">
                                            <div>{{method.name}}</div>
                                            <div class="uk-text-meta" v-if="method.id === 2">هزینه ارسال
                                                {{retailer.delivery_cost.toLocaleString()}} تومان
                                            </div>
                                        </div>
                                    </label>
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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
                    <p class="uk-margin-small-bottom uk-text-muted">ثبت کد تخفیف</p>
                    <input class="uk-input uk-border-rounded" placeholder="کد تخفیف">
                    <div class="uk-grid-small uk-margin uk-text-bolder" uk-grid>
                        <div class="uk-width-expand">مبلغ قابل پرداخت</div>
                        <div>{{totalOrderCost.toLocaleString()}}</div>
                    </div>
                    <div class="uk-grid uk-child-width-1-3 uk-flex uk-flex-center">
                        <div v-for="gateway in gateways" class="uk-text-center">
                            <img class="uk-margin-small-bottom" :src="gateway.icon">
                            <label>
                                <input v-model="form.gateway_id.value" class="uk-radio" type="radio" :value="gateway.id">
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
                     v-if="routes">
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
            <form-address @submit="createAddress"></form-address>
        </modal>
        <!--</div>-->
        <!--</div>-->
        <!--<div v-if="step === 2">-->
        <!--<div class="uk-grid">-->
        <!--<div class="uk-width-1-3">-->
        <!--<div>-->
        <!--<label><input @change="getRoutes" class="uk-radio" type="radio" value="2"-->
        <!--name="cost_preference" v-model="form.cost_preference.value">سریع‌ترین</label>-->
        <!--</div>-->
        <!--<div>-->
        <!--<label><input @change="getRoutes" class="uk-radio" type="radio" value="1"-->
        <!--name="cost_preference" v-model="form.cost_preference.value">مقرون به صرفه‌ترین</label>-->
        <!--</div>-->
        <!--</div>-->
        <!--<div class="uk-width-1-3">-->
        <!--<mapbox :key="mapKey" :markers="markers"></mapbox>-->
        <!--</div>-->
        <!--</div>-->
        <!--</div>-->
        <!--<div v-if="step === 3">-->
        <!--روش ارسال/دریافت سفارش-->
        <!--<div>-->
        <!--<label><input :disabled="!availableShippingMethods.includes(1)" class="uk-radio" type="radio" value="1"-->
        <!--name="shipping_methods" v-model="form.shipping_method.value">دریافت در محل</label>-->
        <!--</div>-->
        <!--<div>-->
        <!--<label><input :disabled="!availableShippingMethods.includes(2)" class="uk-radio" type="radio" value="2"-->
        <!--name="shipping_method" v-model="form.shipping_method.value">ارسال با پیک</label>-->
        <!--</div>-->
        <!--<div>-->
        <!--<label><input :disabled="!availableShippingMethods.includes(3)" class="uk-radio" type="radio" value="3"-->
        <!--name="shipping_method" v-model="form.shipping_method.value">ارسال با باربری</label>-->
        <!--</div>-->
        <!--</div>-->
        <!--<div>-->
        <!--<div class="uk-float-left">-->
        <!--<button :disabled="step <= 1" @click="step&#45;&#45;"-->
        <!--class="uk-button uk-border-rounded uk-button-default">مرحله قبل-->
        <!--</button>-->
        <!--</div>-->
        <!--<div class="uk-float-right">-->
        <!--<button @click="goToStep(step + 1)"-->
        <!--class="uk-button uk-border-rounded uk-button-primary"-->
        <!--v-text="step >= 3 ? 'پرداخت' : 'مرحله بعد'"></button>-->
        <!--</div>-->
        <!--</div>-->
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
                routes: null,
                selectedAddress: null,
                factory: [51.5286869, 35.8243285, 'factory'],
                methods: null,
                alternateReceiver: false,
                allShippingMethods: [
                    {
                        id: 1,
                        name: 'دریافت در محل',
                    },
                    {
                        id: 2,
                        name: 'ارسال با پست',
                    },
                    {
                        id: 3,
                        name: 'حمل با باربری',
                    }
                ],
                items: [],
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
                        value: 1,
                        rules: 'required|numeric'
                    },
                    receiver: {
                        value: '',
                        rules: 'required|string'
                    },
                    receiver_number: {
                        value: '',
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
            placeOrder() {
                if (Object.values(this.form.shipping_methods.value).length !== Object.values(this.tableItems).length) {
                    Toast.message("لطفا نحوه ارسال تمامی مرسولات را مشخص نمایید").danger().show();
                    return;
                }
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
            },
            getRoutes() {
                Loading.show();
                axios.post('/checkout', this.form.asFormData()).then((response) => {
                    this.items = response.data.items;
                    this.routes = _.chain(this.items).groupBy('stock_id').map((group) => {
                        return {
                            stock_id: group[0].stock_id,
                            latitude: group[0].latitude,
                            longitude: group[0].longitude
                        }
                    }).value();
                    // this.methods = response.data.methods;
                }).catch((e) => Toast.message(e.response.data.message).danger().show())
                    .then(() => Loading.close());
            },
            intersect(a, b) {
                let setB = new Set(b);
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
            },
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
            tableItems() {
                return _.chain(this.items).groupBy('stock_id').mapValues((groups) => {
                    return {
                        retailer: groups[0].retailerName ?? 'دفتر مرکزی',
                        address: groups[0].retailerAddress,
                        delivery_cost: _.maxBy(groups, 'delivery_cost').delivery_cost,
                        shippingMethods: _.chain(this.allShippingMethods).filter((method) => {
                            if (_.findIndex(groups, ['is_huge', 1]) > -1) {
                                return method.id !== 2;
                            }
                            return true;
                        }).value(),
                        items: _.chain(groups).groupBy('variation_id').map((g) => {
                            return {
                                'name': g[0].name,
                                'quantity': g.length,
                                'price': g[0].price * g.length
                            }
                        }).value()
                    }
                }).value();
            },
            totalDeliveryCost() {
                return _.sumBy(Object.values(this.form.shipping_methods.value), 'cost')
            },
            totalOrderCost() {
                return this.cart.total() + this.totalDeliveryCost;
            },
            availableShippingMethods() {
                let allMethods = [1, 2, 3];
                return this.intersect(allMethods, this.methods);
            }
        },
        watch: {
            'form.address_id.value': function () {
                this.getRoutes();
            },
            'form.cost_preference.value': function () {
                this.getRoutes();
            },
            'alternateReceiver': function (value) {
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
</script>

<style scoped>
    .address-container {
        border: 1px solid #474747;
    }
</style>