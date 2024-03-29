<template>
    <div>
        <div class="uk-margin-bottom uk-padding-small uk-padding-remove-vertical">
            <div class="uk-background-muted uk-border-rounded uk-margin-top" style="border: 1px solid gainsboro">
                <div class="uk-padding-small">
                    <div class="uk-grid uk-margin-small-bottom">
                        <div class="uk-width-1-2">
                            <p><strong>نام کاربر: </strong> {{invoice.user.name}}</p>
                            <p><strong>شماره تماس: </strong> {{invoice.user.mobile}}</p>
                        </div>
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
            <tr v-for="(variation, index) in invoice.variations">
                <td class="uk-table-shrink">{{index + 1}}</td>
                <td class="uk-table-shrink"><img class="uk-border-rounded" :src="getVariationPicture(variation)">
                </td>
                <td class="uk-table-expand">{{variation.sku}}</td>
                <td class="uk-table-expand">{{variation.product.name}}</td>
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
                                مالیات بر ارزش افزوده: ۱۰ درصد
                            </div>
                            <div>
                                مبلغ قابل پرداخت: {{payable.toLocaleString()}} تومان
                            </div>
                            <div>
                                مجموع تخفیف: {{totalDiscount.toLocaleString()}} تومان
                            </div>
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
        props: ['initial-invoice'],
        data() {
            return {
                invoice: this.initialInvoice,
                shippingCode: ''
            }
        },
        mounted() {

        },
        computed: {
            total() {
                return _.sumBy(this.invoice.variations, v => (v.pivot.price + v.pivot.discount) * v.pivot.quantity);
            },
            payable() {
                return _.sumBy(this.invoice.variations, v => (v.pivot.price) * v.pivot.quantity) + _.sumBy(this.invoice.shippings, 'cost');
            },
            totalDiscount() {
                return _.sumBy(this.invoice.variations, v => v.pivot.discount);
            }
        },
        methods: {
            findItemProductName(item) {
                let variation = _.find(this.order.variations, {'id': item.variation_id});
                let type = this.getVariationType(variation);
                let picture = this.getVariationPicture(variation);
                return {
                    'variation_name': variation.name,
                    'type': type,
                    'product_name': variation.product.name,
                    'picture': picture
                }
            },
            updateShippingCode(shipping) {
                Loading.show();
                axios.post(`/dashboard/shipping/${shipping.id}`, {_method: 'patch', code: this.shippingCode}).then(() => {
                    Toast.message('کد مرسوله با موفقیت ثبت شد').success().show()
                }).catch((e) => Toast.message(e.response.data.message).show())
                    .then(() => Loading.hide());
            },
            getVariationType(variation) {
                return _.reduce(variation.values, (type, value) => {
                    return type + " " + value.name;
                }, "");
            },
            getVariationPicture(variation) {
                const picture = _.find(variation.product.pictures, {'id': variation.splash});
                if (picture)
                    return picture.url;
                return '/uploads/xigma_logo.png'
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
