<template>
    <div ref="modal" :id="name" class="uk-modal uk-flex-top" uk-modal="stack: true">
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-border-rounded uk-background-muted"
             :style="transparentDialog ? 'background: none !important' : ''" :uk-overflow-auto="overflow">
            <button style="left: unset;right: -10px;" v-if="close" class="uk-modal-close-outside" type="button" uk-close></button>
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            name,
            overflow: {
                default: false,
                type: Boolean,
            },
            transparentDialog: {
                default: false,
                type: Boolean
            },
            close: {
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