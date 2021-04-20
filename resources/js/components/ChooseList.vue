<template>
    <div>
        <section class="uk-section-small uk-section-primary">
            <input v-model="keyword" placeholder="جستجو" class="uk-search-input">
        </section>
        <slot :records="filteredData"></slot>
    </div>
</template>

<script>
    export default {
        props: ['data'],
        data() {
            return {
                keyword: ''
            }
        },
        mounted() {
            this.$on('chosen', (record) => {
                this.$emit('chosen', record);
            })
        },
        computed: {
            filteredData() {
                return _.filter(this.data, r => r.name.contains(this.keyword));
            }
        }
    }
</script>

<style scoped>

</style>