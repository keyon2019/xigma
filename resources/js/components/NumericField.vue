<template>
    <span>
        <input :class="classes" autocomplete="off" v-model="output" @input="emitInput" class="uk-input" :placeholder="placeholder">
        <input type="hidden" v-model="formValue" :name="name">
    </span>
</template>

<script>
    export default {
        props: ['placeholder', 'value', 'name', 'classes'],
        data() {
            return {
                output: this.value,
                formValue: "",
                nums: {
                    0: '۰',
                    1: '۱',
                    2: '۲',
                    3: '۳',
                    4: '۴',
                    5: '۵',
                    6: '۶',
                    7: '۷',
                    8: '۸',
                    9: '۹',
                    '.': '.'
                },
            }
        },
        mounted() {
            this.emitInput();
        },
        methods: {
            emitInput(e) {
                let latin = this.latinNum(this.output);
                this.formValue = latin;
                this.$emit('input', latin);
            },
            latinNum(number) {
                if (!number)
                    return null;
                if (typeof (number) === "number") {
                    return number;
                }
                _.forEach(this.nums, (farsiChar, latinChar) => {
                    number = number.replaceAll(farsiChar, latinChar);
                });
                if(isNaN(number)) {
                    this.output = "";
                    return null;
                }
                return number;
            }
        },
        watch: {
            value: {
                handler(v) {
                    if (isNaN(v))
                        return 0;
                    this.output = v;
                }
            },
            immediate: true
        }
    }
</script>