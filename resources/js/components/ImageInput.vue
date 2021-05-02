<template>
    <div @click="select()" class="imageInput">
        <div v-if="!value" :style="'height: ' + (height ? height + 'px' : '100%')"
             style="width: 100%;border-radius: 10px;border: 1px solid gainsboro;"
             class="uk-background-muted uk-position-relative">
            <div class="uk-position-absolute uk-position-center uk-text-center">
                <i data-uk-icon="icon: image; ratio:1.5" class="uk-text-meta"></i>
                <p class="uk-margin-remove uk-text-small uk-text-meta">{{placeholder || 'انتخاب عکس'}}</p>
            </div>
        </div>
        <div class="uk-height-1-1" v-else>
            <img alt="" class="uk-img uk-height-1-1 uk-width-expand" style="object-fit: cover;object-position: center"
                 data-uk-img :src="src">
        </div>
        <input type="file" class="uk-hidden" :name="name" :ref="'file'" @change="fileSelected($event)">
    </div>
</template>

<script>
    export default {
        props: ['name', 'height', 'value', 'placeholder'],
        methods: {
            select() {
                this.$refs.file.click();
            },
            fileSelected(event) {
                this.$emit('input', event.target.files[0]);
                this.value = event.target.files[0];
            }
        },
        computed: {
            src() {
                if (this.value instanceof Blob) {
                    return URL.createObjectURL(this.value);
                }
                return this.value !== '' ? this.value : '/uploads/placeholder.jpg';
            }
        }
    }
</script>

<style scoped>
    .imageInput {
        width: 100%;
        height: 100%;
        cursor: pointer;
        position: relative;
        min-height: 300px;
    }

    .uk-img {
        object-position: center;
        object-fit: cover;
        width: 100%;
        border-radius: 10px;
    }
</style>