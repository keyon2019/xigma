<template>
    <form-container :button-class="buttonClass" :button-text="buttonText"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <div class="uk-grid" data-uk-grid>
            <div class="uk-width-expand">
                <div class="uk-grid uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-1">
                        <form-input label="نام محصول" classes="uk-input"
                                    type="input"
                                    name="name"
                                    :errors="form.errors"
                                    v-model="form.name.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-1">
                        <label class="uk-form-label">توضیحات</label>
                        <div class="uk-form-controls">
                            <form-input type="textarea" :errors="form.errors"
                                        rows="6" placeholder="توضیحات محصول" classes="uk-textarea" name="description"
                                        v-model="form.description.value">
                            </form-input>
                        </div>
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
                </div>
            </div>
            <div v-if="product" class="uk-width-1-3@m">
                <select-picture :pictures="product.pictures" v-model="form.splash.value"></select-picture>
            </div>
        </div>
    </form-container>
</template>

<script>

    export default {
        props: ['product', 'button-class', 'button-text'],
        data() {
            return {
                form: new Form({
                    name: {
                        value: '',
                        rules: 'required|string'
                    },
                    description: {
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
                    }
                }),
            }
        },
        mounted() {
            if (this.product) {
                this.form.fill(this.product);
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