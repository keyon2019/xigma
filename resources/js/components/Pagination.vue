<template>
    <div>
        <ul class="uk-pagination uk-margin">
            <li @click="changePage(paginationData.current_page - 1)"
                :class="{'uk-disabled' : paginationData.prev_page_url == null}"><a><span data-uk-pagination-next></span></a></li>

            <li v-if="n + offset <= length" v-for="n in length || 0"
                :class="{'uk-active' : paginationData.current_page === n + offset}">
                <a @click="changePage(n + offset)">{{n + offset}}</a>
            </li>

            <li @click="changePage(paginationData.current_page + 1)"
                :class="{'uk-disabled' : paginationData.next_page_url == null}"><a><span data-uk-pagination-previous></span></a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['initial-data'],
        data() {
            return {
                paginationData: this.initialData,
            }
        },
        methods: {
            changePage(n) {
                if (this.paginationData.current_page === n)
                    return;
                this.paginationData.current_page = n;
                this.$emit('pageChanged', n);
            }
        },
        computed: {
            length() {
                return Math.min(this.paginationData.last_page, 11);
            },
            offset() {
                return this.paginationData.current_page <= 5 ? 0 : this.paginationData.current_page - 5;
            }
        }
    }
</script>

<style scoped>

</style>