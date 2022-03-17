<template>
    <div ref="modal" class="uk-flex-top" data-uk-modal="bg-close: false;stack:true">
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-text-center uk-border-rounded">
            <span class="uk-margin-right">لطفا چند لحظه صبر کنید</span>
            <span data-uk-spinner="ratio: 0.8"></span>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            Event.$on('show-loading-modal', () => {
                UIkit.modal(this.$refs.modal).show();
            });

            Event.$on('hide-loading-modal', () => {
                UIkit.modal(this.$refs.modal).hide();
            });
        }
    }
</script>

<style scoped>

</style>