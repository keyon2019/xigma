<template>
    <div v-if="!!this.$slots.default">
        <form @submit.prevent="apply()" ref="form">
            <slot></slot>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['url'],
        methods: {
            apply() {
                let formData = new FormData(this.$refs.form);
                this.$emit('filtersChanged', formData);
            }
        },
        mounted() {
            const urlParams = new URLSearchParams((new URL(this.url, document.baseURI)).search);
            let keyValuePairs = {};
            for (let pair of urlParams.entries()) {
                keyValuePairs[pair[0]] = pair[1];
                console.log(pair[0], pair[1]);
            }
            if (this.$refs.form)
                _.forEach(this.$refs.form.elements, (inputField) => {
                    if (_.keys(keyValuePairs).includes(inputField.getAttribute('name'))) {
                        if (inputField.getAttribute('type') === 'text')
                            inputField.value = keyValuePairs[inputField.getAttribute('name')];
                        else {
                            if (inputField.value == keyValuePairs[inputField.getAttribute('name')])
                            // console.log(inputField.value, keyValuePairs[inputField.getAttribute('name')]);
                                inputField.setAttribute('checked', "")
                        }
                    }
                });
        }
    }
</script>

<style scoped>

</style>