<template>
    <div class="uk-display-inline-block" :class="disabled ? 'uk-background-muted' : ''">
        <div class="uk-flex uk-flex-middle" style="padding: 8px 15px;">
            <div><span :class="!disabled ? 'clickable' : ''" @click="increment()"
                       data-uk-icon="icon:plus;ratio:0.75"></span></div>
            <div class="uk-padding-small uk-padding-remove-vertical uk-text-success uk-flex-1"
                 style="min-width: 20px;text-align: center;">
                {{count}}
            </div>
            <div><span :class="!disabled ? 'clickable' : ''" @click="decrement()" data-uk-icon="icon:minus;ratio:0.75"></span>
            </div>
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
            },
            min: {
                default: 1,
            },
            max: {
                default: 12,
            },
            disabled: {
                default: false,
            },
            step: {
                default: 1,
            },
            'increment-disabled': {
                default: false
            },
            'decrement-disabled': {
                default: false
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
                if (this.disabled || this.incrementDisabled)
                    return;
                if (this.count >= this.max || this.count + this.step > this.max)
                    return;
                this.count = parseInt(this.count) + parseInt(this.step);
                this.incremented = true;
                this.$emit('input', this.count);
            },
            decrement() {
                if (this.disabled)
                    return;
                if (this.count <= this.min || this.count - this.step < this.min)
                    return;
                this.count = parseInt(this.count) - parseInt(this.step);
                this.incremented = false;
                this.$emit('input', this.count);
            }
        }
    }
</script>

<style scoped>

</style>