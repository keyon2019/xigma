<template>
    <div>
        <form-page :top-menus="topMenus" @submit="submit"></form-page>
    </div>
</template>

<script>
    export default {
        props: ['top-menus'],
        methods: {
            submit(form) {
                Loading.show();
                axios.post('/dashboard/page', form.asFormData()).then((response) => {
                    Toast.message("صفحه جدید با موفقیت ثبت شد").success().show();
                    window.location.replace(`/dashboard/page/${response.data.page.slug}/edit`);
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