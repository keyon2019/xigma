<template>
    <paginated-view>
        <template v-slot:filters>
            <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                <div class="uk-margin-remove">جستجو</div>
                <hr class="uk-margin-remove-top"/>
                <div>
                    <div class="uk-margin-small">
                        <input type="text" name="name" class="uk-input uk-border-rounded" placeholder="نام کاربر">
                    </div>
                    <div class="uk-margin-small">
                        <input type="text" name="userMobile" class="uk-input uk-border-rounded" placeholder="موبایل">
                    </div>
                    <div class="uk-margin-small">
                        <select name="status" class="uk-select">
                            <option :value="null">وضعیت مرجوعی</option>
                            <option v-for="(status,index) in statuses" :value="index">{{status}}</option>
                        </select>
                    </div>
                    <div class="uk-margin-small-top">
                        <button class="uk-button uk-width-expand uk-button-primary uk-border-rounded"
                                type="submit">اعمال فیلترها
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot="scopeData">
            <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                <thead>
                <tr>
                    <th>#</th>
                    <th>کاربر</th>
                    <th>موبایل</th>
                    <th>وضعیت مرجوعی</th>
                    <th>زمان ثبت</th>
                    <th>جزئیات</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="return_request in scopeData.records">
                    <td class="uk-table-shrink">{{return_request.id}}</td>
                    <td class="uk-table-shrink">{{return_request.user.name}}</td>
                    <td>{{return_request.user.mobile}}</td>
                    <td>{{return_request.statusName}}</td>
                    <td>{{return_request.created_at}}</td>
                    <td><a :href="`/dashboard/return_request/${return_request.id}/edit`"
                           class="uk-button uk-button-small uk-button-primary">نمایش</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </template>
    </paginated-view>
</template>

<script>
    export default {
        props: ['statuses'],
        data() {
            return {}
        },
    }
</script>

<style scoped>

</style>