<template>
    <div class="uk-grid uk-grid-small uk-grid-match" data-uk-grid>
        <div class="uk-width-1-5">
            <filters :url="url"
                     @filtersChanged="filtersChanged">
                <slot name="filters"></slot>
            </filters>
        </div>
        <div class="uk-width-4-5">
            <div id="paginated-view-content">
                <slot :records="data.data"></slot>
            </div>
            <pagination @pageChanged="pageChanged" :key="paginationRenderKey" :initial-data="data"></pagination>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['fetch-url'],
        data() {
            return {
                data: {},
                paginationRenderKey: 1,
                url: !!this.fetchUrl ? this.fetchUrl : window.location.href,
                embed: !!this.fetchUrl
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
                axios.get(this.url).then((response) => {
                    this.data = response.data;
                    this.paginationRenderKey++;
                }).catch(error => console.log(error.response)).then(() => {
                    Loading.hide();
                })
            }
        }
    }
</script>