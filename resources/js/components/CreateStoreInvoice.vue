<template>
    <div>
        <div class="uk-grid uk-grid-small hidden-in-print">
            <div>
                <select class="uk-select uk-border-rounded" v-model="retailer">
                    <option v-for="retailer in retailers" :value="retailer.id">{{ retailer.name }}</option>
                </select>
            </div>
            <div class="uk-width-1-3">
                <auto-complete v-model="variation" method="get" api-result-key="products"
                               :additional-data="{stock_id: retailer}"
                               api="/dashboard/r/search" placeholder="محصول"></auto-complete>
            </div>
            <div>
                <input type="number" class="uk-input uk-border-rounded" v-model="quantity">
            </div>
            <div>
                <button @click="addProduct"
                        class="uk-button uk-border-rounded uk-button-primary">افزودن به لیست
                </button>
            </div>
        </div>
        <div class="uk-margin-top">
            <h4 class="uk-text-bold">فاکتور</h4>
            <hr/>
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
                    <td>{{ item.quantity }}</td>
                    <td>{{ (item.quantity * item.discount).toLocaleString() }}</td>
                    <td>{{ (item.quantity * item.price).toLocaleString() }}</td>
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
        <div class="uk-margin-top uk-text-right">
            <button class="uk-button uk-button-secondary uk-border-rounded" @click="submit">ثبت فاکتور و چاپ</button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['retailers'],
    data() {
        return {
            retailer: this.retailers[0].id,
            variation: null,
            quantity: 1,
            items: [],
        }
    },
    methods: {
        addProduct() {
            this.items.push({
                id: this.variation.id,
                name: this.variation.name,
                sku: this.variation.sku,
                quantity: this.quantity,
                price: this.variation.orderPrice,
                discount: this.variation.price - this.variation.orderPrice,
                productName: this.variation.product.name,
            });
            this.variation = null;
            this.quantity = 1;
        },
        submit() {
            Loading.show();
            axios.post('/dashboard/r/invoice', {
                retailer_id: this.retailer,
                items: _.map(this.items, (i) => {
                    return {
                        id: i.id,
                        quantity: i.quantity,
                        price: i.price,
                        discount: i.discount,
                    }
                })
            }).then((response) => {
                window.location.href = `/dashboard/r/invoice/${response.data.id}`;
            }).catch((e) => Toast.message(e.response.data.message).danger().show()).then(() => Loading.hide());
        }
    },
    computed: {
        totalQuantity() {
            return _.sumBy(this.items, 'quantity');
        },
        totalPrice() {
            return _.sumBy(this.items, i => i.price * i.quantity);
        },
        totalDiscount() {
            return _.sumBy(this.items, i => i.discount * i.quantity);
        }
    }
}
</script>
