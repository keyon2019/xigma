<template>
    <span class="uk-display-inline-block">
        <span dir="ltr" class="uk-flex">
            <span class="star" v-for="i in 5" :class="i <= roundedRating ? 'star-filled' : ''" data-uk-icon="star"></span>
        </span>
    </span>
</template>

<script>
    export default {
        props: {
            rating: {
                default: 0
            }
        },
        data() {
            return {
                roundedRating: Math.round(this.rating)
            }
        }
    }
</script>

<style scoped>

</style>