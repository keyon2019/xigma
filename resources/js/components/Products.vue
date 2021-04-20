<template>
    <paginated-view>
        <template v-slot:filters>
            <div>
                <input name="keyword" class="uk-input" placeholder="نام محصول">
            </div>
        </template>
        <template v-slot="scopeData">
            <table class="uk-table uk-table-divider uk-table-striped uk-table-small uk-table-middle">
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
                    <td class="uk-table-shrink"><img class="uk-img" :src="'/' + product.splashPath" alt=""></td>
                    <td>{{product.name}}</td>
                    <td>{{product.price}}</td>
                    <td>{{product.old_price}}</td>
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