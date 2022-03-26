<template>
    <paginated-view :fetch-url="fetchUrl">
        <template v-slot="scopeData">
            <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>slug</th>
                    <th>موقعیت</th>
                    <th>مدیریت</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="page in scopeData.records">
                    <td class="uk-table-shrink">{{page.id}}</td>
                    <td class="uk-table-shrink">{{page.name}}</td>
                    <td>{{page.slug}}</td>
                    <td>{{page.position}}</td>
                    <td><a :href="`/dashboard/page/${page.slug}/edit`" class="uk-button uk-button-small uk-button-primary">ویرایش</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </template>
    </paginated-view>
</template>

<script>
    export default {
        props: ['fetch-url', 'choose-list'],
        data() {
            return {
                treeView: false,
            }
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>