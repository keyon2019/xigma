<template>
    <div class="uk-padding uk-background-default uk-margin">
        <div class="uk-text-right">
            <span v-if="isEditing" class="clickable uk-text-danger" @click="deleteVariation" data-uk-icon="close"></span>
            <span class="clickable" @click="isEditing = !isEditing" :data-uk-icon="isEditing ? 'unlock' : 'lock'"></span>
        </div>
        <hr/>
        <form-variation @submit="updateVariation" :values="variation.values" :options="options" :pictures="pictures"
                        :disabled="!isEditing"
                        button-text="ویرایش"
                        button-class="uk-button-secondary"
                        :variation="variation"></form-variation>
    </div>
</template>

<script>
    export default {
        props: ['variation', 'pictures', 'options'],
        data() {
            return {
                isEditing: false,
            }
        },
        methods: {
            deleteVariation() {
                UIkit.modal.confirm("از حذف اطمینان دارید؟").then(() => {
                    Loading.show();
                    axios.post(`/dashboard/variation/${this.variation.id}`, (new Form()).asFormData('delete')).then(() => {
                        Toast.message("Variation Deleted Successfully").success().show();
                        this.$emit('deleted', this.variation);
                    }).catch((e) => {
                        console.log(e);
                    }).then(() => {
                        Loading.hide();
                    });
                })
            },
            updateVariation(form) {
                Loading.show();
                axios.post(`/dashboard/variation/${this.variation.id}`, form.asFormData('patch')).then(() => {
                    Toast.message("Variation Updated Successfully").success().show();
                    this.isEditing = false;
                }).catch((e) => console.log(e)).then(() => Loading.hide());
            }
        }
    }
</script>

<style scoped>

</style>