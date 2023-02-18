<template>
    <div>
        <vue-persian-datetime-picker :value="value"
                                     :format="format"
                                     :display-format="displayFormat"
                                     :custom-input="customInput"
                                     v-model="date"
                                     :type="type"></vue-persian-datetime-picker>
        <input type="hidden" :name="name" v-model="date">
    </div>
</template>

<script>
    import VuePersianDatetimePicker from 'vue-persian-datetime-picker';

    export default {
        props: {
            'value': {}, 'custom-input': {}, 'name': {},
            'format': {
                default: 'YYYY/MM/DD'
            },
            'display-format': {
                default: 'jYYYY/jMM/jDD'
            },
            'type': {
                default: 'date'
            }
        },
        components: {VuePersianDatetimePicker},
        data() {
            return {
                date: ""
            }
        },
        mounted() {
            if(this.value)
                this.date = this.value;
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
