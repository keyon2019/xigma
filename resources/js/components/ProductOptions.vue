<template>
    <section class="uk-section uk-section-default uk-box-shadow-small uk-border-rounded"
             :class="options.length > 0 ? 'uk-padding' : ''">
        <div v-if="options.length <= 0" class="uk-text-center">
            در حال حاضر هیچ فیلتری به محصول متصل نشده است
        </div>
        <div v-else class="uk-grid uk-grid-small uk-child-width-auto" data-uk-grid>
            <div v-for="option in options">
                <span class="uk-label uk-label-danger">{{option.name}}</span></div>
        </div>
    </section>
</template>

<script>
    export default {
        props: ['initial-options'],
        data() {
            return {
                options: this.initialOptions
            }
        }
    }
</script>

<style scoped>

</style>