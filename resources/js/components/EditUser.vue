<template>
    <div>
        <form-user :user="user" @submit="submit"></form-user>
    </div>
</template>

<script>
    export default {
        props: ['initial-user'],
        data() {
            return {
                user: this.initialUser
            }
        },
        methods: {
            submit(form) {
                Loading.show();
                axios.post(`/dashboard/user/${this.user.id}`, form.asFormData('patch')).then((response) => {
                    Toast.message("کاربر با موفقیت به روزرسانی شد").success().show();
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