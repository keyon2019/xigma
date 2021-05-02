<template>
    <div>
        <form-option @submit="submit"></form-option>
    </div>
</template>

<script>
    export default {
        methods: {
            submit(form) {
                Loading.show();
                axios.post('/dashboard/option', form.asFormData()).then((response) => {
                    Toast.message("فیلتر جدید با موفقیت ثبت شد").success().show();
                    window.location.replace(`/dashboard/option/${response.data.option.id}/edit`);
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