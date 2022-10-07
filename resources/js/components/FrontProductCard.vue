<template>
    <div class="uk-card product-card uk-box-shadow-hover-medium uk-card-default" style="border-radius: 0.6em">
        <a :href="`/product/${product.id}`" class="uk-link-reset">
            <img :src="product.splashUrl ? product.splashUrl : '/uploads/xigma_logo.png'"
                 class="uk-width-expand uk-border-rounded card-image">
            <div class="uk-padding-small">
                <p class="uk-text-secondary uk-margin-remove uk-text-center uk-text-truncate">
                    {{product.name}}
                </p>
                <div dir="ltr" class="uk-text-secondary uk-text-center clickable uk-margin-small-bottom numeric-standard uk-text-truncate">
                    {{product.en_name}}
                </div>
                <p class="uk-margin-remove uk-display-inline-block uk-width-1-1 text-small@m">
                    <span class="uk-float-left uk-text-meta">امتیاز</span>
                    <stars-rating class="uk-float-right" :rating="product.rating ? product.rating : 3"></stars-rating>
                </p>
                <p class="uk-margin-remove uk-display-inline-block uk-width-1-1 text-small@m">
                    <span class="uk-float-right uk-text-medium">{{product.price.toLocaleString()}}</span>
                    <span class="uk-float-left uk-text-medium uk-text-normal">تومان</span>
                </p>
                <button :disabled="!product.available" @click="navigateToProduct(product)"
                        class="uk-button uk-button-success uk-text-white uk-width-expand uk-margin-small-bottom">
                <span v-if="product.available" class="uk-margin-small-right"
                      data-uk-icon="cart"></span><span v-text="product.available ? 'خرید' : 'ناموجود'"></span>
                </button>
            </div>
        </a>
    </div>
</template>

<script>
    export default {
        props: ['product'],
        methods: {
            navigateToProduct(product) {
                return window.location.href = `/product/${product.id}`;
            }
        }
    }
</script>

<style scoped>

    .product-card {
        border: 1px solid gainsboro;
    }

    .card-image {
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
</style>