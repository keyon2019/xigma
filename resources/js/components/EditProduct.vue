<template>
    <div class="uk-margin-top">
        <ul class="uk-tab uk-child-width-1-5"
            data-uk-switcher="animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium">
            <li><a href="#info">مشخصات</a></li>
            <li><a href="#categories">دسته‌بندی‌ها</a></li>
            <li><a href="#filters">فیلترها</a></li>
            <li><a href="#variations">انواع</a></li>
            <li><a href="#gallery">گالری</a></li>
        </ul>

        <div class="uk-switcher uk-margin">
            <div>
                <form-product button-class="uk-button-secondary"
                              button-text="ویرایش" :product="product" @submit="updateProduct"></form-product>
            </div>
            <div>
                <product-categories @remove="removeCategory" :initial-categories="product.categories"
                                 class="uk-margin-bottom"></product-categories>
                <categories @chosen="addCategory" fetch-url="/dashboard/category" :choose-list="true"></categories>
            </div>
            <div>
                <product-options @remove="removeOption" :initial-options="product.options"
                                 class="uk-margin-bottom"></product-options>
                <options @chosen="addOption" fetch-url="/dashboard/option"
                         :choose-list="true"></options>
            </div>
            <div>
                <create-variation :product="product" @variation="addVariation"></create-variation>
                <h3 class="uk-margin-remove-bottom">لیست انواع مختلف محصول</h3>
                <hr class="uk-margin-remove"/>
                <variation @deleted="removeVariation" :key="'variation' + variation.id" :pictures="product.pictures"
                           :variation="variation"
                           :options="product.options"
                           v-for="variation in product.variations"></variation>
            </div>
            <div>
                <upload-area url="/dashboard/picture" :id="product.id" type="Product"></upload-area>
                <gallery :initial-pictures="product.pictures"></gallery>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['initial-product'],
        data() {
            return {
                product: this.initialProduct,
                galleryModal: new Modal('gallery'),
            }
        },
        mounted() {
            Event.$on('picture-uploaded', (picture) => {
                this.product.pictures.unshift(picture);
            })
        },
        methods: {
            updateProduct(form) {
                Loading.show();
                axios.post(`/dashboard/product/${this.product.id}`, form.asFormData('patch')).then(() => {
                    Toast.message("محصول با موفقیت به روزرسانی شد").success().show();
                }).catch(() => {

                }).then(() => {
                    Loading.hide();
                })
            },
            addOption(option) {
                if (_.findIndex(this.product.options, o => o.id === option.id) >= 0) {
                    UIkit.modal.alert('فیلتر قبلا به محصول متصل شده است');
                    return;
                }
                Loading.show();
                axios.post(`/dashboard/product/${this.product.id}/option`, {option_id: option.id}).then(() => {
                    this.product.options.unshift(option);
                    Toast.message('فیلتر جدید به محصول اضافه شد').success().show();
                }).catch(() => {
                    Toast.message("خطا در افزودن فیلتر").danger().show();
                }).then(() => Loading.close());
            },
            removeOption(option) {
                Loading.show();
                axios.post(`/dashboard/product/${this.product.id}/option`, {option_id: option.id, _method: 'delete'})
                    .then(() => {
                        const oIndex = _.findIndex(this.product.options, o => o.id === option.id);
                        this.product.options.splice(oIndex, 1);
                        Toast.message("فیلتر از محصول جدا شد").success().show();
                    }).catch(() => Toast.message("خطا در افزودن فیلتر").danger().show()).then(() => Loading.hide());
            },
            addVariation(variation) {
                this.product.variations.unshift(variation);
                Toast.message('نوع جدید به محصول اضافه شد').success().show();
            },
            removeVariation(variation) {
                const vIndex = _.findIndex(this.product.variations, v => v.id === variation.id);
                this.product.variations.splice(vIndex, 1);
            },
            addCategory(category) {
                if (_.findIndex(this.product.categories, c => c.id === category.id) >= 0) {
                    UIkit.modal.alert('دسبته بندی قبلا به محصول متصل شده است');
                    return;
                }
                Loading.show();
                axios.post(`/dashboard/product/${this.product.id}/category`, {category_id: category.id}).then(() => {
                    this.product.categories.unshift(category);
                    Toast.message('دسته‌بندی جدید به محصول اضافه شد').success().show();
                }).catch(() => {
                    Toast.message("خطا در افزودن دسته بندی").danger().show();
                }).then(() => Loading.close());
            },
            removeCategory(category) {
                Loading.show();
                axios.post(`/dashboard/product/${this.product.id}/category`, {category_id: category.id, _method: 'delete'})
                    .then(() => {
                        const oIndex = _.findIndex(this.product.categories, o => o.id === category.id);
                        this.product.categories.splice(oIndex, 1);
                        Toast.message("دسته‌بندی از محصول جدا شد").success().show();
                    }).catch(() => Toast.message("خطا در حذف دسته‌بندی").danger().show()).then(() => Loading.hide());
            }
        }
    }
</script>

<style scoped>

</style>