<template>
    <div>
        <div v-if="showForm" class="uk-grid uk-grid-small" data-uk-grid>
            <div class="uk-width-1-2">
                <label class="uk-form-label">نام و نام خانوادگی</label>
                <div class="">
                    <input name="name" v-model="form.name.value"
                           class="uk-input uk-background-muted uk-border-rounded" type="text">
                </div>
                <div v-if="form.errors.has('name')"
                     class="uk-text-danger uk-text-small">{{form.errors['name']}}
                </div>
            </div>
            <div class="uk-width-1-2">
                <label class="uk-form-label">شماره همراه</label>
                <div class="">
                    <input v-model="form.mobile.value" name="mobile" class="uk-input uk-background-muted uk-border-rounded"
                           type="number">
                </div>
                <div v-if="form.errors.has('mobile')"
                     class="uk-text-danger uk-text-small">{{form.errors['mobile']}}
                </div>
            </div>
            <div class="uk-width-1-1">
                <label class="uk-form-label">موضوع</label>
                <div class="">
                    <input name="title" v-model="form.title.value" class="uk-input uk-background-muted uk-border-rounded"
                           type="text">
                </div>
                <div v-if="form.errors.has('title')"
                     class="uk-text-danger uk-text-small">{{form.errors['title']}}
                </div>
            </div>
            <div class="uk-width-1-1">
                <label class="uk-form-label">متن پیام</label>
                <div class="">
                    <textarea name="content" v-model="form.content.value" rows="5"
                              class="uk-textarea uk-background-muted uk-border-rounded"></textarea>
                </div>
                <div v-if="form.errors.has('content')"
                     class="uk-text-danger uk-text-small">{{form.errors['content']}}
                </div>
            </div>
            <div class="uk-width-1-1">
                <button @click="submit()" class="uk-float-right uk-button uk-button-success uk-border-rounded uk-text-white">
                    ارسال
                </button>
            </div>
        </div>
        <div v-else>با تشکر از پیام شما در اسرع وقت به آن پاسخ داده خواهد شد</div>
    </div>
</template>

<script>
    export default {
        name: "Contact",
        data() {
            return {
                showForm: true,
                form: new Form({
                    name: {
                        value: "",
                        rules: "required|string"
                    },
                    mobile: {
                        value: "",
                        rules: "required|numeric"
                    },
                    title: {
                        value: "",
                        rules: "required|string"
                    },
                    content: {
                        value: "",
                        rules: 'required|string'
                    }
                })
            }
        },
        methods: {
            submit() {
                if (this.form.validate()) {
                    Loading.show();
                    axios.post('/contact', this.form.asFormData()).then(() => {
                        this.showForm = false;
                        Toast.message("پیام شما با موفقیت ثبت شد").success().show();
                    }).catch((e) => Toast.message(this.getErrorMessage(e)).danger().show())
                        .then(() => Loading.hide());
                }
            }
        }
    }
</script>

<style scoped>

</style>