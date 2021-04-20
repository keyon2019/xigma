<template>
    <div class="uk-margin-top">
        <ul class="uk-tab uk-child-width-1-6"
            data-uk-switcher="animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium">
            <li><a href="#">مشخصات</a></li>
            <li><a href="#">دسته‌بندی‌ها</a></li>
            <li><a href="#">فیلترها</a></li>
            <li><a href="#">انواع</a></li>
            <li><a href="#">گالری</a></li>
            <li><a href="#">وسایل نقلیه</a></li>
        </ul>

        <div class="uk-switcher uk-margin">
            <div>
                <form-product button-class="uk-button-secondary"
                              button-text="ویرایش" :product="product" @submit="updateProduct"></form-product>
            </div>
            <div>دسته‌بندی‌ها</div>
            <div>
                <product-options :initial-options="product.options" class="uk-margin-bottom"></product-options>
                <options @chosen="addOption" fetch-url="/dashboard/option" :choose-list="true"></options>
            </div>
            <div>
                <create-variation :product="product" @variation="addVariation"></create-variation>
                <h3 class="uk-margin-remove-bottom">لیست انواع مختلف محصول</h3>
                <hr class="uk-margin-remove"/>
                <variation :key="'variation' + variation.id" :pictures="product.pictures" :variation="variation"
                           :options="product.options"
                           v-for="variation in product.variations"></variation>
            </div>
            <div>
                <upload-area url="/dashboard/picture" :id="product.id" type="Product"></upload-area>
                <gallery :initial-pictures="product.pictures"></gallery>
            </div>
            <div>وسایل نقلیه</div>
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
            addVariation(variation) {
                this.product.variations.unshift(variation);
                Toast.message('نوع جدید به محصول اضافه شد').success().show();
            }
        }
    }
</script>

<style scoped>

</style>