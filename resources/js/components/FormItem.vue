<template>
    <form-container :disabled="disabled" :button-class="buttonClass" :button-text="buttonText"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <div class="uk-grid" data-uk-grid>
            <div class="uk-width-expand">
                <div class="uk-grid uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-3">
                        <form-input label="کد پیشوند" classes="uk-input"
                                    type="input"
                                    name="prefix"
                                    :errors="form.errors"
                                    v-model="form.prefix.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-3">
                        <form-input label="شروع" type="input" :errors="form.errors"
                                    classes="uk-input" name="start"
                                    v-model="form.start.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-3">
                        <form-input label="تعداد" type="input" :errors="form.errors"
                                    classes="uk-input" name="quantity"
                                    v-model="form.quantity.value">
                        </form-input>
                    </div>
                </div>
            </div>
        </div>
    </form-container>
</template>

<script>

    export default {
        props: ['variation', 'button-class', 'button-text', 'pictures', 'disabled', 'options', 'values'],
        data() {
            return {
                dpRandomId: Math.random().toString(36).substring(7),
                form: new Form({
                    prefix: {
                        value: '',
                        rules: 'required|string'
                    },
                    start: {
                        value: '',
                        rules: 'required|numeric',
                    },
                    quantity: {
                        value: '',
                        rules: 'required|numeric'
                    },
                }),
            }
        },
        mounted() {
            if (this.variation) {
                this.form.fill(this.variation);
            }
        },
        methods: {
            submit() {
                if (this.form.validate()) {
                    this.$emit('submit', this.form);
                }
            },
        }
    }
</script>

<style scoped>

</style>