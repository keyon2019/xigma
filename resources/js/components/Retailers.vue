<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>
        <paginated-view ref="pv" :fetch-url="url">
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
                        <td>{{retailer.user ? retailer.user.name : 'بدون کاربر'}}</td>
                        <td><span :data-uk-icon="retailer.available ? 'check': 'close'"></span></td>
                        <td>
                            <a :href="'/dashboard/retailer/' + retailer.id + '/edit'"
                               class="uk-button uk-button-small uk-button-text uk-text-primary">ویرایش</a>
                            <a @click="removeRetailer(retailer)"
                               class="uk-button uk-button-small uk-button-text uk-text-danger">حذف</a>
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
        props: ['url'],
        methods: {
            removeRetailer(retailer) {
                if (confirm("آیا از حذف نماینده اطمینان دارید؟")) {
                    Loading.show();
                    axios.post(`/dashboard/retailer/${retailer.id}`, {_method: 'delete'}).then(() => {
                        this.$refs.pv.destroy(retailer.id);
                        Toast.message("نماینده با موفقیت حذف شد").success().show();
                    }).catch((e) => Toast.message(e.response.data.message).danger().show()).then(() => Loading.hide())
                }
            }
        }
    }
</script>

<style scoped>

</style>