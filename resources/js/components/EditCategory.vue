<template>
    <div>
        <form-category :category="category" @submit="submit"></form-category>
    </div>
</template>

<script>
    export default {
        props: ['initial-category'],
        data() {
            return {
                category: this.initialCategory
            }
        },
        methods: {
            submit(form) {
                Loading.show();
                axios.post(`/dashboard/category/${this.category.id}`, form.asFormData('patch')).then((response) => {
                    Toast.message("دسته‌بندی با موفقیت به روزرسانی شد").success().show();
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