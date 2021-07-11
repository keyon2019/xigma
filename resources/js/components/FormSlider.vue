<template>
    <form-container :button-class="buttonClass" :button-text="buttonText"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <div class="uk-grid" data-uk-grid>
            <div class="uk-width-expand">
                <div class="uk-grid uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-1">
                        <form-input label="تیتر اسلایدر" classes="uk-input"
                                    type="input"
                                    name="title"
                                    :errors="form.errors"
                                    v-model="form.title.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-1">
                        <form-input label="زیر تیتر اسلایدر" classes="uk-input"
                                    type="input"
                                    name="sub_title"
                                    :errors="form.errors"
                                    v-model="form.sub_title.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-1">
                        <form-input label="URL" classes="uk-input"
                                    type="input"
                                    name="url"
                                    :errors="form.errors"
                                    v-model="form.url.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-3">
                        <form-input label="متن دکمه" classes="uk-input"
                                    type="input"
                                    name="button_text"
                                    :errors="form.errors"
                                    v-model="form.button_text.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-3">
                        <form-input label="ترتیب نمایش" classes="uk-input"
                                    type="input"
                                    name="order"
                                    :errors="form.errors"
                                    v-model="form.order.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-3">
                        <label class="uk-form-label">موقعیت نمایش باکس توضیحات</label>
                        <div class="uk-form-controls">
                            <select class="uk-select uk-border-rounded uk-width-expand" v-model="form.left.value">
                                <option :value="1">چپ</option>
                                <option :value="0">راست</option>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-1-1">
                        <image-input name="splash" v-model="form.picture.value" placeholder="1920x800"></image-input>
                        <div v-if="form.errors.has('picture')"
                             class="uk-text-danger uk-text-small">{{form.errors['picture']}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form-container>
</template>

<script>

    export default {
        props: ['slider', 'button-class', 'button-text'],
        data() {
            return {
                form: new Form({
                    title: {
                        value: '',
                        rules: 'required|string'
                    },
                    sub_title: {
                        value: '',
                        rules: 'required|string',
                    },
                    picture: {
                        value: null,
                        rules: 'file'
                    },
                    url: {
                        value: null,
                        rules: 'string'
                    },
                    order: {
                        value: null,
                        rules: 'numeric'
                    },
                    button_text: {
                        value: null,
                        rules: 'required|string'
                    },
                    left: {
                        value: 0,
                        rules: 'boolean'
                    }
                }),
            }
        },
        mounted() {
            if (this.slider) {
                this.form.fill(this.slider);
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