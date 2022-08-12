<template>
    <paginated-view>
        <!--<template v-slot:filters>-->
            <!--<div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">-->
                <!--<div class="uk-margin-remove">جستجو</div>-->
                <!--<hr class="uk-margin-remove-top"/>-->
                <!--<div>-->
                    <!--<div class="uk-margin-small">-->
                        <!--<input type="text" name="name" class="uk-input uk-border-rounded" placeholder="نام کاربر">-->
                    <!--</div>-->
                    <!--<div class="uk-margin-small">-->
                        <!--<input class="uk-input" id="created_at" name="created_at"-->
                               <!--:value="$refs.dp ? $refs.dp.displayValue : ''" placeholder="زمان ثبت">-->
                        <!--</input>-->
                        <!--<date-picker type="date" ref="dp" element="created_at"></date-picker>-->
                    <!--</div>-->
                    <!--<div class="uk-margin-small">-->
                        <!--<select name="status" class="uk-select">-->
                            <!--<option :value="null">انتخاب کنید</option>-->
                            <!--<option value="1">ثبت فاکتور</option>-->
                            <!--<option value="2">بررسی سفارش</option>-->
                            <!--<option value="3">آماده‌سازی</option>-->
                            <!--<option value="4">ارسال شده</option>-->
                            <!--<option value="5">لغو شده</option>-->
                        <!--</select>-->
                    <!--</div>-->
                    <!--<div class="uk-margin-small">-->
                        <!--<input type="text" name="userMobile" class="uk-input uk-border-rounded" placeholder="موبایل">-->
                    <!--</div>-->
                    <!--<div class="uk-margin-small-top">-->
                        <!--<button class="uk-button uk-width-expand uk-button-primary uk-border-rounded"-->
                                <!--type="submit">اعمال فیلترها-->
                        <!--</button>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
        <!--</template>-->
        <template v-slot="scopeData">
            <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>شماره تماس</th>
                    <th>عنوان</th>
                    <th>متن پیام</th>
                    <th>زمان ثبت</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="contact in scopeData.records">
                    <td class="uk-table-shrink">{{contact.id}}</td>
                    <td class="">{{contact.name}}</td>
                    <td class="">{{contact.mobile}}</td>
                    <td>{{contact.title}}</td>
                    <td>{{contact.content}}</td>
                    <td>{{contact.created_at}}</td>
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