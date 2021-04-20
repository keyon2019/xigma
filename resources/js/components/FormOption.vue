<template>
    <form-container :button-class="buttonClass" :button-text="buttonText"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <form-input label="نام فیلتر" classes="uk-input" :errors="form.errors" type="input" name="name"
                    v-model="form.price.name">
        </form-input>
    </form-container>
</template>

<script>
    export default {
        props: ['option', 'button-class', 'button-text'],
        data() {
            return {
                form: new Form({
                    name: {
                        value: '',
                        rules: 'required|string'
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>