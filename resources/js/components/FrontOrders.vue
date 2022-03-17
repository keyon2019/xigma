<template>
    <paginated-view @fetched="scroll" filterless="true">
        <template v-slot="scopeData">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
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
                        <td>{{order.total.toLocaleString()}}</td>
                        <td>{{order.paid ? 'پرداخت شده' : 'در انتظار پرداخت'}}</td>
                        <td>{{order.statusName}}</td>
                        <td>{{order.created_at}}</td>
                        <td><a :href="`/order/${order.id}`"
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
        props: ['category', 'options'],
        methods: {
            scroll() {
                this.$el.scrollIntoView({behavior: 'smooth'});
            }
        }
    }
</script>

<style scoped>
    .section-container {
        font-weight: 300;
        border-radius: 10px;
    }

    .custom-padding {
        padding: 0.5rem;
    }

    .uk-accordion-title:before {
        background-image: url('/uploads/chevron-down.svg');
        opacity: 0.5;
    }

    .uk-open > .uk-accordion-title::before {
        background-image: url('/uploads/chevron-up.svg');
        opacity: 1;
    }
</style>