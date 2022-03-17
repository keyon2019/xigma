<template>
    <div>
        <div class="uk-width-expand uk-inline">
            <div style="z-index: 1024"class="uk-position-relative">
                <span class="uk-form-icon" data-uk-icon="search" style="right: unset"></span>
                <input @input="search()" v-model="keyword" placeholder="جستجو... " class="uk-input uk-border-rounded">
            </div>
            <div ref="drop" id="search-drop" uk-drop="mode:click;pos:bottom-justify;offset:5" class="drop-overlay uk-border-rounded">
                <div class="uk-card uk-card-body uk-card-default uk-card-small uk-border-rounded">
                    <div v-if="products.length > 0" dir="ltr" class="uk-position-relative uk-visible-toggle" tabindex="-1"
                         uk-slider>
                        <ul class="uk-slider-items uk-child-width-1-4 uk-grid uk-grid-small">
                            <li v-for="product in products">
                                <a :href="`/product/${product.id}`"
                                   class="uk-card uk-card-default uk-link-reset uk-box-shadow-hover-small">
                                    <img :src="product.splashUrl" class="uk-width-expand uk-border-rounded">
                                    <div class="uk-text-small uk-text-center">{{product.name}}</div>
                                </a>
                            </li>
                        </ul>
                        <a class="uk-position-center-right slider-nav uk-position-small uk-link-reset uk-background-muted uk-border-circle uk-box-shadow-small fa-solid fa-chevron-left"
                           href="#"
                           uk-slider-item="previous"></a>
                        <a class="uk-position-center-left slider-nav uk-position-small uk-link-reset uk-background-muted uk-border-circle uk-box-shadow-small fa-solid fa-chevron-right"
                           href="#"
                           uk-slider-item="next"></a>
                    </div>
                    <div class="uk-text-center uk-text-small uk-text-meta" v-else>
                        هیچ محصولی با کلمات کلیدی شما یافت نشد
                    </div>
                    <template v-if="categories.length > 0">
                        <hr/>
                        <p class="uk-margin-small-bottom">در دسته‌بندی‌ها: </p>
                        <div v-for="category in categories" class="uk-text-small uk-text-meta">
                            <a class="uk-button-text" :href="`/category/${category.id}`">{{category.name}}</a>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <!--<div class="uk-section uk-position-absolute" v-if="result">-->
        <!--<div data-uk-grid-->
        <!--class="uk-grid uk-grid-large uk-margin-auto@m uk-flex uk-flex-middle uk-text-center uk-text-left@m">-->
        <!--<div class="uk-width-2-3@m">-->
        <!--<div>-->
        <!--<div class="uk-grid uk-flex uk-flex-center uk-flex-left@m uk-grid-small uk-child-width-1-3">-->
        <!--<div v-if="products.length > 0" v-for="product in products">-->
        <!--<a class="uk-link-reset uk-width-expand" :href="'/product/' + product.id">-->
        <!--<img :src="product.splashUrl"-->
        <!--class="uk-width-expand uk-border-rounded uk-background-muted">-->
        <!--<div class="uk-text-center uk-margin-small-top">{{product.name}}</div>-->
        <!--</a>-->
        <!--</div>-->
        <!--<div v-if="products.length === 0" class="uk-text-meta uk-text-small uk-width-1-1">هیچ محصولی-->
        <!--با کلمه کلیدی شما یافت نشد-->
        <!--</div>-->
        <!--</div>-->
        <!--</div>-->
        <!--</div>-->
        <!--<div class="uk-width-1-3@m">-->
        <!--<div class="uk-text-large uk-margin-small-bottom uk-margin-small-top">دسته‌بندی‌ها</div>-->
        <!--<div>-->
        <!--<div v-if="categories.length >= 0" v-for="category in categories"-->
        <!--class="uk-margin-small-bottom uk-text-small"><a class="uk-button-text"-->
        <!--:href="'/category/' + category.id">{{category.name}}</a>-->
        <!--</div>-->
        <!--<div v-if="categories.length === 0" class="uk-text-small uk-text-meta">هیچ دسته‌بندی با کلمه کلیدی-->
        <!--شما یافت نشد-->
        <!--</div>-->
        <!--</div>-->
        <!--</div>-->
        <!--</div>-->
        <!--</div>-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                keyword: '',
                brands: [],
                categories: [],
                products: [],
                result: false,
            }
        },
        mounted() {
            UIkit.util.on(document, 'beforeshow', '#search-drop', (e) => {
                // if (!this.result)
                //     e.preventDefault();
            });
        },
        methods: {
            search() {
                if (this.keyword.length > 3) {
                    this.result = false;
                    this.$nextTick(() => {
                        UIkit.drop(this.$refs.drop).hide(0);
                    });
                    this.brands = [];
                    this.categories = [];
                    this.products = [];
                    axios.post("/search", {keyword: this.keyword}).then((response) => {
                        this.result = true;
                        this.$nextTick(() => {
                            UIkit.drop(this.$refs.drop).show();
                        });
                        this.brands = response.data.brands;
                        this.categories = response.data.categories;
                        this.products = response.data.products;
                    }).catch((e) => console.log(e.response.data.message))
                }
            }
        },
        watch: {
            keyword(v) {
                this.result = false;
                UIkit.drop(this.$refs.drop).hide(0);
            }

        }
    }
</script>

<style scoped>
    .slider-nav {
        width: 24px;
        height: 20px;
        text-align: center;
        vertical-align: middle;
        padding-top: 4px;
        margin: 6px 8px;
    }

    .drop-overlay {
        outline: rgba(0, 0, 0, 0.3) solid 100vh;
    }
</style>