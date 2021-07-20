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
                            <ckeditor @ready="ckReady" v-model="form.description.value"></ckeditor>
                        </div>
                    </div>
                    <div class="uk-width-1-3">
                        <form-input label="قیمت" classes="uk-input" :errors="form.errors" type="input" name="price"
                                    v-model="form.price.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-3">
                        <form-input name="special_price" label="قیمت استثنائی" :errors="form.errors"
                                    v-model="form.special_price.value" classes="uk-input" type="input">
                        </form-input>
                    </div>
                    <div class="uk-width-1-3">
                        <form-input id="special_price_expiration" name="special_price_expiration" label="انقضای قیمت استثنائی" :errors="form.errors"
                                    :value="$refs.dp ? $refs.dp.displayValue : ''" classes="uk-input" type="input">
                        </form-input>
                    </div>
                    <div class="uk-width-1-2">
                        <form-input label="هزینه ارسال" classes="uk-input" :errors="form.errors" type="input" name="price"
                                    v-model="form.delivery_cost.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-2">
                        <form-input label="ظرفیت تولید روزانه" classes="uk-input" :errors="form.errors" type="input" name="price"
                                    v-model="form.daily_production_capacity.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-3">
                        <label><input class="uk-checkbox" type="checkbox" v-model="form.onesie.value"> تک‌سفارشی </label>
                    </div>
                    <div class="uk-width-1-3">
                        <label><input class="uk-checkbox" type="checkbox" v-model="form.preorderable.value"> قابل پیش‌سفارش </label>
                    </div>
                    <div class="uk-width-1-3">
                        <label><input class="uk-checkbox" type="checkbox" v-model="form.is_huge.value"> حجیم </label>
                    </div>
                </div>
            </div>
            <div v-if="product" class="uk-width-1-3@m">
                <div class="uk-form-label">&nbsp;</div>
                <select-picture :pictures="product.pictures" v-model="form.splash.value"></select-picture>
            </div>
        </div>
        <date-picker type="datetime"
                     ref="dp" v-model="form.special_price_expiration.value" element="special_price_expiration"></date-picker>
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
                    special_price: {
                        value: '',
                        rules: 'numeric'
                    },
                    special_price_expiration: {
                        value: '',
                        rules: 'string'
                    },
                    delivery_cost: {
                        value: '',
                        rules: 'numeric'
                    },
                    daily_production_capacity: {
                        value: '',
                        rules: 'numeric'
                    },
                    onesie: {
                        value: false,
                        rules: 'boolean'
                    },
                    preorderable: {
                        value: false,
                        rules: 'boolean'
                    },
                    is_huge: {
                        value: false,
                        rules: 'boolean'
                    },
                    splash: {
                        value: null,
                        rules: 'numeric',
                    }
                }),
            }
        },
        methods: {
            submit() {
                if (this.form.validate()) {
                    this.$emit('submit', this.form);
                }
            },
            ckReady() {
                if (this.product) {
                    this.form.fill(this.product);
                }
            }
        }
    }
</script>

<style scoped>

</style>