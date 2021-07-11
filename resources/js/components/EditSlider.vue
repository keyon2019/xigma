<template>
    <div class="uk-margin-bottom">
        <form-slider button-text="ویرایش" button-class="uk-button-secondary uk-border-rounded"
                     :slider="slider" @submit="submit"></form-slider>
    </div>
</template>

<script>
    export default {
        props: ['initial-slider'],
        data() {
            return {
                slider: this.initialSlider
            }
        },
        methods: {
            submit(form) {
                Loading.show();
                axios.post(`/dashboard/slider/${this.slider.id}`, form.asFormData('patch')).then((response) => {
                    Toast.message("اسلایدر با موفقیت به روزرسانی شد").success().show();
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