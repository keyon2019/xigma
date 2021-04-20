<template>
    <div>
        <form @input="$emit('input', $event)" @submit.prevent>
            <fieldset class="uk-fieldset" :disabled="disabled">
                <slot></slot>
                <div class="uk-margin-top">
                    <button v-if="!disabled" class="uk-button" type="button"
                            :class="buttonClass ? buttonClass : 'uk-button-primary'"
                            @click="$emit('submit')">
                        {{buttonText ? buttonText : 'ثبت'}}
                    </button>
                </div>
            </fieldset>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['button-class', 'button-text', 'disabled'],
    }
</script>

<style scoped>

</style>