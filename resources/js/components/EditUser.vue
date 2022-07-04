<template>
    <div>
        <div class="uk-padding uk-background-default uk-border-rounded uk-box-shadow-small uk-margin">
            <h4 class="uk-text-muted">مشخصات کاربر</h4>
            <form-user :user="user" @submit="submit"></form-user>
        </div>
        <div class="">
            <ul class="uk-tab"
                data-uk-switcher="animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium">
                <li><a href="#orders">سفارش‌ها</a></li>
                <li><a href="#addresses">نشانی‌ها</a></li>
                <li><a href="#points">امتیازات</a></li>
            </ul>

            <div class="uk-switcher uk-padding uk-background-default uk-border-rounded uk-box-shadow-small uk-margin">
                <div>
                    <front-orders :admin-panel="true" :fetch-url="'/dashboard/order/user/' + user.id"></front-orders>
                </div>
                <div>
                    Coming Soon
                </div>
                <div>
                    <points :user="user" :fetch-url="'/dashboard/user/' + user.id + '/point'"></points>
                </div>
            </div>
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