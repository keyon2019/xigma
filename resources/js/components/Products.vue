<template>
    <paginated-view>
        <template v-slot:filters>
            <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                <div class="uk-margin-remove">جستجو</div>
                <hr class="uk-margin-remove-top"/>
                <div>
                    <div class="uk-margin-small">
                        <label><input class="uk-checkbox" type="checkbox" value="1" name="available"> محصولات موجود </label>
                    </div>
                    <div>
                        <input type="text" name="keyword" class="uk-input uk-border-rounded" placeholder="نام محصول">
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
                    <th>عکس</th>
                    <th>نام</th>
                    <th>قیمت</th>
                    <th>قیمت قدیم</th>
                    <th>مدیریت</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in scopeData.records">
                    <td class="uk-table-shrink">{{product.id}}</td>
                    <td class="uk-table-shrink"><img class="uk-img" :src="product.splashUrl" alt=""></td>
                    <td>{{product.name}}</td>
                    <td>{{product.price.toLocaleString()}}</td>
                    <td>{{product.old_price.toLocaleString()}}</td>
                    <td><a :href="`/dashboard/product/${product.id}/edit`" class="uk-button uk-button-small uk-button-primary">ویرایش</a>
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
    }
</script>

<style scoped>

</style>