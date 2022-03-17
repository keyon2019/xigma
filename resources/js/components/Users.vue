<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>
        <paginated-view :fetch-url="url">
            <template v-slot:filters>
                <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                    <div class="uk-margin-remove">جستجو</div>
                    <hr class="uk-margin-remove-top"/>
                    <div>
                        <div class="uk-margin-small">
                            <input type="text" name="search" class="uk-input uk-border-rounded" placeholder="جستجوی کاربر">
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
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>تاریخ عضویت</th>
                        <th>نماینده</th>
                        <th>مدیریت</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in scopeData.records">
                        <td>{{user.id}}</td>
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td>{{user.created_at}}</td>
                        <td><span :data-uk-icon="user.is_retailer ? 'check': 'close'"></span></td>
                        <td>
                            <a :href="'/dashboard/user/' + user.id + '/edit'"
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