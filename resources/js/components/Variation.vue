<template>
    <div class="uk-padding uk-background-default uk-margin">
        <div class="uk-text-right">
            <span class="clickable" @click="isEditing = !isEditing" :data-uk-icon="isEditing ? 'unlock' : 'lock'"></span>
        </div>
        <hr/>
        <form-variation :pictures="pictures" :disabled="!isEditing" button-text="ویرایش" button-class="uk-button-secondary"
                        :variation="variation"></form-variation>
    </div>
</template>

<script>
    export default {
        props: ['variation', 'pictures'],
        data() {
            return {
                isEditing: false,
            }
        },
    }
</script>

<style scoped>

</style>