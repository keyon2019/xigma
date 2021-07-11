<template>
    <div class="uk-margin-bottom">
        <form-slider @submit="submit"></form-slider>
    </div>
</template>

<script>
    export default {
        methods: {
            submit(form) {
                Loading.show();
                axios.post('/dashboard/slider', form.asFormData()).then((response) => {
                    Toast.message("اسلایدر جدید با موفقیت ثبت شد").success().show();
                    window.location.replace(`/dashboard/slider/${response.data.slider.id}/edit`);
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