<template>
    <paginated-view ref="pv" :manual="true" :single-page="true" data-key="rows">
        <template v-slot="scopeData">
            <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                <thead>
                <tr>
                    <th>تصویر</th>
                    <th>محصول</th>
                    <th>سریال</th>
                    <th>نوع</th>
                    <th>تعداد</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="data in scopeData.records">
                    <td><img uk-img width="50" :src="data.variation.product.splashUrl"></td>
                    <td>{{data.variation.product.name}}</td>
                    <td>{{data.variation.sku}}</td>
                    <td>{{data.variation.filters}}</td>
                    <td>{{data.count}}</td>
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