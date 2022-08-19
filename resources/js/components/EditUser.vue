<template>
    <div>
        <div class="uk-padding uk-background-default uk-border-rounded uk-box-shadow-small uk-margin">
            <h4 class="uk-text-muted">مشخصات کاربر</h4>
            <form-user :user="user" @submit="submit"></form-user>
        </div>
        <div class="">
            <ul class="uk-tab"
                data-uk-switcher="animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium">
                <li v-if="$user.is_admin"><a href="#roles">نقش‌های سیستمی</a></li>
                <li><a href="#orders">سفارش‌ها</a></li>
                <li><a href="#addresses">نشانی‌ها</a></li>
                <li><a href="#points">امتیازات</a></li>
                <li><a href="#vehicles">وسایل نقلیه</a></li>
            </ul>

            <div class="uk-switcher uk-padding uk-background-default uk-border-rounded uk-box-shadow-small uk-margin">
                <div v-if="$user.is_admin">
                    <div v-for="(role, id) in roles" class="uk-margin-small">
                        <label><input class="uk-checkbox" v-model="user.roles" type="checkbox" :value="id" name="roles[]">
                            {{role}} </label>
                    </div>
                    <div>
                        <button @click="updateRoles()" class="uk-button uk-button-secondary uk-border-rounded uk-button-small">
                            ویرایش
                        </button>
                    </div>
                </div>
                <div id="orders-content">
                    <front-orders :admin-panel="true" :fetch-url="'/dashboard/order/user/' + user.id"></front-orders>
                </div>
                <div id="addresses-content">
                    <front-addresses v-if="addressesShown" :fetch-url="'/dashboard/address/user/' + user.id"></front-addresses>
                </div>
                <div id="points-content">
                    <points v-if="pointsShown" :user="user" :fetch-url="'/dashboard/user/' + user.id + '/point'"></points>
                </div>
                <div id="vehicles-content">
                    <div v-if="vehiclesShown">
                        Vehicles
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['initial-user', 'roles'],
        data() {
            return {
                user: this.initialUser,
                addressesShown: false,
                pointsShown: false,
                vehiclesShown: false,
            }
        },
        mounted() {
            UIkit.util.on(document, 'beforeshow', '#addresses-content', (e) => {
                this.addressesShown = true;
            });
            UIkit.util.on(document, 'beforeshow', '#points-content', (e) => {
                this.pointsShown = true;
            });
            UIkit.util.on(document, 'beforeshow', '#vehicles-content', (e) => {
                this.vehiclesShown = true;
            });
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
            },
            updateRoles() {
                Loading.show();
                axios.post(`/dashboard/user/${this.user.id}/role`, {roles: this.user.roles}).then(() => {
                    Toast.message("نقش‌های کاربر با موفقیت به روزرسانی شد").success().show();
                }).catch((e) => Toast.message(e.response.data.message).danger().show())
                    .then(() => Loading.hide());
            }
        }
    }
</script>

<style scoped>

</style>