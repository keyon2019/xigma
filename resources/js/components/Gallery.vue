<template>
    <div>
        <div v-if="pictures.length > 0" class="uk-grid uk-child-width-1-5@m" data-uk-grid>
            <div v-for="picture in pictures">
                <div class="uk-position-relative uk-visible-toggle">
                    <div uk-tooltip="حذف تصویر" @click.stop="deletePicture(picture)" uk-close
                         class="uk-text-danger clickable uk-position-absolute uk-position-top-left uk-margin-small-top uk-margin-small-left uk-hidden-hover"></div>
                    <img @click="select(picture)" alt="" :src="picture.url"
                         class="uk-width-expand uk-border-rounded clickable">
                </div>
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
            },
            deletePicture(picture) {
                if (confirm("آیا از حذف تصویر اطمینان دارید؟")) {
                    Loading.show();
                    axios.post(`/dashboard/picture/${picture.id}`, {_method: 'delete'}).then(() => {
                        const index = _.findIndex(this.pictures, p => p.id === picture.id);
                        this.pictures.splice(index, 1);
                        Toast.message("تصویر با موفقیت حذف شد").success().show();
                    }).catch((e) => Toast.message(e.response.data.message).danger().show())
                        .then(() => Loading.hide());
                }
            }
        }
    }
</script>

<style scoped>

</style>