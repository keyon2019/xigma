<template>
    <renderless-laravel-vue-pagination
            :data="data"
            :limit="limit"
            :show-disabled="showDisabled"
            v-on:pagination-change-page="onPaginationChangePage">

        <ul class="uk-pagination"
            v-if="computed.total > computed.perPage"
            slot-scope="{ data, limit, showDisabled, size, align, computed, prevButtonEvents, nextButtonEvents, pageButtonEvents }">

            <li :class="{'disabled': !computed.prevPageUrl}" v-if="computed.prevPageUrl || showDisabled">
                <a class="page-link" href="#" aria-label="Previous" :tabindex="!computed.prevPageUrl && -1"
                   v-on="prevButtonEvents">
                    <slot name="prev-nav">
                        <span data-uk-pagination-next></span>
                    </slot>
                </a>
            </li>

            <li v-for="(page, key) in computed.pageRange" :key="key" :class="{ 'uk-active': page == computed.currentPage }">
                <a href="#" v-on="pageButtonEvents(page)">
                    {{ page }}
                </a>
            </li>

            <li class="page-item pagination-next-nav" :class="{'disabled': !computed.nextPageUrl}"
                v-if="computed.nextPageUrl || showDisabled">
                <a href="#" :tabindex="!computed.nextPageUrl && -1" v-on="nextButtonEvents">
                    <slot name="next-nav">
                        <span data-uk-pagination-previous></span>
                    </slot>
                </a>
            </li>

        </ul>

    </renderless-laravel-vue-pagination>
</template>

<script>
    import RenderlessLaravelVuePagination from './RenderlessLaravelVuePagination.vue';

    export default {
        props: {
            data: {
                type: Object,
                default: () => {}
            },
            limit: {
                type: Number,
                default: 1
            },
            showDisabled: {
                type: Boolean,
                default: false
            }
        },

        methods: {
            onPaginationChangePage(page) {
                this.$emit('pagination-change-page', page);
            }
        },

        components: {
            RenderlessLaravelVuePagination
        }
    }
</script>