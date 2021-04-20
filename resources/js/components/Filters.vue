<template>
    <div v-if="!!this.$slots.default">
        <form @submit.prevent="apply()"
              ref="form" class="uk-background-primary uk-box-shadow-small uk-padding uk-border-rounded uk-light">
            <div class="uk-margin-remove uk-text-large">جستجو</div>
            <hr class="uk-margin-remove-top"/>
            <div class="uk-grid uk-child-width-1-6 uk-grid-small" data-uk-grid>
                <slot></slot>
                <div>
                    <button @click="apply()"
                            class="uk-button uk-width-expand uk-button-primary"
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