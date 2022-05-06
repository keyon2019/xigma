<template>
    <div>
        <form-page :page="page" :top-menus="topMenus" @submit="submit"></form-page>
    </div>
</template>

<script>
    export default {
        props: ['initial-page', 'top-menus'],
        data() {
            return {
                page: this.initialPage
            }
        },
        methods: {
            submit(form) {
                Loading.show();
                axios.post(`/dashboard/page/${this.page.slug}`, form.asFormData('patch')).then((response) => {
                    Toast.message("صفحه با موفقیت به روزرسانی شد").success().show();
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