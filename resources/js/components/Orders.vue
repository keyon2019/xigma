<template>
    <paginated-view>
        <template v-slot:filters>
            <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                <div class="uk-margin-remove">جستجو</div>
                <hr class="uk-margin-remove-top"/>
                <div>
                    <div class="uk-margin-small">
                        <input type="text" name="user_name" class="uk-input uk-border-rounded" placeholder="نام کاربر">
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
                    <th>وضعیت پرداخت</th>
                    <th>وضعیت سفارش</th>
                    <th>زمان ثبت</th>
                    <th>مشاهده</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="order in scopeData.records">
                    <td class="uk-table-shrink">{{order.id}}</td>
                    <td class="uk-table-shrink">{{order.user.name}}</td>
                    <td>{{order.total.toLocaleString()}}</td>
                    <td>{{order.paid ? 'پرداخت شده' : 'در انتظار پرداخت'}}</td>
                    <td>{{order.statusName}}</td>
                    <td>{{order.created_at}}</td>
                    <td><a :href="`/dashboard/order/${order.id}/edit`" class="uk-button uk-button-small uk-button-primary">نمایش</a>
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