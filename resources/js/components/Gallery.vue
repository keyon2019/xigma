<template>
    <div>
        <div v-if="pictures.length > 0" class="uk-grid uk-child-width-1-5@m" data-uk-grid>
            <div v-for="picture in pictures">
                <img @click="select(picture)" alt="" :src="'/' + picture.path"
                     class="uk-width-expand uk-border-rounded clickable">
            </div>
        </div>
        <div v-else class="uk-text-center">
            <p class="uk-padding">هیچ تصویری برای این محصول بارگزاری نشده است</p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['initial-pictures'],
        data() {
            return {
                pictures: this.initialPictures
            }
        },
        methods: {
            select(picture) {
                this.$emit('selected', picture);
                this.$parent.$emit('escalate-selected', picture);
            }
        }
    }
</script>

<style scoped>

</style>