<template>
    <div>
        <form-category @submit="submit"></form-category>
    </div>
</template>

<script>
    export default {
        methods: {
            submit(form) {
                Loading.show();
                axios.post('/dashboard/category', form.asFormData()).then((response) => {
                    Toast.message("دسته‌بندی جدید با موفقیت ثبت شد").success().show();
                    window.location.replace(`/dashboard/category/${response.data.category.id}/edit`);
                }).catch((error) => {
                    Toast.message(error.response.data.message).danger().show();
                }).then(() => {
                    Loading.close();
                })
            }
        }
    }
</script>

<style scoped>

</style>