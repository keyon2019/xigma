<template>
    <paginated-view :fetch-url="fetchUrl">
        <template v-slot:filters>
            <div>
                <input name="keyword" class="uk-input" placeholder="نام فیلتر">
            </div>
        </template>
        <template v-slot="scopeData">
            <table class="uk-table uk-table-divider uk-table-striped uk-table-small uk-table-middle">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام فیلتر</th>
                    <th>مدیریت</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="option in scopeData.records">
                    <td class="uk-table-shrink">{{option.id}}</td>
                    <td>{{option.name}}</td>
                    <td v-if="!chooseList"><a class="uk-button uk-button-small uk-button-primary">ویرایش</a></td>
                    <td v-else><a class="uk-button uk-button-small uk-button-secondary"
                                  @click="$emit('chosen', option)">انتخاب</a></td>
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