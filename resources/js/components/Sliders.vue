<template>
    <paginated-view ref="view" :filterless="true">
        <template v-slot="scopeData">
            <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عکس</th>
                    <th>تیتر</th>
                    <th>ترتیب نمایش</th>
                    <th>مدیریت</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="slider in scopeData.records">
                    <td class="uk-table-shrink">{{slider.id}}</td>
                    <td class="uk-table-shrink"><img class="uk-img uk-border-rounded uk-width-medium uk-preserve-width"
                                                     :src="slider.picture" alt=""></td>
                    <td>{{slider.title}}</td>
                    <td>{{slider.order}}</td>
                    <td>
                        <a :href="`/dashboard/slider/${slider.id}/edit`"
                           class="uk-button uk-border-rounded uk-button-small uk-button-primary">ویرایش</a>
                        <button @click="destroy(slider)"
                                class="uk-button uk-button-danger uk-button-small uk-border-rounded">حذف
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
        data() {
            return {}
        },
        methods: {
            destroy(slider) {
                Loading.show();
                axios.post(`/dashboard/slider/${slider.id}`, {'_method': 'delete'}).then(() => {
                    Toast.message("اسلایدر با موفقیت حذف شد").success().show();
                    this.$refs.view.destroy(slider.id);
                }).catch((e) => {
                    Toast.message(e.response.data.message).danger().show();
                }).then(() => {
                    Loading.hide();
                })

            }
        }
    }
</script>

<style scoped>

</style>