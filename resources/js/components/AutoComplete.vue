<template>
    <div class="uk-inline autoinput uk-width-1-1">
        <div class="uk-inline uk-width-1-1">
            <span v-if="isLoading" class="uk-form-icon uk-form-icon-flip" data-uk-spinner="ratio:0.7"></span>
            <input class="uk-input uk-border-rounded" v-model="keyword" :placeholder="placeholder">
        </div>
        <div ref="drop" data-uk-dropdown="offset:2;pos:bottom-justify;boundary:.autoinput;boundary-align:true"
             class="uk-border-rounded uk-margin-remove" style="padding: 2px 10px;">
            <ul class="uk-nav uk-dropdown-nav uk-nav-default uk-overflow-auto"
                :class="records && records.length > 5 ? 'uk-height-small' : ''">
                <li class="uk-text-truncate"
                    @click="emitValue(valueKey ? r[valueKey] : r)" v-for="r in records"><a>{{r[search]}}</a></li>
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
            value: {},
            api: {},
            apiResultKey: {
                default: 'result'
            },
            valueKey: {},
            data: {},
        },
        data() {
            return {
                keyword: '',
                records: this.data || null,
                isLoading: false,
                timeoutHandler: null,
                forShowOnly: false,
            }
        },
        methods: {
            fetch() {
                this.isLoading = true;
                axios.post(this.api, {keyword: this.keyword}).then((response) => {
                    this.records = response.data[this.apiResultKey];
                    UIkit.drop(this.$refs.drop).show();
                }).catch((e) => Toast.message(e.response.data.error).danger().show()).then(() => {
                    this.isLoading = false;
                });
            },
            emitValue(value) {
                this.$emit('input', value);
                this.forShowOnly = true;
                this.keyword = value[this.search];
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
                    this.timeoutHandler = setTimeout(this.fetch, 1000);
                }
            }
        }
    }
</script>

<style scoped>

</style>