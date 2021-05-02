<template>
    <div>
        <form-option button-text="ویرایش" button-class="uk-button-secondary uk-border-rounded" :option="option"
                     @submit="submit"></form-option>
        <div class="uk-padding-small uk-background-default uk-margin-top uk-border-rounded uk-box-shadow-small">
            <div>مقادیر فیلتر</div>
            <hr class="uk-margin-small"/>
            <div v-for="value in option.values" class="uk-margin-small">
                <input class="uk-input uk-border-rounded uk-width-large uk-display-inline-block" :disabled="!value.isEditing"
                       v-model="value.name">
                <div class="uk-width-small uk-display-inline-block uk-margin-left">
                    <a @click="value.isEditing ? updateValue(value) : $set(value, 'isEditing', !value.isEditing)"
                       class="uk-icon-link uk-margin-small-right" :data-uk-icon="value.isEditing ? 'check' : 'pencil'"
                       data-uk-tooltip="ویرایش"></a>
                    <a @click="deleteValue(value)"
                       class="uk-icon-link uk-text-danger" data-uk-icon="close" data-uk-tooltip="حذف مقدار"></a>
                </div>
            </div>
            <input class="uk-input uk-border-rounded uk-width-large uk-display-inline-block" v-model="form.name.value"
                   placeholder="مقدار جدید">
            <div class="uk-width-small uk-display-inline-block uk-margin-left">
                <a @click="attach"
                   class="uk-icon-link" data-uk-icon="plus" data-uk-tooltip="افزودن"></a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['initial-option'],
        data() {
            return {
                form: new Form({
                    name: {
                        value: '',
                        rules: 'required|string'
                    },
                    option_id: {
                        value: this.initialOption.id,
                        rules: 'required|numeric'
                    }
                }),
                option: this.initialOption
            }
        },
        methods: {
            submit(form) {
                Loading.show();
                axios.post(`/dashboard/option/${this.option.id}`, form.asFormData('patch')).then((response) => {
                    Toast.message("فیلتر با موفقیت بروزرسانی شد").success().show();
                }).catch((error) => {
                    Toast.message("خطا در بروزرسانی فیلتر").danger().show();
                }).then(() => {
                    Loading.close();
                })
            },
            attach() {
                if (this.form.validate()) {
                    Loading.show();
                    axios.post(`/dashboard/value`, this.form.asFormData()).then((response) => {
                        this.option.values.push(response.data.value);
                        Toast.message('مقدار جدید با موفقیت اضافه شد').success().show();
                        this.form.name.value = '';
                    }).catch(() => Toast.message('افزودن مقدار با خطا مواجه شد').danger().show()).then(() => {
                        Loading.hide();
                    });
                }
            },
            updateValue(value) {
                Loading.show();
                axios.post(`/dashboard/value/${value.id}`, {name: value.name, '_method': 'patch'}).then(() => {
                    Toast.message('بروزرسانی مقدار با موفقیت انجام شد').success().show();
                    value.isEditing = false;
                }).catch(() => Toast.message('بروزسانی مقدار با خطا مواجه شد').danger().show()).then(() => {
                    Loading.hide();
                });
            },
            deleteValue(value) {
                Loading.show();
                axios.post(`/dashboard/value/${value.id}`, {'_method': 'delete'}).then(() => {
                    const vIndex = _.findIndex(this.option.values, v => v.id === value.id);
                    this.option.values.splice(vIndex, 1);
                    Toast.message('مقدار با موفقیت حذف شد').success().show();
                }).catch(() => Toast.message('حذف مقدار با خطا مواجه شد').danger().show()).then(() => {
                    Loading.hide();
                });
            }
        }
    }
</script>

<style scoped>

</style>