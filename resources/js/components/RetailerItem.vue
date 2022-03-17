<template>
    <div>
        <div class="uk-grid uk-flex uk-flex-bottom">
            <div class="uk-width-expand">
                <label class="uk-form-label">بارکد یکتا</label>
                <div class="uk-from-controls">
                    <div class="uk-inline">
                        <a class="uk-form-icon uk-form-icon-flip" @click="findItem" uk-icon="check"></a>
                        <input @keyup.enter="findItem()" class="uk-input" type="text" placeholder="بارکد" v-model="barcode">
                    </div>
                </div>
            </div>
            <div>
                <button :disabled="items.length <= 0" class="uk-button uk-button-secondary" @click="selectRetailer()">ارسال به
                </button>
            </div>
        </div>
        <div class="uk-margin-small">
            <label><input class="uk-checkbox" type="checkbox" v-model="accumulated"> نمایش تجمیعی </label>
        </div>
        <table class="uk-table uk-table-divider uk-table-small uk-margin-small-top
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
            <thead>
            <tr>
                <td>#</td>
                <td>نام محصول</td>
                <td>نوع</td>
                <td v-if="!accumulated">بارکد</td>
                <td v-else>تعداد</td>
                <td v-if="!accumulated">مدیریت</td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item,index) in filteredItems">
                <td v-text="index + 1"></td>
                <td>{{item.variation.name}}</td>
                <td>{{item.variation.filters}}</td>
                <td v-if="!accumulated">{{item.barcode}}</td>
                <td v-else="accumulated">{{item.quantity}}</td>
                <td v-if="!accumulated"><a data-uk-icon="close" @click="removeItem(index)" class="uk-text-danger"></a></td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <th colspan="3">تعداد کل اقلام</th>
                <th v-text="items.length"></th>
                <th></th>
            </tr>
            </tfoot>
        </table>
        <modal name="retailer">
            <h3>لطفا نمایندگی مورد نظر را انتخاب فرمایید</h3>
            <hr/>
            <auto-complete v-model="selectedRetailer" value-key="id" api-result-key="retailers" method="post"
                           api="/dashboard/retailer/search" placeholder="نمایندگی"></auto-complete>
            <button class="uk-margin-top uk-button uk-button-small uk-width-expand uk-button-primary uk-border-rounded"
                    @click="submit">ثبت
            </button>
        </modal>
    </div>
</template>

<script>
    export default {
        name: "RetailerItem",
        data() {
            return {
                barcode: '',
                items: [],
                accumulated: false,
                modal: new Modal('retailer'),
                selectedRetailer: null
            }
        },
        methods: {
            selectRetailer() {
                this.modal.show();
            },
            findItem() {
                if (this.barcode === '')
                    return;
                if (_.findIndex(this.items, i => i.barcode === this.barcode) > -1) {
                    Toast.message("محصول قبلا اضافه شده است").danger().show();
                    return;
                }
                Loading.show();
                axios.post(`/dashboard/item/find`, {barcode: this.barcode})
                    .then((response) => {
                        this.items.push(response.data.item);
                        this.barcode = '';
                    }).catch((e) => Toast.message(e.response.data.message).danger().show())
                    .then(() => Loading.hide());
            },
            removeItem(index) {
                this.items.splice(index, 1);
            },
            submit() {
                Loading.show();
                axios.post(`/dashboard/retailer/item`, {
                    items: _.map(this.items, 'id'),
                    stock_id: this.selectedRetailer
                }).then(() => {
                    this.items = [];
                    this.selectedRetailer = null;
                    Loading.hide();
                    Toast.message("ثبت مرسوله با موفقیت انجام شد").success().show();
                }).catch((e) => Toast.message(e.response.data.message).danger().show())
            },

        },
        computed: {
            filteredItems() {
                if (!this.accumulated)
                    return this.items;
                return _.chain(this.items).groupBy('variation_id').map((g) => {
                    return {
                        variation: g[0].variation,
                        quantity: g.length
                    }
                }).value();
            }
        }
    }
</script>

<style scoped>

</style>