<template>
    <div>
        <div class="clickable" @click="toggle">
            <span :class="titleClass" v-if="!this.$slots.title" v-html="title"></span>
            <slot name="title"></slot>
            <span v-if="showChevron" :class="titleClass" class="uk-margin-small-left hidden-in-print" :uk-icon="show ? 'chevron-down' : 'chevron-left'"></span>
        </div>
        <div v-show="show">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {'title': {}, 'open': {default : false}, 'title-class': {}, 'show-chevron' : {default: true}},
        data() {
            return {
                show: this.open,
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