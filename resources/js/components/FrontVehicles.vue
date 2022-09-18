<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>
        <div class="uk-grid uk-flex uk-flex-middle uk-margin-top uk-padding">
            <div class="uk-width-1-4@m uk-flex uk-flex-middle uk-flex-start uk-flex-center@m uk-text-muted">
                افزودن <span @click="modal.show()" class="uk-margin-left uk-border-rounded uk-padding-small clickable"
                             style="border: 1px solid gainsboro"><i class="fa-solid fa-4x fa-plus"></i></span>
            </div>
            <div class="uk-width-expand">
                <div v-for="vehicle in vehicles" class="uk-flex uk-flex-middle uk-margin" style="justify-content: flex-end;">
                    <span v-text="vehicle.name"></span><span><img uk-img width="100"
                                                              class="uk-margin-left uk-margin-right uk-border-rounded"
                                                              :src="vehicle.splashUrl"></span><a @click="removeVehicle(vehicle)" class="uk-link-reset"><i
                        uk-icon="trash"></i></a>
                </div>
            </div>
        </div>
        <modal class="uk-modal-container" name="vehicle-modal">
            <h2>انتخاب وسیله نقلیه</h2>
            <hr/>
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
                                        type="submit">اعمال فیلترها
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-slot="scopeData">
                    <div class="uk-grid uk-grid-small uk-child-width-1-4@m uk-child-width-1-2" data-uk-grid>
                        <div v-for="vehicle in scopeData.records">
                            <div @click="chosen(vehicle)"
                                 class="uk-card uk-card-small uk-card-default clickable uk-border-rounded uk-overflow-hidden">
                                <div class="uk-card-media-top">
                                    <img :src="vehicle.splashUrl" width="800" height="800" :alt="vehicle.name">
                                </div>
                                <div class="uk-card-body">
                                    <p>{{vehicle.name}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </paginated-view>
        </modal>
    </div>
</template>

<script>
    import UserVehicles from "./UserVehicles";

    export default {
        components: {UserVehicles},
        props: ['fetch-url', 'choose-list', 'user-vehicles'],
        data() {
            return {
                vehicles: this.userVehicles,
                modal: new Modal('vehicle-modal')
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