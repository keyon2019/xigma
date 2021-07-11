<template>
    <paginated-view>
        <template v-slot:filters>
            <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                <div class="uk-margin-remove">جستجو</div>
                <hr class="uk-margin-remove-top"/>
                <div>
                    <div>
                        <input name="keyword" class="uk-input uk-border-rounded" placeholder="نام وسیله نقلیه">
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
                    <th>مدیریت</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="vehicle in scopeData.records">
                    <td class="uk-table-shrink">{{vehicle.id}}</td>
                    <td class="uk-table-shrink"><img class="uk-img" :src="vehicle.splashUrl" alt=""></td>
                    <td>{{vehicle.name}}</td>
                    <td><a :href="`/dashboard/vehicle/${vehicle.id}/edit`" class="uk-button uk-button-small uk-button-primary">ویرایش</a>
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