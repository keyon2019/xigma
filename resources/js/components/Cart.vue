<template>
    <a class="uk-link-reset" href="/cart">
        <div>محصولات {{cart.totalQuantity()}}</div>
        <div>مجموع {{cart.total().toLocaleString()}}</div>
    </a>
</template>

<script>
    export default {
        data() {
            return {
                cart: window.Cart,
            }
        },
        mounted() {
            Event.$on('add-to-cart', (variation_id, quantity = 1) => {
                this.cart.add(variation_id, quantity);
            })
        }
    }
</script>

<style scoped>

</style>