<template>
    <paginated-view ref="pv" :fetch-url="fetchUrl">
        <template v-slot="scopeData">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-divider uk-margin-remove
            uk-table-middle uk-table-center uk-table-striped uk-background-default uk-border-rounded uk-box-shadow-small">
                    <thead>
                    <tr>
                        <th>امتیازات</th>
                        <th>تاریخ</th>
                        <th>میزان امتیاز</th>
                        <th>اعتبار تا</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="point in scopeData.records">
                        <td>{{point.description}}</td>
                        <td>{{point.created_at}}</td>
                        <td :class="point.amount >= 0 ? 'uk-text-success' : 'uk-text-danger'">{{point.amount}}</td>
                        <td>{{point.expires_at}}</td>
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
    }
</script>

<style scoped>

</style>