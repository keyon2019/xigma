<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>
        <div class="uk-background-default uk-margin uk-box-shadow-small uk-border-rounded">
            <div class="uk-padding">
                <h4 class="uk-margin-remove">ثبت تولیدات جدید</h4>
                <hr class="uk-margin-small uk-margin-remove-top"/>
                <create-item></create-item>
            </div>
        </div>
        <paginated-view :fetch-url="url">
            <template v-slot:sort>
                <div class="uk-background-default uk-text-small uk-margin-small-bottom uk-padding-small uk-border-rounded uk-box-shadow-small">
                    <span class="uk-text-bold">ترتیب نمایش:</span>
                    <div class="uk-margin-small-left uk-inline clickable uk-text-light uk-width-small">
                        <div data-uk-form-custom="target:true">
                            <select name="orderBy">
                                <option selected :value="null" disabled>پیش‌فرض</option>
                                <option value="created_at.desc">جدیدترین</option>
                                <option value="created_at">قدیمی‌ترین</option>
                            </select>
                            <span></span>
                            <span><i data-uk-icon="icon:chevron-down"></i></span>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot="scopeData">
                <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                    <thead>
                    <tr>
                        <th>سریال</th>
                        <th>تاریخ تولید</th>
                        <th>آخرین موقعیت</th>
                        <th>وضعیت</th>
                        <th>شماره سفارش</th>
                        <th>مدیریت</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in scopeData.records">
                        <td>{{item.barcode}}</td>
                        <td>{{item.created_at}}</td>
                        <td>{{item.stock != null ? item.stock.name : 'کارخانه'}}</td>
                        <td>{{item.sold ? 'فروخته شده' : 'موجود'}}</td>
                        <td>{{item.order_id}}</td>
                        <td>
                            مدیریت
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