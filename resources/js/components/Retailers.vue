<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>
        <paginated-view :fetch-url="url">
            <template v-slot="scopeData">
                <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام نماینده</th>
                        <th>شهر</th>
                        <th>کاربر</th>
                        <th>محاسبه در الگوریتم</th>
                        <th>مدیریت</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="retailer in scopeData.records">
                        <td>{{retailer.id}}</td>
                        <td>{{retailer.name}}</td>
                        <td>{{retailer.city}}</td>
                        <td>{{retailer.user.name}}</td>
                        <td><span :data-uk-icon="retailer.available ? 'check': 'close'"></span></td>
                        <td>
                            <a :href="'/dashboard/retailer/' + retailer.id + '/edit'"
                               class="uk-button uk-button-small uk-button-text uk-text-primary">ویرایش</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </paginated-view>
    </div>
</template>

<script>
    export default {
        props: ['url']
    }
</script>

<style scoped>

</style>