<template>
    <div>
        <form-retailer @submit="submit"></form-retailer>
    </div>
</template>

<script>
    export default {
        methods: {
            submit(form) {
                Loading.show();
                axios.post('/dashboard/retailer', form.asFormData()).then((response) => {
                    Toast.message("نماینده جدید با موفقیت ثبت شد").success().show();
                    window.location.replace(`/dashboard/retailer/${response.data.retailer.id}/edit`);
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