<template>
    <div>
        <user-vehicles class="uk-margin-bottom" @remove="removeVehicle" :initial-vehicles="vehicles"></user-vehicles>
        <paginated-view :fetch-url="fetchUrl">
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
                                    type="submit">جستجو
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
                        <th>نام وسیله نقلیه</th>
                        <th>مدیریت</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="vehicle in scopeData.records">
                        <td class="uk-table-shrink">{{vehicle.id}}</td>
                        <td>{{vehicle.name}}</td>
                        <td><a class="uk-button uk-button-small uk-button-secondary"
                               @click="chosen(vehicle)">انتخاب</a></td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </paginated-view>
    </div>
</template>

<script>
    import UserVehicles from "./UserVehicles";

    export default {
        components: {UserVehicles},
        props: ['fetch-url', 'choose-list', 'user-vehicles'],
        data() {
            return {
                vehicles: this.userVehicles
            }
        },
        methods: {
            removeVehicle(vehicle) {
                Loading.show();
                axios.post(`/vehicle`, {vehicle_id: vehicle.id, _method: 'delete'})
                    .then(() => {
                        const oIndex = _.findIndex(this.vehicles, o => o.id === vehicle.id);
                        this.vehicles.splice(oIndex, 1);
                        Toast.message("وسیله نقلیه با موفقیت حذف شد").success().show();
                    }).catch(() => Toast.message("خطا در حذف وسیله نقلیه").danger().show()).then(() => Loading.hide());
            },
            chosen(vehicle) {
                if (_.findIndex(this.vehicles, v => v.id === vehicle.id) >= 0) {
                    UIkit.modal.alert('وسیله نقلیه قبلا افزوده شده است');
                    return;
                }
                Loading.show();
                axios.post(`/vehicle`, {vehicle_id: vehicle.id}).then(() => {
                    this.vehicles.unshift(vehicle);
                    Toast.message('وسیله نقلیه جدید اضافه شد').success().show();
                }).catch(() => {
                    Toast.message("خطا در افزودن وسیله نقلیه").danger().show();
                }).then(() => Loading.close());
            }
        }
    }
</script>

<style scoped>

</style>