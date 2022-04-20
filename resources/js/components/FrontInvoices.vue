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
                        <th>زمان ثبت</th>
                        <th>مشاهده</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="invoice in scopeData.records">
                        <td class="uk-table-shrink">{{invoice.id}}</td>
                        <td>{{invoice.total.toLocaleString()}}</td>
                        <td>{{invoice.created_at}}</td>
                        <td><a :href="`/invoice/${invoice.id}`"
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