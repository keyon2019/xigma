<template>
    <div class="uk-card product-card uk-box-shadow-hover-medium" style="border-radius: 0.6em">
        <a :href="`/product/${product.id}`">
            <img :src="product.splashUrl" class="uk-width-expand card-image">
        </a>
        <div class="uk-padding-small">
            <p class="uk-text-secondary uk-margin-remove uk-text-medium uk-text-center">
                {{product.name}}
            </p>
            <p class="uk-text-secondary uk-margin-remove-top uk-text-medium uk-text-light uk-text-center">
                Xigma 135 Civic</p>
            <p class="uk-margin-remove uk-display-inline-block uk-width-1-1">
                <span class="uk-float-right uk-text-meta">CUB</span>
                <span class="uk-float-left uk-text-meta">کلاس</span>
            </p>
            <p class="uk-margin-remove uk-display-inline-block uk-width-1-1">
                <span class="uk-float-left uk-text-meta">نوع</span>
                <span class="uk-float-right uk-text-meta">انژکتور</span>
            </p>
            <p class="uk-margin-remove uk-display-inline-block uk-width-1-1">
                <span class="uk-float-left uk-text-meta">مقبولیت</span>
                <span class="uk-float-right uk-text-meta">
                                                <span data-uk-icon="icon:star;ratio:0.7"></span>
                                                <span data-uk-icon="icon:star;ratio:0.7"></span>
                                                <span data-uk-icon="icon:star;ratio:0.7"></span>
                                                <span data-uk-icon="icon:star;ratio:0.7"></span>
                                                <span data-uk-icon="icon:star;ratio:0.7"></span>
                                            </span>
            </p>
            <p class="uk-margin-remove uk-display-inline-block uk-width-1-1">
                <span class="uk-float-right uk-text-medium">{{product.price.toLocaleString()}}</span>
                <span class="uk-float-left uk-text-medium uk-text-normal">تومان</span>
            </p>
            <button class="uk-button uk-button-success uk-text-white uk-width-expand uk-margin-small-bottom">
                <span class="uk-margin-small-right"
                      data-uk-icon="cart"></span><span>اضافه به سبد خرید</span>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['product']
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