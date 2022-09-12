<template>
    <div>
        <form-user @submit="submit"></form-user>
    </div>
</template>

<script>
    export default {
        methods: {
            submit(form) {
                Loading.show();
                axios.post('/dashboard/user', form.asFormData()).then((response) => {
                    Toast.message("کاربر جدید با موفقیت ثبت شد").success().show();
                    window.location.replace(`/dashboard/user/${response.data.user.id}/edit`);
                }).catch((e) => {
                    Toast.message(this.getErrorMessage(e)).danger().show();
                }).then(() => {
                    Loading.close();
                })
            }
        }
    }
</script>

<style scoped>

</style>