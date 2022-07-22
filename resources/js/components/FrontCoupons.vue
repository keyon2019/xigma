<template>
    <paginated-view ref="pv" :fetch-url="fetchUrl">
        <template v-slot="scopeData">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-divider uk-margin-remove
            uk-table-middle uk-table-center uk-table-striped uk-background-default uk-border-rounded uk-box-shadow-small">
                    <thead>
                    <tr>
                        <th>کد تخفیف</th>
                        <th>تاریخ</th>
                        <th>امتیاز استفاده شده</th>
                        <th>میزان تخفیف</th>
                        <th>وضعیت کد تخفیف</th>
                        <th>شماره سفارش</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="coupon in scopeData.records">
                        <td class="numeric-standard">{{coupon.code}}</td>
                        <td>{{coupon.created_at}}</td>
                        <td>{{coupon.points}}</td>
                        <td>{{coupon.discount.toLocaleString()}} تومان</td>
                        <td>{{coupon.status}}</td>
                        <td>{{coupon.order_id}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </paginated-view>
</template>

<script>
    export default {
        props: ['fetch-url'],
        methods: {
            add(coupon) {
                this.$refs.pv.add(coupon);
            }
        }
    }
</script>

<style scoped>

</style>