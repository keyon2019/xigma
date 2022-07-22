<template>
    <div class="uk-grid uk-grid-small" data-uk-grid>
        <filters :manual="manual" ref="filters" :url="url" class="uk-width-1-5 uk-visible@m"
                 @filtersChanged="filtersChanged">
            <slot name="filters"></slot>
        </filters>
        <div class="uk-width-expand">
            <sort @sortsChanged="sortsChanged" class="uk-visible@m" :url="url">
                <slot name="sort"></slot>
            </sort>
            <div v-if="!!$slots['filters'] || !!$slots['sort']" class="uk-text-small uk-hidden@m hidden-in-print">
                <a v-if="!!$slots['filters']" @click="showFiltersModal()" class="uk-link-reset"><span class="uk-margin-small-right"><i
                        class="fa-solid fa-sliders"></i> فیلتر</span></a>
                <a v-if="!!$slots['sort']" class="uk-link-reset"><span><i class="fa-solid fa-arrow-down-wide-short"></i> ترتیب نمایش</span></a>
                <hr class="uk-margin-small"/>
            </div>
            <div id="paginated-view-content">
                <slot :records="tableItems" :otherData="otherData"></slot>
            </div>
            <pagination v-if="!singlePage"
                        :limit="2" @pagination-change-page="pageChanged" :key="paginationRenderKey" :data="data"></pagination>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            'fetch-url': {},
            'data-key': {
                default: null,
            },
            'single-page': {
                default: false,
            },
            'manual': {
                default: false,
            }
        },
        data() {
            return {
                data: {},
                paginationRenderKey: 1,
                url: !!this.fetchUrl ? this.fetchUrl : window.location.href,
                embed: !!this.fetchUrl,
                initialFetch: true,
                filtersModal: new Modal('filters-modal'),
                sortsModal: new Modal('sorts-modal'),
                otherData: {}
            }
        },
        mounted() {
            this.fetch();
            if (!this.embed) {
                window.addEventListener('popstate', () => {
                    this.url = window.location.href;
                    this.fetch();
                });
            }
        },
        computed: {
            tableItems() {
                return this.singlePage ? this.data : this.data.data;
            }
        },
        methods: {
            pageChanged(page) {
                const url = new URL(this.url, window.location.origin);
                url.searchParams.set('page', page);
                if (!this.embed)
                    window.history.pushState({}, '', url);
                this.url = url.href;
                this.fetch();
            },
            filtersChanged(formData) {
                const url = new URL(this.url, window.location.origin);
                url.search = "";
                for (let pair of formData.entries()) {
                    url.searchParams.append(pair[0], pair[1]);
                }
                url.searchParams.set('page', 1);
                if (!this.embed)
                    window.history.pushState({}, '', url);
                this.url = url.href;
                this.fetch();
            },
            sortsChanged(formData) {
                const url = new URL(this.url, window.location.origin);
                for (let pair of formData.entries()) {
                    if (pair[1] == null || pair[1] === '' || pair[1] === undefined) {
                        url.searchParams.delete(pair[0]);
                    } else {
                        url.searchParams.set(pair[0], pair[1]);
                    }
                }
                url.searchParams.set('page', 1);
                if (!this.embed)
                    window.history.pushState({}, '', url);
                this.url = url.href;
                this.fetch();
            },
            fetch() {
                Loading.show();
                var url = "";
                if (this.url.indexOf('http://') === 0 || this.url.indexOf('https://') === 0)
                    url = new URL(this.url);
                else
                    url = new URL(`${window.location.origin}${this.url}`);
                url.searchParams.set('json', '');
                axios.get(url).then((response) => {
                    this.data = this.dataKey ? response.data[this.dataKey] : response.data;
                    this.otherData = response.data;
                    this.paginationRenderKey++;
                    if (!this.initialFetch) {
                        this.$emit('fetched');
                    } else {
                        this.initialFetch = false;
                    }
                }).catch(error => console.log(error.response)).then(() => {
                    Loading.hide();
                    this.$refs.filters.isSubmitting = false;
                })
            },
            add(object) {
                this.data.data.unshift(object);
            },
            destroy(id) {
                const index = _.findIndex(this.data.data, r => r.id === id);
                this.data.data.splice(index, 1);
            },
            showFiltersModal() {
                UIkit.modal('#filters-modal').show();
            }
        }
    }
</script>