<template>
    <a class="uk-link-reset" href="/cart">
        <div>محصولات {{totalQuantity}}</div>
        <div>مجموع {{total.toLocaleString()}}</div>
    </a>
</template>

<script>
    export default {
        data() {
            return {
                items: [],
            }
        },
        beforeMount() {
            axios.get('/cart?json').then((response) => {
                this.items = response.data.items;
            });
        },
        mounted() {
            Event.$on('add-to-cart', (variation_id, quantity = 1) => {
                axios.post('/cart', {variation_id: variation_id, quantity: quantity}).then((response) => {
                    let item = response.data.item;
                    let index = _.findIndex(this.items, i => i.id === item.id);
                    console.log(index);
                    if (index > -1) {
                        this.items[index] = item;
                    } else {
                        this.items.unshift(item);
                    }
                    Toast.message("Product added to cart successfully").success().show();
                }).catch((e) => {
                    Toast.message(e.response.data.message).danger().show();
                });
            })
        },
        computed: {
            total() {
                return _.sumBy(this.items, (item) => {
                    return item.quantity * item.price;
                });
            },
            totalQuantity() {
                return _.sumBy(this.items, (item) => {
                    return item.quantity;
                })
            }
        }
    }
</script>

<style scoped>

</style>