<template>
    <div>
        <div class="uk-margin-bottom uk-padding-small uk-padding-remove-vertical">
            <div class="uk-background-muted uk-border-rounded uk-margin-top" style="border: 1px solid gainsboro">
                <div class="uk-padding-small">
                    <div class="uk-grid uk-margin-small-bottom">
                        <div class="uk-width-1-2">
                            <p><strong>نام کاربر: </strong> {{order.user.name}}</p>
                            <p><strong>شماره تماس: </strong> {{order.user.mobile}}</p>
                            <p><strong>نام گیرنده: </strong> {{order.receiver}}</p>
                            <p><strong>شماره تماس گیرنده: </strong> {{order.receiver_number}}</p>
                        </div>
                        <div class="uk-width-1-2">
                            <p><strong>وضعیت سفارش: </strong>
                                <select v-model="order.status" class="uk-select uk-width-medium uk-border-rounded">
                                    <option v-for="(status,key) in statuses"
                                            :disabled="($user.roles.includes(2) && (key == 1 || key == 2 || key == 5))"
                                            :value="key">{{status}}
                                    </option>
                                </select>
                            </p>
                            <p><strong>ترجیح هزینه‌ای: </strong> {{order.cost_preference}}</p>
                            <p><strong>تاریخ ثبت: </strong> {{order.created_at}}</p>
                            <p><strong>آدرس: </strong> {{order.address.provinceName}}, {{order.address.cityName}},
                                {{order.address.directions}} {{order.address.zip}}
                            </p>
                        </div>
                    </div>
                    <div>
                        <button class="uk-button uk-button-primary uk-border-rounded hidden-in-print" @click="updateOrder">
                            ویرایش
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <table class="uk-table uk-table-striped uk-table-middle">
            <thead>
            <tr>
                <th>#</th>
                <th>تصویر</th>
                <th>کد محصول</th>
                <th>نام محصول</th>
                <th>نوع</th>
                <th>قیمت</th>
                <th>تعداد</th>
                <th>تخفیف</th>
                <th>جمع ردیف</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(variation, index) in order.variations">
                <td class="uk-table-shrink">{{index + 1}}</td>
                <td class="uk-table-shrink"><img class="uk-border-rounded" :src="getVariationPicture(variation)">
                </td>
                <td class="uk-table-expand">{{variation.sku}}</td>
                <td class="uk-table-expand">{{variation.product ? variation.product.name : variation.name}}</td>
                <td>{{variation.filters}}</td>
                <td>{{(variation.pivot.price + variation.pivot.discount).toLocaleString()}}</td>
                <td class="uk-table-shrink">{{variation.pivot.quantity}}</td>
                <td>{{variation.pivot.discount.toLocaleString()}}</td>
                <td>{{(variation.pivot.price * variation.pivot.quantity).toLocaleString()}}</td>
            </tr>
            <tr>
                <td colspan="9">
                    <div>
                        <div class="uk-grid uk-grid-small uk-child-width-1-3" data-uk-grid>
                            <div>
                                جمع کل خرید: {{total.toLocaleString()}} تومان
                            </div>
                            <div>
                                مالیات بر ارزش افزوده: {{order.vat.toLocaleString()}}
                            </div>
                            <div>
                                مبلغ پرداختی: {{payable.toLocaleString()}} تومان
                            </div>
                            <div>
                                مجموع تخفیف: {{totalDiscount.toLocaleString()}} تومان
                            </div>
                            <div>
                                هزینه ارسال: {{totalShippingsCost.toLocaleString()}} تومان
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="9">
                    <div class="uk-text-meta uk-margin-small-bottom">اطلاعات پرداخت</div>
                    <div class="uk-grid uk-child-width-1-4">
                        <div>وضعیت پرداخت: {{order.paid ? "پرداخت شده" : "در انتظار پرداخت"}}</div>
                        <div>تاریخ پرداخت: <span v-if="order.successful_payment">{{order.successful_payment.updated_at}}</span>
                        </div>
                        <div>درگاه پرداخت: <span v-if="order.successful_payment">{{order.successful_payment.gatewayName}}</span>
                        </div>
                        <div>شماره پیگیری: <span
                                v-if="order.successful_payment">{{order.successful_payment.reference_number}}</span></div>
                    </div>
                </td>
            </tr>
            <tr v-for="(shipping, index) in order.shippings">
                <td colspan="9">
                    <div class="uk-text-meta">اطلاعات ارسال مرسوله {{index + 1}}</div>
                    <div class="uk-grid uk-child-width-1-3 uk-flex uk-flex-middle uk-grid-small uk-margin-small" data-uk-grid>
                        <div>مبدا ارسال: {{shipping.stock ? shipping.stock.name : 'کارخانه زیگما'}}</div>
                        <div>نحوه ارسال: {{shipping.methodName}}</div>
                        <div v-if="shipping.stock != null">تاریخ‌ارسال: {{shipping.sailed_at}}</div>
                        <div v-else class="uk-flex uk-flex-middle">
                            <div class="uk-margin-small-right">تاریخ‌ارسال:</div>
                            <input class="uk-input uk-border-rounded sailed_at" v-model="shipping.sailed_at">
                            <date-picker ref="picker" custom-input=".sailed_at"
                                         type="datetime"
                                         format="YYYY-MM-DD HH:mm:00"
                                         display-format="jYYYY/jMM/jDD - HH:mm"
                                         v-model="shippingSailedAt"></date-picker>
                        </div>
                        <div>هزینه ارسال: {{shipping.cost.toLocaleString()}}</div>
                        <div class="uk-width-expand">شماره مرسوله/بارنامه:
                            <template>
                                <span v-if="shipping.stock == null">
                                    <span class="uk-inline">
                                        <input class="uk-input uk-border-rounded" v-model="shippingCode"
                                               type="text">
                                    </span>
                                </span>
                                <span v-else>{{shipping.code}}</span>
                            </template>
                        </div>
                        <div v-if="shipping.stock == null">
                            <button class="uk-button uk-button-primary uk-border-rounded uk-button-small"
                                    @click="updateShippingCode(shipping)">به‌روزرسانی
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['initial-order', 'statuses'],
        data() {
            return {
                order: this.initialOrder,
                shippingCode: '',
                shippingSailedAt: '',
            }
        },
        mounted() {
            const factoryShipping = _.find(this.order.shippings, s => s.stock === null);
            if (factoryShipping) {
                this.shippingCode = factoryShipping.code;
                // this.shippingSailedAt = factoryShipping.sailed_at;
            }
        },
        computed: {
            total() {
                return _.sumBy(this.order.variations, v => (v.pivot.price + v.pivot.discount) * v.pivot.quantity);
            },
            payable() {
                return this.order.total;
            },
            totalDiscount() {
                return _.sumBy(this.order.variations, v => v.pivot.discount);
            },
            totalShippingsCost() {
                return _.sumBy(this.order.shippings, 'cost');
            },
        },
        methods: {
            findItemProductName(item) {
                let variation = _.find(this.order.variations, {'id': item.variation_id});
                let type = this.getVariationType(variation);
                let picture = this.getVariationPicture(variation);
                return {
                    'variation_name': variation.name,
                    'type': type,
                    'product_name': variation.product ? variation.product.name : "unknown",
                    'picture': picture
                }
            },
            updateShippingCode(shipping) {
                Loading.show();
                axios.post(`/dashboard/shipping/${shipping.id}`, {
                    _method: 'patch',
                    code: this.shippingCode,
                    sailed_at: this.shippingSailedAt,
                }).then(() => {
                    Toast.message('کد مرسوله با موفقیت ثبت شد').success().show()
                }).catch((e) => Toast.message(e.response.data.message).danger().show())
                    .then(() => Loading.hide());
            },
            getVariationType(variation) {
                return _.reduce(variation.values, (type, value) => {
                    return type + " " + value.name;
                }, "");
            },
            getVariationPicture(variation) {
                if (!variation.product) {
                    if (variation.picture) {
                        return variation.picture.url;
                    }
                    return '/uploads/xigma_logo.png';
                }
                const picture = _.find(variation.product.pictures, {'id': variation.splash});
                if (picture)
                    return picture.url;
                return '/uploads/xigma_logo.png';
            },
            getShippingMethodName(id) {
                switch (id) {
                    case 1:
                        return 'دریافت در محل';
                    case 2:
                        return 'ارسال با پست';
                    case 3:
                        return 'ارسال با باربری';
                    default:
                        return ''
                }
            },
            updateOrder() {
                Loading.show();
                axios.post(`/dashboard/order/${this.order.id}`, {
                    _method: "patch",
                    status: this.order.status,
                    paid: this.order.paid
                }).then(() => {

                    Toast.message("سفارش با موفقیت به روزرسانی شد").success().show();
                })
                    .catch((e) => Toast.message(e.response.data.message).danger().show())
                    .then(() => Loading.hide());
            }
        },
    }
</script>

<style scoped>

</style>