<template>
    <section class="uk-section uk-section-default uk-box-shadow-small uk-border-rounded"
             :class="vehicles.length > 0 ? 'uk-padding' : ''">
        <div v-if="vehicles.length <= 0" class="uk-text-center">
            شما در حال حاضر هیچ وسیله‌ای نقلیه‌ای انتخاب نکرده‌اید
        </div>
        <div v-else class="uk-grid uk-grid-small uk-child-width-auto" data-uk-grid>
            <div v-for="vehicle in vehicles">
                <span class="uk-label uk-label-danger"><span>{{vehicle.name}}<span @click="removeVehicle(vehicle)"
                                                                                  class="clickable uk-margin-small-left"
                                                                                  data-uk-icon="icon:close;ratio:0.7"></span></span></span>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props: ['initial-vehicles'],
        data() {
            return {
                vehicles: this.initialVehicles
            }
        },
        methods: {
            removeVehicle(vehicle) {

                this.$emit('remove', vehicle);
            }
        }
    }
</script>

<style scoped>

</style>