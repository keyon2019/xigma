<template>
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
                    <th>محصول</th>
                    <th>نوع</th>
                    <th>مجموع تعداد</th>
                    <th>مبلغ کل</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="rq in scopeData.records">
                    <td>{{rq.productName}}</td>
                    <td>{{rq.name}}</td>
                    <td>{{rq.totalQuantity}}</td>
                    <td>{{parseInt(rq.totalPrice).toLocaleString()}}</td>
                </tr>
                </tbody>
            </table>
        </template>
    </paginated-view>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
    }
</script>

<style scoped>

</style>