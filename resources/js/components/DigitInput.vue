<template>
    <div>
        <fieldset class="uk-fieldset uk-text-center" name='number-code' data-number-code-form @input="inputListener" dir="ltr">
            <input v-for="index in digits" v-model="digitValues[index - 1]" type="number" min='0' max='9' :name="'number-code-' + (index - 1)"
                   :data-number-code-input='index-1' required/>
        </fieldset>
    </div>
</template>

<script>
    export default {
        name: "DigitInput",
        props: {
            'digits': {
                default: 5,
            }
        },
        data() {
            return {
                digitValues: Array(this.digits).fill(null)
            }
        },
        mounted() {
            const numberCodeForm = document.querySelector('[data-number-code-form]');
            const numberCodeInputs = [...numberCodeForm.querySelectorAll('[data-number-code-input]')];

            const handleInput = ({target}) => {
                if (!target.value.length) {
                    return target.value = null;
                }

                const inputLength = target.value.length;
                let currentIndex = Number(target.dataset.numberCodeInput);

                if (inputLength > 1) {
                    const inputValues = target.value.split('');

                    inputValues.forEach((value, valueIndex) => {
                        const nextValueIndex = currentIndex + valueIndex;

                        if (nextValueIndex >= numberCodeInputs.length) {
                            return;
                        }

                        numberCodeInputs[nextValueIndex].value = value;
                    });

                    currentIndex += inputValues.length - 2;
                }

                const nextIndex = currentIndex + 1;

                if (nextIndex < numberCodeInputs.length) {
                    numberCodeInputs[nextIndex].focus();
                }
            }

            const handleKeyDown = e => {
                const {code, target} = e;

                const currentIndex = Number(target.dataset.numberCodeInput);
                const previousIndex = currentIndex - 1;
                const nextIndex = currentIndex + 1;

                const hasPreviousIndex = previousIndex >= 0;
                const hasNextIndex = nextIndex <= numberCodeInputs.length - 1

                switch (code) {
                    case 'ArrowLeft':
                    case 'ArrowUp':
                        if (hasPreviousIndex) {
                            numberCodeInputs[previousIndex].focus();
                        }
                        e.preventDefault();
                        break;

                    case 'ArrowRight':
                    case 'ArrowDown':
                        if (hasNextIndex) {
                            numberCodeInputs[nextIndex].focus();
                        }
                        e.preventDefault();
                        break;
                    case 'Backspace':
                        if (!e.target.value.length && hasPreviousIndex) {
                            numberCodeInputs[previousIndex].value = null;
                            numberCodeInputs[previousIndex].focus();
                        }
                        break;
                    default:
                        break;
                }
            };

            numberCodeForm.addEventListener('input', handleInput);
            numberCodeForm.addEventListener('keydown', handleKeyDown);
        },
        methods: {
            inputListener() {
                this.$emit('input', this.digitValues.join(""));
            }
        }
    }
</script>

<style scoped>
    input {
        width: 2rem;
        height: 2rem;
        font-size: 1rem;
        text-align: center;
        border: none;
        border-bottom: 3px solid gainsboro !important;
        margin: 0 0.3rem;
        outline: none;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>