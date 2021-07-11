<template>
    <div v-if="!!this.$slots.default">
        <form @change="apply" @submit.prevent="apply"
              ref="form">
            <slot></slot>
        </form>
    </div>
</template>

<script>
    export default {
        methods: {
            apply() {
                let formData = new FormData(this.$refs.form);
                this.$emit('sortsChanged', formData);
            }
        }
    }
</script>

<style scoped>

</style>