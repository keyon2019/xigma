<template>
    <form-container :button-class="buttonClass" :button-text="buttonText"
                    @input="form.errors.clear($event.target.name)" @submit="submit()">
        <div class="uk-grid" data-uk-grid>
            <div class="uk-width-expand">
                <div class="uk-grid uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-1">
                        <form-input label="نام وسیله نقیله" classes="uk-input"
                                    type="input"
                                    name="name"
                                    :errors="form.errors"
                                    v-model="form.name.value">
                        </form-input>
                    </div>
                    <div class="uk-width-1-1">
                        <label class="uk-form-label">توضیحات</label>
                        <div class="uk-form-controls">
                            <form-input type="textarea" :errors="form.errors"
                                        rows="6" label="توضیحات وسیله نقلیه" placeholder="توضیحات وسیله نقلیه" classes="uk-textarea" name="description"
                                        v-model="form.description.value">
                            </form-input>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="vehicle" class="uk-width-1-3@m">
                <div class="uk-form-label">&nbsp;</div>
                <select-picture :pictures="vehicle.pictures" v-model="form.splash.value"></select-picture>
            </div>
        </div>
    </form-container>
</template>

<script>

    export default {
        props: ['vehicle', 'button-class', 'button-text'],
        data() {
            return {
                form: new Form({
                    name: {
                        value: '',
                        rules: 'required|string'
                    },
                    description: {
                        value: '',
                        rules: 'string',
                    },
                    splash: {
                        value: null,
                        rules: 'numeric'
                    },
                }),
            }
        },
        mounted() {
            if (this.vehicle) {
                this.form.fill(this.vehicle);
            }
        },
        methods: {
            submit() {
                if (this.form.validate()) {
                    this.$emit('submit', this.form);
                }
            },
        }
    }
</script>

<style scoped>

</style>