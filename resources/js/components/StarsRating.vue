<template>
    <span class="uk-display-inline-block">
        <span dir="ltr" class="uk-flex">
            <span @click="setRating(i)" class="star" v-for="i in 5"
                  :class="[i <= roundedRating ? 'star-filled' : '', interactive ? 'clickable' : '']"
                  :data-uk-icon="'icon:star;ratio:' + size"></span>
        </span>
    </span>
</template>

<script>
    export default {
        props: {
            rating: {
                default: 0
            },
            size: {
                default: 1
            },
            interactive: {
                default: false
            },
        },
        data() {
            return {
                roundedRating: Math.round(this.rating)
            }
        },
        methods: {
            setRating(i) {
                if (!this.interactive)
                    return;
                this.roundedRating = i;
                this.$emit('input', i);
            }
        }
    }
</script>

<style scoped>

</style>