<template>
    <form-container :button-class="buttonClass" :button-text="buttonText" :stacked="true"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <form-input label="نام فیلتر" classes="uk-input uk-width-medium" :errors="form.errors" type="input" name="name"
                    v-model="form.name.value">
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
        },
        methods: {
            submit() {
                if (this.form.validate())
                    this.$emit('submit', this.form);
            }
        },
        mounted() {
            if (this.option)
                this.form.fill(this.option);
        }
    }
</script>

<style scoped>

</style>