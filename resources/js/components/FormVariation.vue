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
                        <label class="uk-form-label">قیمت</label>
                        <div class="uk-form-controls">
                            <c-s-input name="price" v-model="form.price.value"></c-s-input>
                        </div>
                        <div v-if="form.errors.has('price')"
                             class="uk-text-danger uk-text-small">{{form.errors['price']}}
                        </div>
                    </div>
                    <div class="uk-width-1-2">
                        <label class="uk-form-label">قیمت استثنایی</label>
                        <div class="uk-form-controls">
                            <c-s-input name="special_price" v-model="form.special_price.value"></c-s-input>
                        </div>
                        <div v-if="form.errors.has('special_price')"
                             class="uk-text-danger uk-text-small">{{form.errors['special_price']}}
                        </div>
                    </div>
                    <div class="uk-width-1-2">
                        <form-input name="points" label="امتیاز" :errors="form.errors"
                                    v-model="form.points.value" classes="uk-input" type="input">
                        </form-input>
                    </div>
                    <div class="uk-width-1-2">
                        <form-input :id="dpRandomId" name="special_price_expiration" label="انقضای قیمت استثنائی"
                                    :errors="form.errors"
                                    :value="$refs.dp ? $refs.dp.displayValue : ''" classes="uk-input" type="input">
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
        <date-picker type="datetime"
                     ref="dp" v-model="form.special_price_expiration.value" :element="dpRandomId"></date-picker>
    </form-container>
</template>

<script>

    export default {
        props: ['variation', 'button-class', 'button-text', 'pictures', 'disabled', 'options', 'values'],
        data() {
            return {
                dpRandomId: Math.random().toString(36).substring(7),
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
                    special_price: {
                        value: '',
                        rules: 'numeric'
                    },
                    special_price_expiration: {
                        value: '',
                        rules: 'string'
                    },
                    points: {
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