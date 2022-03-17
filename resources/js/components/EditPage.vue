<template>
    <div>
        <form-page :page="page" @submit="submit"></form-page>
    </div>
</template>

<script>
    export default {
        props: ['initial-page'],
        data() {
            return {
                page: this.initialPage
            }
        },
        methods: {
            submit(form) {
                Loading.show();
                axios.post(`/dashboard/page/${this.page.id}`, form.asFormData('patch')).then((response) => {
                    Toast.message("صفحه با موفقیت به روزرسانی شد").success().show();
                }).catch((error) => {
                    Toast.message(error.response.data.message);
                }).then(() => {
                    Loading.close();
                })
            }
        }
    }
</script>

<style scoped>

</style>