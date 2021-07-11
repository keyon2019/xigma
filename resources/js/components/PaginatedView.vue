<template>
    <div class="uk-grid uk-grid-small" data-uk-grid>
        <div v-if="!filterless" class="uk-width-1-5 uk-width-visible@m">
            <filters :url="url"
                     @filtersChanged="filtersChanged">
                <slot name="filters"></slot>
            </filters>
        </div>
        <div class="uk-width-visible@m" :class="filterless ? 'uk-width-expand' : 'uk-width-4-5'">
            <sort @sortsChanged="sortsChanged" :url="url">
                <slot name="sort"></slot>
            </sort>
            <div id="paginated-view-content">
                <slot :records="data.data"></slot>
            </div>
            <pagination @pageChanged="pageChanged" :key="paginationRenderKey" :initial-data="data"></pagination>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['fetch-url', 'filterless'],
        data() {
            return {
                data: {},
                paginationRenderKey: 1,
                url: !!this.fetchUrl ? this.fetchUrl : window.location.href,
                embed: !!this.fetchUrl,
                initialFetch: true,
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
        methods: {
            pageChanged(page) {
                const url = new URL(this.url, window.location.origin);
                url.searchParams.set('page', page);
                if (!this.embed)
                    window.history.pushState({}, '', url);
                this.url = url;
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
                this.url = url;
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
                this.url = url;
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
                    this.data = response.data;
                    this.paginationRenderKey++;
                    if (!this.initialFetch) {
                        this.$emit('fetched');
                    } else {
                        this.initialFetch = false;
                    }
                }).catch(error => console.log(error.response)).then(() => {
                    Loading.hide();
                })
            },
            destroy(id) {
                const index = _.findIndex(this.data.data, r => r.id === id);
                this.data.data.splice(index, 1);
            }
        }
    }
</script>