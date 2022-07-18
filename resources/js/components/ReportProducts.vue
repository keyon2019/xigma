<template>
    <paginated-view ref="pv" :manual="true" :single-page="true">
        <template v-slot:filters>
            <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                <div class="uk-margin-remove">فیلترهای گزارش</div>
                <hr class="uk-margin-remove-top"/>
                <div>
                    <div class="uk-margin-small">
                        <label><input class="uk-radio" type="radio" value="1" name="desc"> پرفروش‌ترین</label>
                        <label><input class="uk-radio" type="radio" value="" name="desc" checked> کم فروش‌ترین</label>
                    </div>
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
                    <th>نوع</th>
                    <th>تعداد فروش</th>
                    <th>مبلغ فروش</th>
                    <th>امتیاز دریافتی</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in scopeData.records">
                    <td class="uk-table-shrink">{{product.id}}</td>
                    <td>{{product.productName}}</td>
                    <td>{{product.name}}</td>
                    <td>{{product.totalQuantity.toLocaleString()}}</td>
                    <td>{{parseInt(product.totalSold).toLocaleString()}}</td>
                    <td>{{parseInt(product.totalPoints).toLocaleString()}}</td>
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