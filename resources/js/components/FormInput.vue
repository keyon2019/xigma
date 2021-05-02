<template>
    <div>
        <label class="uk-form-label">{{label}}</label>
        <div class="uk-form-controls">
            <component v-if="['input','textarea'].includes(type)" :is="type" :name="name" :placeholder="label" :value.prop="value"
                       :rows="rows"
                       class="uk-border-rounded"
                       @input="$emit('input', $event.target.value)"
                       :class="[errors.has(name) ? 'uk-form-danger' : '', classes ? classes : '']"></component>
            <div v-if="errors.has(name)"
                 class="uk-text-danger uk-text-small">{{errors[name]}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['errors', 'label', 'name', 'type', 'classes', 'value', 'rows', 'options'],
    }
</script>

<style scoped>

</style>