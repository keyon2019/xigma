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
                        <label><input v-model="grouped" class="uk-checkbox" type="checkbox" value="1" name="grouped"> تجمیع بر اساس کاربر </label>
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
                    <th>میزان امتیاز</th>
                    <th>کاربر</th>
                    <th v-if="!grouped">زمان دریافت</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="point in scopeData.records">
                    <td>{{point.amount.toLocaleString()}}</td>
                    <td><a :href="'/dashboard/user/' + (point.user ? point.user.id : point.userId) + '/edit'">{{point.user ? point.user.name : point.userName}}</a></td>
                    <td v-if="!grouped">{{point.created_at}}</td>
                </tr>
                </tbody>
                <tfoot>
                <tr class="uk-text-bold uk-background-muted-darker" v-if="scopeData.otherData.sum">
                    <td></td>
                    <td v-if="!grouped"></td>
                    <td>جمع کل امتیازات دریافتی: {{scopeData.otherData.sum.toLocaleString()}}</td>
                </tr>
                </tfoot>
            </table>
        </template>
    </paginated-view>
</template>

<script>
    export default {
        data() {
            return {
                grouped: false,
            }
        },
    }
</script>

<style scoped>

</style>