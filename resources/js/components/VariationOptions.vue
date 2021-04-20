<template>
    <div class="uk-grid uk-child-width-1-4" data-uk-grid>
        <div v-for="option in options">
            <label class="uk-form-label">{{option.name}}</label>
            <div class="uk-form-controls">
                <select @change="$emit('input', selectedOptions)" class="uk-select" v-model="selectedOptions[option.id]">
                    <option disabled value="">انتخاب کنید</option>
                    <option v-for="value in option.values" :value="value.id">{{value.name}}</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['options'],
        data() {
            return {
                form: new Form({}),
                selectedOptions: {}
            }
        },
    }
</script>

<style scoped>

</style>