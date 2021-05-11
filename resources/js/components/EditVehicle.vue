<template>
    <div class="uk-margin-top">
        <ul class="uk-tab uk-child-width-1-3"
            data-uk-switcher="animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium">
            <li><a href="#info">مشخصات</a></li>
            <li><a href="#categories">قطعات</a></li>
            <li><a href="#gallery">گالری</a></li>
        </ul>

        <div class="uk-switcher uk-margin">
            <div>
                <form-vehicle button-class="uk-button-secondary"
                              button-text="ویرایش" :vehicle="vehicle" @submit="updateVehicle"></form-vehicle>
            </div>
            <div>
                <vehicle-variations @remove="removeVariation" :initial-variations="vehicle.variations"
                                    class="uk-margin-bottom"></vehicle-variations>
                <variations @chosen="addVariation" fetch-url="/dashboard/variation" :choose-list="true"></variations>
            </div>
            <div>
                <upload-area url="/dashboard/picture" :id="vehicle.id" type="Vehicle"></upload-area>
                <gallery :initial-pictures="vehicle.pictures"></gallery>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['initial-vehicle'],
        data() {
            return {
                vehicle: this.initialVehicle,
                galleryModal: new Modal('gallery'),
            }
        },
        mounted() {
            Event.$on('picture-uploaded', (picture) => {
                this.vehicle.pictures.unshift(picture);
            })
        },
        methods: {
            updateVehicle(form) {
                Loading.show();
                axios.post(`/dashboard/vehicle/${this.vehicle.id}`, form.asFormData('patch')).then(() => {
                    Toast.message("وسیله نقلیه با موفقیت به روزرسانی شد").success().show();
                }).catch(() => {
                    Toast.message("خطا در بروزرسانی وسیله نقلیه").danger().show();
                }).then(() => {
                    Loading.hide();
                })
            },
            addVariation(variation) {
                Loading.show();
                axios.post(`/dashboard/vehicle/${this.vehicle.id}/variation`, {variation_id: variation.id}).then(() => {
                    this.vehicle.variations.unshift(variation);
                    Toast.message('قطعه جدید به وسیله نقلیه اضافه شد').success().show();
                }).catch(() => Toast.message('خطا در افزودن قطعه').danger().show()).then(() => Loading.hide());
            },
            removeVariation(variation) {
                Loading.show();
                axios.post(`/dashboard/vehicle/${this.vehicle.id}/variation`, {
                    variation_id: variation.id,
                    _method: 'delete'
                }).then(() => {
                    const vIndex = _.findIndex(this.vehicle.variations, v => v.id === variation.id);
                    this.vehicle.variations.splice(vIndex, 1);
                    Toast.message('قطعه با موفقیت از وسیله نقلیه حذف شد').success().show();
                }).catch(() => Toast.message('خطا در حذف قطعه').danger().show()).then(() => Loading.hide());

            },
        }
    }
</script>

<style scoped>

</style>