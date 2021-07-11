<template>
    <paginated-view :fetch-url="fetchUrl">
        <template v-slot:filters>
            <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                <div class="uk-margin-remove">جستجو</div>
                <hr class="uk-margin-remove-top"/>
                <div>
                    <div>
                        <input name="keyword" class="uk-input uk-border-rounded" placeholder="نام فیلتر">
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
            <table class="uk-table uk-table-divider uk-table-middle uk-box-shadow-small uk-table-small
             uk-background-default uk-border-rounded">
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
                    <td v-if="!chooseList"><a :href="`/dashboard/option/${option.id}/edit`" class="uk-button uk-button-small uk-button-primary">ویرایش</a></td>
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