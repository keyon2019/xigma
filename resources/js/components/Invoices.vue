<template>
    <paginated-view>
        <template v-slot:filters>
            <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                <div class="uk-margin-remove">جستجو</div>
                <hr class="uk-margin-remove-top"/>
                <div>
                    <div class="uk-margin-small">
                        <input class="uk-input" id="created_at" name="created_at"
                               :value="$refs.dp ? $refs.dp.displayValue : ''" placeholder="زمان ثبت">
                        </input>
                        <date-picker type="date" ref="dp" element="created_at"></date-picker>
                    </div>
                    <div class="uk-margin-small">
                        <input type="email" name="user_email" class="uk-input uk-border-rounded" placeholder="ایمیل کاربر">
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
                    <th>کاربر</th>
                    <th>مبلغ</th>
                    <th>زمان ثبت</th>
                    <th>مشاهده</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="invoice in scopeData.records">
                    <td class="uk-table-shrink">{{invoice.id}}</td>
                    <td class="uk-table-shrink">{{invoice.user.name}}</td>
                    <td>{{invoice.total.toLocaleString()}}</td>
                    <td>{{invoice.created_at}}</td>
                    <td><a :href="`/dashboard/invoice/${invoice.id}/edit`"
                           class="uk-button uk-button-small uk-button-primary">نمایش</a>
                    </td>
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