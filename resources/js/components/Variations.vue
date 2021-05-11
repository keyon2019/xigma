<template>
    <paginated-view :fetch-url="fetchUrl">
        <template v-slot:filters>
            <div>
                <input name="product_name" class="uk-input uk-border-rounded" placeholder="نام قطعه">
            </div>
        </template>
        <template v-slot="scopeData">
            <table class="uk-table uk-table-divider uk-table-middle uk-box-shadow-small uk-table-small
             uk-background-default uk-border-rounded">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام محصول</th>
                    <th>نوع</th>
                    <th>فیلترها</th>
                    <th>مدیریت</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="variation in scopeData.records">
                    <td class="uk-table-shrink">{{variation.id}}</td>
                    <td>{{variation.product.name}}</td>
                    <td>{{variation.name}}</td>
                    <td>{{variation.filters}}</td>
                    <td v-if="!chooseList"><a :href="`/dashboard/variation/${variation.id}/edit`"
                                              class="uk-button uk-button-small uk-button-primary">ویرایش</a></td>
                    <td v-else><a class="uk-button uk-button-small uk-button-secondary"
                                  @click="$emit('chosen', variation)">انتخاب</a></td>
                </tr>
                </tbody>
            </table>
        </template>
    </paginated-view>
</template>

<script>
    export default {
        props: ['fetch-url', 'choose-list']
    }
</script>

<style scoped>

</style>