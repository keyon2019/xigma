<template>
    <div>
        <div class="uk-margin-top">
            <table class="uk-table uk-table-divider uk-table-middle uk-box-shadow-small uk-table-small
             uk-background-default uk-border-rounded">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام محصول</th>
                    <th>سریال</th>
                    <th>نوع</th>
                    <th>قیمت</th>
                    <th>تعداد</th>
                    <th>تخفیف</th>
                    <th>جمع ردیف</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in items">
                    <td>{{ index + 1 }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.sku }}</td>
                    <td>{{ item.productName }}</td>
                    <td>{{ item.price.toLocaleString() }}</td>
                    <td>{{ item.pivot.quantity }}</td>
                    <td>{{ (item.pivot.quantity * item.pivot.discount).toLocaleString() }}</td>
                    <td>{{ (item.pivot.quantity * item.pivot.price).toLocaleString() }}</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">جمع کل</td>
                    <td>{{ totalQuantity }}</td>
                    <td>{{ totalDiscount.toLocaleString() }}</td>
                    <td>{{ totalPrice.toLocaleString() }}</td>
                </tr>
                <tr>
                    <td colspan="5">مالیات بر ارزش افزوده</td>
                    <td></td>
                    <td></td>
                    <td>{{ (totalPrice * 0.1).toLocaleString() }}</td>
                </tr>
                <tr>
                    <td colspan="5">قابل پرداخت</td>
                    <td></td>
                    <td></td>
                    <td>{{ (totalPrice * 1.1).toLocaleString() }}</td>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="hidden-in-print">
            <button class="uk-button uk-button-primary uk-border-rounded" onclick="window.print()">چاپ</button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['invoice'],
    data() {
        return {
            items: this.invoice.variations,
        }
    },
    methods: {
    },
    computed: {
        totalQuantity() {
            return _.sumBy(this.items, i => i.pivot.quantity);
        },
        totalPrice() {
            return _.sumBy(this.items, i => i.pivot.price * i.pivot.quantity);
        },
        totalDiscount() {
            return _.sumBy(this.items, i => i.pivot.discount * i.pivot.quantity);
        }
    }
}
</script>
