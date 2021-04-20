<template>
    <div class="uk-padding">
        <form-variation @submit="submit" :options="product.options" :pictures="product.pictures"></form-variation>
    </div>
</template>

<script>
    export default {
        props: ['product'],
        methods: {
            submit(form) {
                Loading.show();
                axios.post(`/dashboard/product/${this.product.id}/variation`, form.asFormData()).then((response) => {
                    this.$emit('variation', response.data.variation);
                }).catch(() => {
                    Toast.message("خطا در افزودن نوع محصول").danger().show();
                }).then(() => Loading.close());
            }
        }
    }
</script>

<style scoped>

</style>