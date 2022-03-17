<template>
    <div>
        <form-page @submit="submit"></form-page>
    </div>
</template>

<script>
    export default {
        methods: {
            submit(form) {
                Loading.show();
                axios.post('/dashboard/page', form.asFormData()).then((response) => {
                    Toast.message("صفحه جدید با موفقیت ثبت شد").success().show();
                    window.location.replace(`/dashboard/page/${response.data.page.slug}/edit`);
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