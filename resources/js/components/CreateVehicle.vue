<template>
    <div>
        <form-vehicle @submit="submit"></form-vehicle>
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
                axios.post('/dashboard/vehicle', form.asFormData()).then((response) => {
                    Toast.message("وسیله نقلیه جدید با موفقیت ثبت شد").success().show();
                    window.location.replace(`/dashboard/vehicle/${response.data.vehicle.id}/edit`);
                }).catch((error) => {
                    Toast.message("خطا در ثبت وسیله نقلیه جدید").danger().show();
                }).then(() => {
                    Loading.close();
                })
            }
        }
    }
</script>

<style scoped>

</style>