<template>
    <div>
        <div class="uk-padding uk-background-default uk-border-rounded uk-box-shadow-small uk-margin">
            <h4 class="uk-text-muted">مشخصات کاربر</h4>
            <form-user :user="user" @submit="submit"></form-user>
        </div>
        <div class="uk-padding uk-background-default uk-border-rounded uk-box-shadow-small uk-margin">
            <h4 class="uk-text-muted">سفارش‌ها</h4>
            <front-orders :admin-panel="true" :fetch-url="'/dashboard/order/user/' + user.id"></front-orders>
        </div>
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