<template>
    <section class="uk-section uk-section-default uk-box-shadow-small uk-border-rounded"
             :class="categories.length > 0 ? 'uk-padding' : ''">
        <div v-if="categories.length <= 0" class="uk-text-center">
            در حال حاضر هیچ دسته بندی به محصول متصل نشده است
        </div>
        <div v-else class="uk-grid uk-grid-small uk-child-width-auto" data-uk-grid>
            <div v-for="category in categories">
                <span class="uk-label uk-label-success"><span>{{category.name}}<span @click="removeCategory(category)"
                                                                                    class="clickable uk-margin-small-left"
                                                                                    data-uk-icon="icon:close;ratio:0.7"></span></span></span>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props: ['initial-categories'],
        data() {
            return {
                categories: this.initialCategories
            }
        },
        methods: {
            removeCategory(category) {
                this.$emit('remove', category);
            }
        }
    }
</script>

<style scoped>

</style>