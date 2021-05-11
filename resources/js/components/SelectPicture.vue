<template>
    <div class="uk-width-expand" :disabled="disabled">
        <div :class="{'clickable' : !disabled}" @click="disabled ? '' : galleryModal.show()">
            <img v-if="value && src" :src="src" class="uk-width-expand uk-border-rounded" alt="">
            <placeholder v-else>انتخاب عکس</placeholder>
        </div>
        <modal @selected="selected" :name="name">
            <gallery :initial-pictures="pictures"></gallery>
        </modal>
    </div>
</template>

<script>
    export default {
        props: ['pictures', 'value', 'disabled'],
        data() {
            return {
                galleryModal: null,
            }
        },
        mounted() {
            this.galleryModal = new Modal(this.name);
        },
        methods: {
            selected(picture) {
                this.$emit('input', picture.id);
                this.galleryModal.close();
            }
        },
        computed: {
            src() {
                if (this.value)
                    return _.find(this.pictures, p => p.id === this.value).url ?? null;
                return "";
            },
            name() {
                return `gallery-${Math.random()}`
            }
        }
    }
</script>

<style scoped>

</style>