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
                    <th>شماره سفارش</th>
                    <th>زمان متوسط</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="shipping in scopeData.records">
                    <td>{{shipping.id}}</td>
                    <td>{{shipping.averageDays}} روز</td>
                </tr>
                </tbody>
                <tfoot>
                    <tr class="uk-text-bold uk-background-muted-darker" v-if="scopeData.otherData.average">
                        <td></td>
                        <td>متوسط کل: {{scopeData.otherData.average}} روز</td>
                    </tr>
                </tfoot>
            </table>
        </template>
    </paginated-view>
</template>

<script>
    export default {
        props: ['provinces'],
        data() {
            return {}
        },
    }
</script>

<style scoped>

</style>