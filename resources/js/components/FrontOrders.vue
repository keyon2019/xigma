<template>
    <paginated-view :fetch-url="fetchUrl" @fetched="scroll" filterless="true">
        <template v-slot="scopeData">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>زمان ثبت</th>
                        <th>مبلغ</th>
                        <th>وضعیت سفارش</th>
                        <th>مشاهده</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="order in scopeData.records">
                        <td class="uk-table-shrink">{{order.id}}</td>
                        <td>{{order.created_at}}</td>
                        <td>{{order.total.toLocaleString()}}</td>
                        <td>{{order.statusName}}</td>
                        <td><a v-if="!adminPanel" :href="`/order/${order.id}`"
                               class="uk-button uk-button-small uk-button-primary">نمایش</a>
                            <a v-else :href="`/dashboard/order/${order.id}/edit`"
                               class="uk-button uk-button-small uk-button-primary">نمایش</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </paginated-view>
</template>

<script>
    export default {
        props: ['category', 'options', 'fetch-url', 'admin-panel'],
        methods: {
            scroll() {
                this.$el.scrollIntoView({behavior: 'smooth'});
            }
        }
    }
</script>