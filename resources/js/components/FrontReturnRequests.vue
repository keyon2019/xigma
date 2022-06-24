<template>
    <paginated-view :fetch-url="fetchUrl" @fetched="scroll" filterless="true">
        <template v-slot="scopeData">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>وضعیت مرجوعی</th>
                        <th>زمان ثبت</th>
                        <th>کارشناس</th>
                        <th>مشاهده</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="returnRequest in scopeData.records">
                        <td class="uk-table-shrink">{{returnRequest.id}}</td>
                        <td>{{returnRequest.statusName}}</td>
                        <td>{{returnRequest.created_at}}</td>
                        <td>{{returnRequest.technician ? returnRequest.technician.name : 'در انتظار کارشناس'}}</td>
                        <td><a :href="`/return_request/${returnRequest.id}`"
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
        props: ['category', 'options', 'fetch-url', 'admin-panel'],
        methods: {
            scroll() {
                this.$el.scrollIntoView({behavior: 'smooth'});
            }
        }
    }
</script>