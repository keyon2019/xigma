<template>
    <paginated-view :fetch-url="fetchUrl" ref="pv">
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
                    <td>
                        <a :href="`/dashboard/page/${page.slug}/edit`"
                           class="uk-button uk-button-small uk-button-primary">ویرایش</a>
                        <button @click="deletePage(page)" class="uk-button uk-button-small uk-button-danger uk-margin-small-left">
                            حذف
                        </button>
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
            deletePage(page) {
                if (confirm("آیا از حذف صفحه اطمینان دارید؟")) {
                    Loading.show();
                    axios.post(`/dashboard/page/${page.slug}`, {_method: 'delete'}).then(() => {
                        this.$refs.pv.destroy(page.id);
                        Toast.message("صفحه با موفقیت حذف شد").success().show();
                    }).catch((e) => Toast.message(e.response.data.message).danger().show())
                        .then(() => Loading.hide());
                }
            }
        }
    }
</script>

<style scoped>

</style>