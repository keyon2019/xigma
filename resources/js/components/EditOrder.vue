<template>
    <div>
        <p class="uk-margin-remove uk-text-small">زمان ثبت: {{order.created_at}}</p>
        <div class="uk-margin-bottom uk-padding-small uk-padding-remove-vertical">
            <div class="uk-background-muted uk-border-rounded uk-margin-top" style="border: 1px solid gainsboro">
                <div class="uk-padding-small">
                    <div class="uk-grid">
                        <div class="uk-width-1-2">
                            <p><strong>نام کاربر: </strong> {{order.user.name}}</p>
                            <p><strong>آدرس: </strong> {{order.address.province}}, {{order.address.city}},
                                {{order.address.directions}}
                            </p>
                            <p><strong>تلفن: </strong> {{order.address.phone}}</p>
                            <p><strong>موبایل: </strong> {{order.address.mobile}}</p>
                        </div>
                        <div class="uk-width-1-2">
                            <p><strong>وضعیت سفارش: </strong>
                                <select v-model="order.status" class="uk-select uk-width-medium uk-border-rounded">
                                    <option v-for="(status,key) in statuses" :value="key">{{status}}</option>
                                </select>
                            </p>
                            <p><strong>وضعیت پرداخت: </strong>
                                <select v-model="order.paid" class="uk-select uk-width-medium uk-border-rounded">
                                    <option :value="0">پرداخت نشده</option>
                                    <option :value="1">پرداخت شده</option>
                                </select>
                            </p>
                            <p><strong>نحوه ارسال: </strong> {{order.shipping_method}}</p>
                            <p><strong>ترجیح هزینه‌ای: </strong> {{order.cost_preference}}</p>
                        </div>
                    </div>
                    <div>
                        <button class="uk-button uk-button-primary uk-border-rounded">ویرایش</button>
                    </div>
                </div>
            </div>
        </div>
        <table class="uk-table uk-table-striped uk-table-middle">
            <thead>
            <tr>
                <th>#</th>
                <th>تصویر</th>
                <th>نام محصول</th>
                <th>نوع</th>
                <th>مشخصات</th>
                <th>فی</th>
                <th>تعداد</th>
                <th>جمع ردیف</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item,index) in items">
                <td class="uk-table-shrink">{{index + 1}}</td>
                <td class="uk-table-shrink"><img class="uk-border-rounded" :src="item.picture">
                </td>
                <td class="uk-table-expand">{{item.name}}</td>
                <td>{{item.variation}}</td>
                <td>{{item.options}}</td>
                <td>{{item.price.toLocaleString()}}</td>
                <td class="uk-table-shrink">{{item.quantity}}</td>
                <td>{{item.subtotal.toLocaleString()}}</td>
            </tr>
            </tbody>
            <tfoot>
            <tr class="uk-background-muted uk-text-bold">
                <td></td>
                <td colspan="5">جمـــــــــــــــــــــع کــــــــــــــــــــــــــل</td>
                <td>{{total.quantity.toLocaleString()}}</td>
                <td>{{total.price.toLocaleString()}}</td>
            </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['initial-order', 'statuses'],
        data() {
            return {
                order: this.initialOrder
            }
        },
        computed: {
            items() {
                if (this.order.items.length > 0) {
                    let grouped = _.groupBy(this.order.items, 'variation_id');
                    return _.map(grouped, (group) => {
                        let groupInstance = group[0];
                        let item = this.findItemProductName(groupInstance);
                        return {
                            'name': item.product_name,
                            'variation': item.variation_name,
                            'options': item.type,
                            'picture': item.picture,
                            'price': groupInstance.price,
                            'quantity': group.length,
                            'subtotal': group.length * groupInstance.price
                        }
                    });
                }
                return _.map(this.order.variations, (variation) => {
                    return {
                        'name': variation.product.name,
                        'variation': variation.name,
                        'options': this.getVariationType(variation),
                        'picture': this.getVariationPicture(variation),
                        'price': variation.price,
                        'quantity': variation.pivot.quantity,
                        'subtotal': variation.price * variation.pivot.quantity
                    }
                })
            },
            total() {
                return {
                    'quantity': _.sumBy(this.items, 'quantity'),
                    'price': _.sumBy(this.items, 'subtotal')
                }
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
            getVariationType(variation) {
                return _.reduce(variation.values, (type, value) => {
                    return type + " " + value.name;
                });
            },
            getVariationPicture(variation) {
                return _.find(variation.product.pictures, {'id': variation.splash}).url ?? null;
            }
        },
    }
</script>

<style scoped>

</style>