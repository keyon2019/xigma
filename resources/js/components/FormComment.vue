<template>
    <form-container button-class="uk-float-right uk-border-rounded uk-button-secondary" :button-text="'ثبت نظر'"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <div class="uk-margin-bottom">
            <h3 class="uk-margin-remove">ارسال نظر</h3>
            <hr class="uk-margin-remove"/>
        </div>
        <div class="uk-grid" data-uk-grid>
            <div class="uk-width-1-3@m">
                <img :src="product.splashUrl" uk-img>
            </div>
            <div class="uk-width-2-3@m">
                <p class="uk-text-center uk-padding-small uk-text-bolder">دیگران را با نوشتن نظرات خود، برای انتخاب این محصول
                    راهنمایی کنید</p>
                <h4 class="uk-margin-remove">{{product.name}}</h4>
                <hr class="uk-margin-remove-top"/>
                <div class="uk-margin-small">
                    <label class="uk-form-label">امتیاز شما</label>
                    <stars-rating :interactive="true" v-model="form.rating.value"></stars-rating>
                </div>
                <form-input label="متن نظر" classes="uk-textarea"
                            type="textarea"
                            name="text"
                            :rows="6"
                            :errors="form.errors"
                            v-model="form.text.value">
                </form-input>
            </div>
        </div>
    </form-container>
</template>

<script>

    export default {
        props: ['address', 'button-class', 'button-text', 'product'],
        data() {
            return {
                categories: [],
                form: new Form({
                    text: {
                        value: '',
                        rules: 'required|string'
                    },
                    rating: {
                        value: null,
                        rules: 'required|numeric'
                    },
                    product_id: {
                        value: this.product.id,
                        rules: 'required|numeric'
                    }
                }),
            }
        },
        mounted() {
            if (this.address) {
                this.form.fill(this.address);
            }
        },
        methods: {
            submit() {
                if (this.form.validate()) {
                    Loading.show();
                    axios.post('/comment', this.form.asFormData()).then(() => {
                        Toast.message('نظر شما با موفقیت ثبت شد و پس از تایید به نمایش در می‌آید').success().show();
                        this.form.text.value = null;
                        this.form.rating.value = null;
                        this.$emit('submit');
                    }).catch((e) => Toast.message(e.response.data.message).danger().show())
                        .then(() => Loading.hide())
                }
            },
        }
    }
</script>

<style scoped>

</style>