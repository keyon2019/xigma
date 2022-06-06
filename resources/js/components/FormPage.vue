<template>
    <form-container :button-class="buttonClass" :button-text="buttonText"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <div class="uk-grid" data-uk-grid>
            <div class="uk-width-expand">
                <div class="uk-grid uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-1">
                        <form-input label="تیتر" classes="uk-input"
                                    type="input"
                                    name="name"
                                    :errors="form.errors"
                                    v-model="form.name.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-1">
                        <label class="uk-form-label">موقعیت منو</label>
                        <select name="position" v-model="form.position.value" class="uk-select">
                            <option :value="null">انتخاب کنید</option>
                            <option value="1">نوار منو بالا</option>
                            <option value="2">ستون اول فوتر</option>
                            <option value="3">ستون دوم فوتر</option>
                            <option value="4">ستون سوم فوتر</option>
                            <option value="5">XIGMA BOX</option>
                        </select>
                    </div>
                    <div class="uk-width-1-1" v-if="form.position.value == 1">
                        <label class="uk-form-label">منوی سرگروه</label>
                        <select name="position" v-model="form.parent.value" class="uk-select">
                            <option value="">بدون سرگروه</option>
                            <option v-for="menu in topMenus" :value="menu.id">{{menu.name}}</option>
                        </select>
                    </div>
                    <div class="uk-width-1-1">
                        <form-input label="لینک (اولویت هدایت با لینک است)" classes="uk-input"
                                    type="input"
                                    name="slug"
                                    :errors="form.errors"
                                    v-model="form.link.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-1">
                        <form-input label="اسلاگ" classes="uk-input"
                                    type="input"
                                    name="slug"
                                    :errors="form.errors"
                                    v-model="form.slug.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-1">
                        <form-input label="تیتر متا" classes="uk-input"
                                    type="input"
                                    name="meta_title"
                                    :errors="form.errors"
                                    v-model="form.meta_title.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-1">
                        <form-input label="توضیحات متا" classes="uk-input"
                                    type="textarea"
                                    name="meta_description"
                                    :errors="form.errors"
                                    v-model="form.meta_description.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-1">
                        <label class="uk-form-label">محتوا</label>
                        <div class="uk-form-controls">
                            <div class="uk-form-controls">
                                <ckeditor @ready="ckReady" v-model="form.content.value"></ckeditor>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form-container>
</template>

<script>

    export default {
        props: ['page', 'button-class', 'button-text', 'top-menus'],
        data() {
            return {
                form: new Form({
                    name: {
                        value: '',
                        rules: 'required|string'
                    },
                    content: {
                        value: '',
                        rules: 'string',
                    },
                    position: {
                        value: null,
                        rules: 'required|numeric'
                    },
                    parent: {
                        value: null,
                        rules: 'nullable|numeric'
                    },
                    slug: {
                        value: null,
                        rules: 'required|string'
                    },
                    link: {
                        value: null,
                        rules: 'string'
                    },
                    meta_title: {
                        value: null,
                        rules: 'string'
                    },
                    meta_description: {
                        value: null,
                        rules: 'string'
                    }
                }),
            }
        },
        mounted() {
            // if (this.page) {
            //     this.form.fill(this.page);
            // }
        },
        methods: {
            submit() {
                if (this.form.validate()) {
                    this.$emit('submit', this.form);
                }
            },
            ckReady() {
                if (this.page) {
                    this.form.fill(this.page);
                }
            }
        },

    }
</script>

<style scoped>

</style>