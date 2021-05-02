<template>
    <div class="uk-grid uk-child-width-expand uk-grid-small" data-uk-grid>
        <div v-for="option in options">
            <label class="uk-form-label">{{option.name}}</label>
            <div class="uk-form-controls">
                <select @change="$emit('input', selectedOptions)" class="uk-select uk-border-rounded"
                        v-model="selectedOptions[option.id]">
                    <option disabled :value="undefined">انتخاب کنید</option>
                    <option v-for="value in option.values"
                            :value="value.id">{{value.name}}
                    </option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['options', 'values'],
        data() {
            return {
                selectedOptions: {}
            }
        },
        mounted() {
            if (this.values) {
                _.forEach(this.values, v => this.$set(this.selectedOptions, v.option_id, v.id));
            }
        }
    }
</script>

<style scoped>

</style>