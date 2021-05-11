<template>
    <section class="uk-section uk-section-default uk-box-shadow-small uk-border-rounded"
             :class="variations.length > 0 ? 'uk-padding' : ''">
        <div v-if="variations.length <= 0" class="uk-text-center">
            در حال حاضر هیچ قطعه‌ای به محصول متصل نشده است
        </div>
        <div v-else class="uk-grid uk-grid-small uk-child-width-auto" data-uk-grid>
            <div v-for="variation in variations">
                <span class="uk-label uk-label-success"><span>{{variation.name + ' - ' + variation.filters}}<span @click="removeVariation(variation)"
                                                                                    class="clickable uk-margin-small-left"
                                                                                    data-uk-icon="icon:close;ratio:0.7"></span></span></span>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props: ['initial-variations'],
        data() {
            return {
                variations: this.initialVariations
            }
        },
        methods: {
            removeVariation(variation) {
                this.$emit('remove', variation);
            }
        }
    }
</script>

<style scoped>

</style>