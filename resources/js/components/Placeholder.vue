<template>
    <div class="uk-width-expand uk-background-muted uk-position-relative uk-background-secondary uk-border-rounded"
         style="padding-top:100%;">
        <div class="uk-position-absolute uk-position-center">
            <div class="uk-text-center">
                <span data-uk-icon="icon:image;ratio:2"></span>
                <p class="uk-text-small uk-margin-remove">
                    <slot></slot>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Placeholder"
    }
</script>

<style scoped>

</style>