<template>
    <div>
        <vue-persian-datetime-picker :value="value"
                                     format="YYYY/MM/DD"
                                     display-format="jYYYY/jMM/jDD"
                                     :custom-input="customInput"
                                     v-model="date"
                                     type="date"></vue-persian-datetime-picker>
        <input type="hidden" :name="name" v-model="date">
    </div>
</template>

<script>
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker';

    export default {
        props: ['value', 'custom-input', 'name'],
        components: {VuePersianDatetimePicker},
        data() {
            return {
                date: ""
            }
        },
        watch: {
            date() {
                this.$emit(this.date);
            }
        },
        name: "DatePickerWrapper"
    }
</script>

<style scoped>

</style>