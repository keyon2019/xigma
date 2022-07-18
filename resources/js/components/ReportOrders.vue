<template>
    <paginated-view ref="pv" :manual="true" :single-page="true" data-key="rows">
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
                    <div class="uk-margin-small">
                        <select name="status" class="uk-select">
                            <option :value="null">وضعیت سفارش</option>
                            <option value="1">ثبت فاکتور</option>
                            <option value="2">بررسی سفارش</option>
                            <option value="3">آماده‌سازی</option>
                            <option value="4">ارسال شده</option>
                            <option value="5">لغو شده</option>
                        </select>
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
                    <th>مبلغ</th>
                    <th>وضعیت سفارش</th>
                    <th>زمان ثبت</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="order in scopeData.records">
                    <td class="uk-table-shrink">{{order.id}}</td>
                    <td>{{order.total.toLocaleString()}}</td>
                    <td>{{order.statusName}}</td>
                    <td>{{order.created_at}}</td>
                </tr>
                </tbody>
                <tfoot>
                    <tr class="uk-text-bold uk-background-muted-darker" v-if="scopeData.otherData.count">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>تعداد کل سفارشات: {{scopeData.otherData.count.toLocaleString()}}</td>
                    </tr>
                    <tr class="uk-text-bold uk-background-muted-darker" v-if="scopeData.otherData.sum">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>جمع مبلغ کل سفارشات: {{scopeData.otherData.sum.toLocaleString()}}</td>
                    </tr>
                </tfoot>
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