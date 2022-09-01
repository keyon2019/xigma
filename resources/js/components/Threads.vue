<template>
    <paginated-view>
        <template v-if="isAdmin" v-slot:filters>
            <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                <div class="uk-margin-remove">جستجو</div>
                <hr class="uk-margin-remove-top"/>
                <div>
                    <div class="uk-margin-small">
                        <input type="text" name="userName" class="uk-input uk-border-rounded" placeholder="نام کاربر">
                    </div>
                    <div class="uk-margin-small">
                        <input type="text" name="userMobile" class="uk-input uk-border-rounded" placeholder="موبایل">
                    </div>
                    <div class="uk-margin-small">
                        <select name="seen" class="uk-select">
                            <option value="">همه</option>
                            <option value="1">دیده شده</option>
                            <option value="0">دیده نشده</option>
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
            <div v-if="isAdmin" class="uk-margin-small-bottom">
                <a href="/dashboard/thread/create" class="uk-button uk-border-rounded uk-button-primary">ارسال پیغام جدید</a>
                <a href="/dashboard/thread/bulk" class="uk-button uk-border-rounded uk-button-primary">ارسال پیغام گروهی جدید</a>
            </div>
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                    <thead>
                    <tr>
                        <th v-if="isAdmin">کاربر</th>
                        <th v-if="isAdmin">موبایل</th>
                        <th>موضوع</th>
                        <th>وضعیت پیام</th>
                        <th>زمان آخرین پیغام</th>
                        <th>جزئیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="thread in scopeData.records">
                        <td v-if="isAdmin" class="">{{thread.user.name}}</td>
                        <td v-if="isAdmin">{{thread.user.mobile}}</td>
                        <td>{{thread.title}}</td>
                        <td :class="thread.seen ? '' : 'uk-text-danger'">{{thread.seen ? 'دیده شده' : 'دیده نشده'}}</td>
                        <td>{{thread.updated_at}}</td>
                        <td><a :href="isAdmin ? `/dashboard/thread/${thread.id}/edit` : `/thread/${thread.id}`"
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
        props: {
          'is-admin': {
              default: true,
          }
        },
        data() {
            return {}
        },
    }
</script>

<style scoped>

</style>