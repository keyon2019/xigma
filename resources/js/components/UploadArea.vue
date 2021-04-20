<template>
    <div>
        <div class="js-upload uk-placeholder uk-text-center" ref="upload">
            <span data-uk-icon="icon: cloud-upload"></span>
            <span class="uk-text-middle">برای بارگزاری، عکس‌ها را اینجا بی‌اندازید یا </span>
            <div data-uk-form-custom>
                <input type="file">
                <span class="uk-link">کلیک کنید</span>
            </div>
        </div>
        <progress ref="bar" class="uk-progress" value="0" max="100" hidden></progress>
    </div>
</template>

<script>
    export default {
        props: ['url', 'id', 'type'],
        mounted() {
            let bar = this.$refs.bar;
            let comp = this;
            let id = this.id;
            let type = this.type.charAt(0).toUpperCase() + this.type.slice(1);
            UIkit.upload(this.$refs.upload, {
                url: this.url,
                name: 'file',
                error: function () {
                    console.log('load', arguments);
                },
                beforeSend: function (e) {
                    e.data.append('_token', CSRF);
                    e.data.append('picturable_id', id);
                    e.data.append('picturable_type', `App\\Models\\${type}`)
                },
                loadStart: function (e) {
                    bar.removeAttribute('hidden');
                    bar.max = e.total;
                    bar.value = e.loaded;
                },
                complete: function () {
                    let data = JSON.parse(arguments[0].response);
                    comp.$emit('uploaded', data.picture);
                    Event.$emit('picture-uploaded', data.picture)
                },
                progress: function (e) {
                    bar.max = e.total;
                    bar.value = e.loaded;
                },
                loadEnd: function (e) {
                    bar.max = e.total;
                    bar.value = e.loaded;
                },
                completeAll: function () {
                    setTimeout(bar.setAttribute('hidden', ''), 1000)
                }
            })
        }
    }
</script>

<style scoped>

</style>