<template>
    <form-container :button-class="buttonClass" :button-text="buttonText"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <div class="uk-grid" data-uk-grid>
            <div class="uk-width-expand">
                <div class="uk-grid uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-1">
                        <label><input class="uk-checkbox" v-model="form.show.value" type="checkbox" name="show"> نمایش دسته‌بندی
                        </label>
                    </div>
                    <div class="uk-width-1-1">
                        <form-input label="نام دسته‌بندی" classes="uk-input"
                                    type="input"
                                    name="name"
                                    :errors="form.errors"
                                    v-model="form.name.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-1">
                        <input type="number" placeholder="ترتیب نمایش" class="uk-input" v-model="form.order.value">
                    </div>
                    <div class="uk-width-1-1">
                        <label class="uk-form-label">توضیحات</label>
                        <div class="uk-form-controls">
                            <form-input type="textarea" :errors="form.errors"
                                        rows="6" placeholder="توضیحات دسته‌بندی" classes="uk-textarea" name="description"
                                        v-model="form.description.value">
                            </form-input>
                        </div>
                    </div>
                    <div class="uk-width-1-1">
                        <label class="uk-form-label">دسته‌بندی مادر</label>
                        <select v-model="form.parent_id.value" class="uk-select">
                            <option value="">بدون دسته مادر</option>
                            <option v-for="c in selectableCategories" :value="c.id" v-text="c.name"></option>
                        </select>
                    </div>
                    <div class="uk-width-1-1">
                        <label><input class="uk-checkbox" v-model="form.featured.value" type="checkbox" name="show"> دسته‌بندی
                            منتخب </label>
                    </div>
                    <div class="uk-width-1-1">
                        <label><input class="uk-checkbox" v-model="form.show_slider.value" type="checkbox" name="show"> نمایش عکس
                            عریض </label>
                    </div>
                    <div class="uk-width-1-3">
                        <image-input name="splash" v-model="form.splash.value" placeholder="800x800"></image-input>
                        <div v-if="form.errors.has('splash')"
                             class="uk-text-danger uk-text-small">{{form.errors['splash']}}
                        </div>
                    </div>
                    <div class="uk-width-2-3">
                        <image-input name="wide_splash" v-model="form.wide_splash.value" placeholder="1920x800"></image-input>
                        <div v-if="form.errors.has('wide_splash')"
                             class="uk-text-danger uk-text-small">{{form.errors['wide_splash']}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form-container>
</template>

<script>

    export default {
        props: ['category', 'button-class', 'button-text'],
        data() {
            return {
                categories: [],
                form: new Form({
                    name: {
                        value: '',
                        rules: 'required|string'
                    },
                    description: {
                        value: '',
                        rules: 'string',
                    },
                    splash: {
                        value: null,
                        rules: 'file'
                    },
                    wide_splash: {
                        value: null,
                        rules: 'file'
                    },
                    parent_id: {
                        value: '',
                        rules: 'numeric',
                        nullable: true
                    },
                    order: {
                        value: null,
                        rules: 'numeric'
                    },
                    show: {
                        value: null,
                        rules: 'boolean'
                    },
                    featured: {
                        value: null,
                        rules: 'boolean'
                    },
                    show_slider: {
                        value: null,
                        rules: 'boolean'
                    }
                }),
            }
        },
        mounted() {
            if (this.category) {
                this.form.fill(this.category);
            }
            axios.get('/dashboard/category', {n: 100}).then((response) => {
                this.categories = response.data.data;
            }).catch((e) => {
                Toast.message(e.response.data.message).danger().show();
            })
        },
        methods: {
            submit() {
                if (this.form.validate()) {
                    this.$emit('submit', this.form);
                }
            },
        },
        computed: {
            selectableCategories() {
                if (!this.category)
                    return this.categories;
                return this.categories.filter(c => c.id !== this.category.id);
            }
        }
    }
</script>

<style scoped>

</style>