<template>
    <div v-if="!!this.$slots.default">
        <form @submit.prevent="apply()" data-uk-sticky="offset: 70;animation:uk-animation-slide-top;bottom:#paginated-view-content"
              ref="form" class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
            <div class="uk-margin-remove">جستجو</div>
            <hr class="uk-margin-remove-top"/>
            <div>
                <slot></slot>
                <div class="uk-margin-small-top">
                    <button @click="apply()"
                            class="uk-button uk-width-expand uk-button-primary uk-border-rounded"
                            type="button">اعمال فیلترها
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        methods: {
            apply() {
                let formData = new FormData(this.$refs.form);
                this.$emit('filtersChanged', formData);
            }
        }
    }
</script>

<style scoped>

</style>