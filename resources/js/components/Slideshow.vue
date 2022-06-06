<template>
    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" :uk-slideshow="'index:' + index + ';ratio:1:1;max-height:600px;'">
        <ul class="uk-slideshow-items">
            <li v-for="image in images">
                <img class="uk-background-default" :src="image" alt="" uk-cover>
            </li>
        </ul>
        <a class="uk-position-center-left-out uk-position-small" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
        <a class="uk-position-center-right-out uk-position-small" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
    </div>
</template>

<script>
    export default {
        props: ['images', 'index']
    }
</script>

<style scoped>

</style>