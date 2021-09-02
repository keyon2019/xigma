<template>
    <div class="uk-display-inline-block">
        <div class="uk-flex uk-flex-middle" style="padding: 8px 15px;">
            <div><span :class="incremented === true ? 'uk-text-success' : ''" class="clickable" @click="increment()" data-uk-icon="icon:plus;ratio:0.75"></span></div>
            <div class="uk-padding-small uk-padding-remove-vertical uk-text-success" style="min-width: 20px;text-align: center;">{{count}}</div>
            <div><span class="clickable" @click="decrement()" data-uk-icon="icon:minus;ratio:0.75"></span></div>
            <input :name="name" v-model="this.count" type="hidden">
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                default: 1,
            },
            name: {
                default: 'quantity'
            }
        },
        data() {
            return {
                incremented: null,
                count: this.value
            }
        },
        methods: {
            increment() {
                this.count++;
                this.incremented = true;
                this.$emit('input', this.count);
            },
            decrement() {
                if (this.count > 1)
                    this.count--;
                this.incremented = false;
                this.$emit('input', this.count);
            }
        }
    }
</script>

<style scoped>

</style>