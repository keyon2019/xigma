<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>
        <paginated-view :fetch-url="fetchUrl">
            <template v-slot:sort>
                <div class="uk-background-default uk-text-small uk-margin-small-bottom uk-padding-small uk-border-rounded uk-box-shadow-small">
                    <span class="uk-text-bold">ترتیب نمایش:</span>
                    <div class="uk-margin-small-left uk-inline clickable uk-text-light uk-width-small">
                        <div data-uk-form-custom="target:true">
                            <select name="orderBy">
                                <option selected :value="null" disabled>پیش‌فرض</option>
                                <option value="items_count.desc">بیشترین موجودی</option>
                                <option value="items_count">کمترین موجودی</option>
                            </select>
                            <span></span>
                            <span><i data-uk-icon="icon:chevron-down"></i></span>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:filters>
                <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                    <div class="uk-margin-remove">جستجو</div>
                    <hr class="uk-margin-remove-top"/>
                    <div>
                        <div class="uk-margin-small">
                            <input type="text" name="keyword" class="uk-input uk-border-rounded" placeholder="نام محصول">
                        </div>
                        <div>
                            <input type="text" name="sku" class="uk-input uk-border-rounded" placeholder="سریال">
                        </div>
                        <div>
                            <accordion title="دسته‌بندی" class="uk-margin-small-top">
                                <template v-for="category in categories" class="uk-list uk-list-hyphen">
                                    <accordion class="uk-margin-top">
                                        <template v-slot:title>
                                            <label class="uk-margin-small-left"><input name="categories[]" class="uk-checkbox"
                                                                                       type="checkbox"
                                                                                       :value="category.id">
                                                {{category.name}}</label>
                                        </template>
                                        <template v-for="sCategory in category.sub_categories" class="uk-list uk-list-hyphen">
                                            <accordion class="uk-margin-small-top">
                                                <template v-slot:title>
                                                    <label class="uk-margin-left"><input name="categories[]" class="uk-checkbox"
                                                                                         type="checkbox"
                                                                                         :value="sCategory.id">
                                                        {{sCategory.name}}</label>
                                                </template>
                                                <template v-for="ssCategory in sCategory.sub_categories"
                                                          class="uk-list uk-list-hyphen">
                                                    <div class="uk-margin-small-top">
                                                        <label class="uk-margin-large-left"><input name="categories[]"
                                                                                                   class="uk-checkbox"
                                                                                                   type="checkbox"
                                                                                                   :value="ssCategory.id">
                                                            {{ssCategory.name}}</label>
                                                    </div>
                                                </template>
                                            </accordion>
                                        </template>
                                    </accordion>
                                </template>
                            </accordion>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot="scopeData">
                <table class="uk-table uk-table-divider uk-table-middle uk-box-shadow-small uk-table-small
             uk-background-default uk-border-rounded">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام محصول</th>
                        <th>سریال</th>
                        <th>نوع</th>
                        <th>فیلترها</th>
                        <th>موجودی</th>
                        <th>مدیریت</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="variation in scopeData.records">
                        <td class="uk-table-shrink">{{variation.id}}</td>
                        <td>{{variation.product.name}}</td>
                        <td>{{variation.sku}}</td>
                        <td>{{variation.name}}</td>
                        <td>{{variation.filters}}</td>
                        <td>{{variation.items_count}}</td>
                        <td v-if="!chooseList">
                            <button @click="showStockModal(variation)" class="uk-button uk-button-small uk-button-secondary">
                                مدیریت
                                موجودی
                            </button>
                        </td>
                        <td v-else><a class="uk-button uk-button-small uk-button-secondary"
                                      @click="$emit('chosen', variation)">انتخاب</a></td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </paginated-view>
        <modal name="stocksModal">
            <template v-if="selectedVariation">
                <h3 class="uk-margin-small-bottom">موجودی {{selectedVariation.name}}</h3>
                <hr class="uk-margin-small"/>
                <table
                        class="uk-table uk-table-divider uk-background-default uk-border-rounded uk-table-small uk-table-middle">
                    <tbody>
                    <template v-if="supply[selectedVariation.id] !== undefined">
                        <tr v-for="(stock,index) in supply[selectedVariation.id]">
                            <td>{{stock.name}}</td>
                            <td>
                                <div class="uk-flex uk-flex-middle">
                                    <input :disabled="!stock.editing"
                                           class="uk-input uk-border-rounded uk-width-expand uk-margin-small-right"
                                           v-model="stock.quantity" type="number">
                                    <a @click="update(index)"
                                       class="uk-icon-link"
                                       :uk-icon="stock.editing ? 'check' : 'pencil'"></a>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr>
                        <td>
                            <auto-complete v-model="form.retailer.value" api-result-key="retailers" method="post"
                                           api="/dashboard/retailer/search" placeholder="نمایندگی (برای کارخانه خالی بگذارید)"></auto-complete>
                        </td>
                        <td class="uk-width-small">
                            <div class="uk-flex uk-flex-middle">
                                <input class="uk-input uk-border-rounded uk-width-expand uk-margin-small-right"
                                       v-model="form.quantity.value" placeholder="موجودی اولیه" type="number">
                                <a @click="addRetailer()"
                                   class="uk-icon-link"
                                   uk-icon="check"></a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </modal>
    </div>
</template>

<script>
    import Accordion from "./Accordion";

    export default {
        components: {Accordion},
        props: ['fetch-url', 'choose-list', 'categories'],
        data() {
            return {
                selectedVariation: null,
                stocksModal: new Modal('stocksModal'),
                supply: [],
                form: new Form({
                    retailer: {
                        rules: 'nullable|numeric',
                        value: null,
                    },
                    quantity: {
                        rules: 'required|numeric',
                        value: null,
                    },
                })
            }
        },
        mounted() {

        },
        methods: {
            showStockModal(variation) {
                this.selectedVariation = variation;
                if (this.supply[variation.id] == null) {
                    Loading.show();
                    axios.get(`/stock?variation_id=${variation.id}`).then((response) => {
                        this.supply[variation.id] = response.data;
                        this.stocksModal.show();
                        this.$forceUpdate();
                    }).catch((e) => Toast.message(e.response.data.message).danger().show())
                        .then(() => Loading.hide());
                } else {
                    this.stocksModal.show();
                }
            },
            update(index) {
                const stock = this.supply[this.selectedVariation.id][index];
                this.$set(this.supply[this.selectedVariation.id][index], 'editing', !stock.editing);
                if (!stock.editing) {
                    Loading.show();
                    axios.post(`/dashboard/stock/${this.selectedVariation.id}`, {
                        retailer_id: stock.retailer_id,
                        quantity: stock.quantity
                    }).then(() => {
                        Toast.message("موجودی با موفقیت ویرایش شد").success().show();
                    }).catch((e) => Toast.message(e.response.data.message).danger().show()).then(() => {
                        Loading.hide();
                    });
                }
                this.$forceUpdate();
            },
            addRetailer() {
                Loading.show();
                axios.post(`/dashboard/stock/${this.selectedVariation.id}`, {
                    retailer_id: this.form.retailer.value ? this.form.retailer.value.id : null,
                    quantity: this.form.quantity.value
                }).then(() => {
                    Toast.message("موجودی با موفقیت اضافه شد").success().show();
                    this.supply[this.selectedVariation.id].push(
                        {
                            retailer_id: this.form.retailer.value ? this.form.retailer.value.id : null,
                            name: this.form.retailer.value ? this.form.retailer.value.name : 'کارخانه',
                            quantity: this.form.quantity.value
                        }
                    );
                    this.form.clear();
                }).catch((e) => Toast.message(e.response.data.message).danger().show()).then(() => {
                    Loading.hide();
                    this.$forceUpdate();
                });
            }
        }
    }
</script>

<style scoped>

</style>