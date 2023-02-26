<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>
        <paginated-view ref="pv" :fetch-url="url">
            <template v-slot:filters>
                <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                    <div class="uk-margin-remove">فیلترهای گزارش</div>
                    <hr class="uk-margin-remove-top"/>
                    <div>
                        <div class="uk-margin-small">
                            <input class="uk-input uk-border-rounded from" name="from" placeholder="از تاریخ">
                            <date-picker-wrapper custom-input=".from" name="from"></date-picker-wrapper>
                        </div>
                        <div class="uk-margin-small">
                            <input class="uk-input uk-border-rounded to" name="to" placeholder="تا تاریخ">
                            <date-picker-wrapper custom-input=".to" name="to"></date-picker-wrapper>
                        </div>
                        <div class="uk-margin-small-top">
                            <button class="uk-button uk-width-expand uk-button-primary uk-border-rounded"
                                    type="submit">اعمال فیلترها
                            </button>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot="scopeData">
                <div class="uk-margin-small uk-padding-small uk-background-default uk-border-rounded uk-box-shadow-small">
                    <div class="uk-grid">
                        <div class="uk-width-1-3">
                            <auto-complete placeholder="محصول" v-model="variation" keyName="keyword"
                                           api="/dashboard/variation/search"></auto-complete>
                            <span class="uk-text-meta uk-margin-small-top" v-if="variation">{{variation.filters}}</span>
                        </div>
                        <div class="uk-width-1-3">
                            <input v-model="quantity" class="uk-input uk-border-rounded" placeholder="تعداد" type="number"
                                   min="1">
                        </div>
                        <div class="uk-width-1-3">
                            <button @click="submit()" class="uk-button uk-button-primary uk-border-rounded">افزودن</button>
                        </div>
                    </div>
                </div>
                <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>محصول</th>
                        <th>نوع</th>
                        <th>تعداد</th>
                        <th>زمان</th>
                        <th>موجودی کل</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="t in scopeData.records">
                        <td>{{t.id}}</td>
                        <td>{{t.variation.name}}</td>
                        <td>{{t.variation.filters}}</td>
                        <td>{{t.quantity}}</td>
                        <td>{{t.created_at}}</td>
                        <td>{{t.current_stock}}</td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </paginated-view>
    </div>
</template>

<script>
    export default {
        props: ['url'],
        data() {
            return {
                variation: null,
                quantity: null,
            }
        },
        methods: {
            submit() {
                if (this.variation != null && this.quantity > 0) {
                    Loading.show();
                    axios.post('/dashboard/stock_transaction', {
                        variation_id: this.variation.id,
                        quantity: this.quantity
                    }).then((response) => {
                        this.$refs.pv.add(response.data);
                        Toast.message('تراکنش انبار با موفقیت ثبت شد').success().show();
                    }).catch((e) => Toast.message(e.response.data.message).danger().show())
                        .then(() => Loading.hide());
                }
            }
        }
    }
</script>

<style scoped>

</style>
