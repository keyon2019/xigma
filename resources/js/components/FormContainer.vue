<template>
    <div>
        <form @input="$emit('input', $event)" @submit.prevent>
            <fieldset class="uk-fieldset" :class="{'uk-grid uk-grid-match uk-grid-small' : stacked}" :data-uk-grid="stacked" :disabled="disabled">
                <slot></slot>
                <div>
                    <div class="uk-form-label">&nbsp;</div>
                    <div class="uk-form-controls">
                        <button v-if="!disabled" class="uk-button" type="button"
                                :class="buttonClass ? buttonClass : 'uk-button-primary'"
                                @click="$emit('submit')">
                            {{buttonText ? buttonText : 'ثبت'}}
                        </button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['button-class', 'button-text', 'disabled', 'stacked'],
    }
</script>

<style scoped>

</style>