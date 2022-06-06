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
            apply($event) {
                let formData = new FormData(this.$refs.form);
                if($event.submitter) {
                    formData.append($event.submitter.name, $event.submitter.value)
                }
                this.$emit('sortsChanged', formData);
            }
        }
    }
</script>

<style scoped>

</style>