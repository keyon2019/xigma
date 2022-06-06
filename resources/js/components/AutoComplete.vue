<template>
    <div class="uk-inline auto-input uk-width-1-1">
        <div class="uk-inline uk-width-1-1">
            <span v-if="isLoading" class="uk-form-icon uk-form-icon-flip" data-uk-spinner="ratio:0.7"></span>
            <input class="uk-input uk-border-rounded" v-model="keyword" :placeholder="placeholder">
            <input type="hidden" :name="name" v-model="realValue">
        </div>
        <div ref="drop" data-uk-dropdown="offset:2;pos:bottom-justify;boundary:.auto-input;boundary-align:true"
             class="uk-border-rounded uk-margin-remove" style="padding: 2px 10px;border:1px solid gainsboro;width:100%;">
            <ul class="uk-nav uk-dropdown-nav uk-nav-default uk-overflow-auto"
                :class="records && records.length > 5 ? 'uk-height-small' : ''">
                <li class="uk-text-truncate"
                    @click="emitValue(r)" v-for="r in records"><a>{{r[search]}}</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            placeholder: {
                default: 'Search'
            },
            search: {
                default: 'name'
            },
            keyName: {
                default: 'search'
            },
            value: {},
            api: {},
            apiResultKey: {
                default: 'result'
            },
            initialInput: {},
            method: {
                default: 'post'
            },
            valueKey: {},
            data: {},
            name: {}
        },
        data() {
            return {
                keyword: '',
                records: this.data || null,
                isLoading: false,
                timeoutHandler: null,
                forShowOnly: false,
                realValue: null,
            }
        },
        beforeMount() {
            if (!!this.initialInput) {
                this.forShowOnly = true;
                this.keyword = this.initialInput;
            }
        },
        methods: {
            fetch() {
                this.isLoading = true;
                let config = {method: this.method, url: this.api};
                if (this.method === 'get') {
                    config.params = {[this.keyName]: this.keyword}
                } else {
                    config.data = {[this.keyName]: this.keyword}
                }
                axios(config).then((response) => {
                    this.records = response.data[this.apiResultKey];
                    UIkit.drop(this.$refs.drop).show();
                }).catch((e) => Toast.message(e.response.data.error).danger().show()).then(() => {
                    this.isLoading = false;
                });
            },
            emitValue(selected) {
                let returnValue = this.valueKey ? selected[this.valueKey] : selected;
                this.realValue = returnValue;
                this.$emit('input', returnValue);
                this.forShowOnly = true;
                this.keyword = selected[this.search];
                UIkit.drop(this.$refs.drop).hide(0);
            },
        },
        watch: {
            keyword(value) {
                if (this.forShowOnly) {
                    this.forShowOnly = false;
                    return;
                }
                if (value === "" || value == null)
                    return;
                if (this.api) {
                    clearTimeout(this.timeoutHandler);
                    this.timeoutHandler = setTimeout(this.fetch, 300);
                }
            }
        }
    }
</script>

<style scoped>

</style>