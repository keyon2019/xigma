<template>
    <div>
        <form-item @submit="submit"></form-item>
    </div>
</template>

<script>
    export default {
        methods: {
            submit(form) {
                Loading.show();
                axios.post(window.location.href, form.asFormData()).then(() => {
                    Toast.message("تولیدات جدید با موفقیت ثبت شد").success().show();
                    window.location.href = window.location.href;
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