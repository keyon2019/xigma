<template>
    <form-container :disabled="disabled" :button-class="buttonClass" :button-text="buttonText"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <div class="uk-grid" data-uk-grid>
            <div class="uk-width-expand">
                <div class="uk-grid uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-1">
                        <form-input label="نام" classes="uk-input"
                                    type="input"
                                    name="name"
                                    :errors="form.errors"
                                    v-model="form.name.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-1">
                        <form-input label="سریال" type="input" :errors="form.errors"
                                    classes="uk-input" name="sku"
                                    v-model="form.sku.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-2">
                        <form-input label="قیمت" classes="uk-input" :errors="form.errors" type="input" name="price"
                                    v-model="form.price.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-2">
                        <form-input name="old_price" label="قیمت قدیم" :errors="form.errors"
                                    v-model="form.old_price.value" classes="uk-input" type="input">
                        </form-input>
                    </div>
                    <div class="uk-width-1-1">
                        <variation-options :values="values" :options="options" v-model="form.options.value"></variation-options>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-4@m">
                <div class="uk-form-label">&nbsp;</div>
                <select-picture :disabled="disabled" :pictures="pictures" v-model="form.splash.value"></select-picture>
            </div>
        </div>
    </form-container>
</template>

<script>

    export default {
        props: ['variation', 'button-class', 'button-text', 'pictures', 'disabled', 'options', 'values'],
        data() {
            return {
                form: new Form({
                    name: {
                        value: '',
                        rules: 'required|string'
                    },
                    sku: {
                        value: '',
                        rules: 'string',
                    },
                    price: {
                        value: '',
                        rules: 'required|numeric'
                    },
                    old_price: {
                        value: '',
                        rules: 'numeric'
                    },
                    splash: {
                        value: null,
                        rules: 'numeric',
                    },
                    options: {
                        value: null,
                        rules: 'array'
                    }
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