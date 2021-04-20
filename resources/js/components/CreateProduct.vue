<template>
    <div>
        <form-product @submit="submit"></form-product>
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        methods: {
            submit(form) {
                Loading.show();
                axios.post('/dashboard/product', form.asFormData()).then((response) => {
                    Toast.message("محصول جدید با موفقیت ثبت شد").success().show();
                    window.location.replace(`/dashboard/product/${response.data.product.id}/edit`);
                }).catch((error) => {

                }).then(() => {
                    Loading.close();
                })
            }
        }
    }
</script>

<style scoped>

</style>