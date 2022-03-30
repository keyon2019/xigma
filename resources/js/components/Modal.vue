<template>
    <div ref="modal" class="uk-modal uk-flex-top">
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-border-rounded uk-background-muted" :style="transparentDialog ? 'background: none !important' : ''">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            name,
            transparentDialog: {
                default: false,
                type: Boolean
            }
        },
        mounted() {
            this.$on('escalate-selected', picture => {
                this.$emit('selected', picture);
            });
            Event.$on(`show-modal-${this.name}`, () => {
                UIkit.modal(this.$refs.modal).show();
            });
            Event.$on(`hide-modal-${this.name}`, () => {
                UIkit.modal(this.$refs.modal).hide();
            });
        },
        methods: {}
    }
</script>

<style scoped>

</style>