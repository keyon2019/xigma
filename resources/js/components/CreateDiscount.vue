<template>
    <div>
        <form-container @input="form.errors.clear($event.target.name)" @submit="submit()">
            <div class="uk-grid" data-uk-grid>
                <div class="uk-width-expand">
                    <div class="uk-grid uk-grid-small" data-uk-grid>
                        <div class="uk-width-1-4">
                            <div class="uk-margin">
                                <label class="uk-form-label">انتخاب دسته بندی</label>
                                <div class="uk-form-controls">
                                    <select name="category_id"
                                            class="uk-select uk-border-rounded uk-width-expand"
                                            v-model="form.category_id.value">
                                        <option :value="null" disabled>انتخاب کنید</option>
                                        <option v-for="category in categories" :value="category.id"
                                                v-text="category.name + ' (' + category.products_count + ' محصول)'"></option>
                                    </select>
                                    <div v-if="form.errors.has('category_id')"
                                         class="uk-text-danger uk-text-small">{{form.errors['category_id']}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-4">
                            <div class="uk-margin">
                                <form-input label="درصد تخفیف" classes="uk-input"
                                            type="input"
                                            name="percent"
                                            :errors="form.errors"
                                            v-model="form.percent.value">
                                </form-input>
                            </div>
                        </div>
                        <div class="uk-width-1-4">
                            <form-input id="expiration_date" name="expiration_date" label="انقضای قیمت استثنایی"
                                        :errors="form.errors"
                                        :value="$refs.dp ? $refs.dp.displayValue : ''" classes="uk-input" type="input">
                            </form-input>
                            <date-picker type="datetime"
                                         ref="dp" v-model="form.expiration_date.value" element="expiration_date"></date-picker>
                        </div>
                    </div>
                </div>
            </div>
        </form-container>
    </div>
</template>

<script>
    export default {
        props: ['categories'],
        data() {
            return {
                form: new Form({
                    category_id: {
                        value: null,
                        rules: 'required|numeric'
                    },
                    percent: {
                        value: null,
                        rules: 'required|numeric'
                    },
                    expiration_date: {
                        value: null,
                        rules: 'required|string'
                    }
                })
            }
        },
        methods: {
            submit() {
                if (this.form.validate()) {
                    Loading.show();
                    axios.post('/dashboard/discount', this.form.asFormData()).then((response) => {
                        Toast.message('تخفیف‌ محصولات با موفقیت ثبت شد').success().show();
                        this.form.clear();
                    }).catch((e) => {
                        Toast.message(e.response.data.message).danger().show();
                    }).then(() => {
                        Loading.hide();
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>