<template>
    <div class="uk-card product-card uk-box-shadow-hover-medium" style="border-radius: 0.6em">
        <a :href="`/product/${product.id}`">
            <img :src="product.splashUrl" class="uk-width-expand card-image">
        </a>
        <div class="uk-padding-small">
            <p class="uk-text-secondary uk-margin-remove uk-text-medium uk-text-center">
                {{product.name}}
            </p>
            <p class="uk-margin-remove uk-display-inline-block uk-width-1-1 text-small@m">
                <span class="uk-float-left uk-text-meta">مقبولیت</span>
                <stars-rating class="uk-float-right" :rating="product.rating"></stars-rating>
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