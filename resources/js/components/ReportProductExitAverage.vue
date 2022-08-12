<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <paginated-view ref="pv" :manual="true" :single-page="true">
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
            <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام محصول</th>
                    <th>سریال</th>
                    <th>نوع</th>
                    <th>نرخ خروج</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in scopeData.records.rows">
                    <td class="uk-table-shrink">{{product.id}}</td>
                    <td>{{product.productName}}</td>
                    <td>{{product.sku}}</td>
                    <td>{{product.name}}</td>
                    <td>{{product.exit_average}}</td>
                </tr>
                </tbody>
            </table>
        </template>
    </paginated-view>
</template>

<script>
    export default {
        data() {
            return {}
        },
    }
</script>

<style scoped>

</style>