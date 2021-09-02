<template>
    <div>
        <form-retailer :retailer="retailer" @submit="submit"></form-retailer>
    </div>
</template>

<script>
    export default {
        props: ['initial-retailer'],
        data() {
            return {
                retailer: this.initialRetailer
            }
        },
        methods: {
            submit(form) {
                Loading.show();
                axios.post(`/dashboard/retailer/${this.retailer.id}`, form.asFormData('patch')).then((response) => {
                    Toast.message("نماینده جدید با موفقیت به روزرسانی شد").success().show();
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