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
                        <input class="uk-input" id="created_at" name="created_at"
                               :value="$refs.dp ? $refs.dp.displayValue : ''" placeholder="زمان ثبت">
                        </input>
                        <date-picker type="date" ref="dp" element="created_at"></date-picker>
                    </div>
                    <div class="uk-margin-small">
                        <select name="status" class="uk-select">
                            <option :value="null">انتخاب کنید</option>
                            <option value="1">ثبت فاکتور</option>
                            <option value="2">بررسی سفارش</option>
                            <option value="3">آماده‌سازی</option>
                            <option value="4">ارسال شده</option>
                            <option value="5">لغو شده</option>
                        </select>
                    </div>
                    <div class="uk-margin-small">
                        <input type="text" name="userMobile" class="uk-input uk-border-rounded" placeholder="موبایل">
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
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>کاربر</th>
                        <th>موبایل</th>
                        <th>وضعیت سفارش</th>
                        <th>زمان ثبت</th>
                        <th>وضعیت ارسال</th>
                        <th>مشاهده</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="order in scopeData.records"
                        :class="$notifications.has('OrderPlaced', 'order_id', order.id) ? 'attention' : ''">
                        <td class="uk-table-shrink">{{order.id}}</td>
                        <td class="">{{order.user.name}}</td>
                        <td>{{order.receiver_number}}</td>
                        <td>{{order.statusName}}</td>
                        <td>{{order.created_at}}</td>
                        <td>{{order.sailed_at ? "ارسال شده" : 'ارسال نشده'}}</td>
                        <td><a :href="`/dashboard/r/order/${order.id}`"
                               class="uk-button uk-button-small uk-button-primary">نمایش</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </paginated-view>
</template>
