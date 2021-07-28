<template>
    <div>
        <input class="uk-input uk-border-rounded" :placeholder="placeholder" v-model="commaSeparatedValue">
        <input type="hidden" v-model="realValue" :name="name">
    </div>
</template>

<script>
    export default {
        props: ['value', 'placeholder', 'name'],
        data() {
            return {
                commaSeparatedValue: this.value,
                realValue: null,
            }
        },
        watch: {
            value: {
                immediate: true,
                handler: function (newValue) {
                    this.commaSeparatedValue = newValue;
                }
            },
            commaSeparatedValue: {
                immediate: true,
                handler: function (newValue) {
                    const realV = parseInt(String(newValue).replace(/\D/g, ""));
                    if (isNaN(realV)) {
                        this.commaSeparatedValue = '';
                        this.$emit('input', null);
                        return;
                    }
                    this.realValue = realV;
                    this.$emit('input', realV);
                    Vue.nextTick(() => {
                        this.commaSeparatedValue = realV.toLocaleString();
                    });
                }
            }
        }
    }
</script>

<style scoped>

</style>