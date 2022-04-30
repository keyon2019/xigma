<template>
    <div>
        <div class="clickable" @click="toggle">
            <span v-if="!this.$slots.title">{{title}}</span>
            <slot name="title"></slot>
            <span class="uk-margin-small-left" :uk-icon="show ? 'chevron-down' : 'chevron-left'"></span>
        </div>
        <div v-show="show">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title'],
        data() {
            return {
                show: false,
            }
        },
        methods: {
            toggle() {
                this.show = !this.show;
            }
        }
    }
</script>

<style scoped>

</style>