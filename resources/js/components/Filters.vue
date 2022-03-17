<template>
    <div v-if="!!this.$slots.default">
        <form @submit.prevent="apply('form')" @change="apply('form')" ref="form">
            <slot></slot>
        </form>
        <div id="filters-modal" class="uk-modal-full" name="filters-modal" uk-modal>
            <div class="uk-modal-dialog uk-height-1-1">
                <div class="uk-background-default uk-height-1-1 uk-padding-small my-container">
                    <div class="header">
                        <div>
                        <span><a class="uk-link-reset uk-margin-small-right" uk-toggle="target: #filters-modal"><i
                                class="fa-solid fa-xmark"></i></a> فیلترها</span>
                        </div>
                        <hr/>
                    </div>
                    <div class="content">
                        <form @submit.prevent="apply()" @change="apply('mobile-form')" ref="mobile-form">
                            <slot></slot>
                        </form>
                    </div>
                    <div class="footer">

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['url'],
        data() {
            return {
                isSubmitting: false,
            }
        },
        methods: {
            apply(ref) {
                if (!this.isSubmitting) {
                    this.isSubmitting = true;
                    let formData = new FormData(this.$refs[ref]);
                    this.$emit('filtersChanged', formData);
                }
            }
        },
        mounted() {
            const urlParams = new URLSearchParams((new URL(this.url, document.baseURI)).search);
            let keyValuePairs = {};
            for (let pair of urlParams.entries()) {
                keyValuePairs[pair[0]] = pair[1];
            }
            if (this.$refs.form)
                _.forEach(this.$refs.form.elements, (inputField) => {
                    if (_.keys(keyValuePairs).includes(inputField.getAttribute('name'))) {
                        if (inputField.getAttribute('type') === 'text')
                            inputField.value = keyValuePairs[inputField.getAttribute('name')];
                        else {
                            if (inputField.value == keyValuePairs[inputField.getAttribute('name')])
                                inputField.setAttribute('checked', "")
                        }
                    }
                });
        }
    }
</script>

<style scoped>
    .my-container {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        flex-wrap: nowrap;
    }

    .my-container .header, .my-container .footer {
        flex-shrink: 0;
    }

    .my-container .content {
        flex-grow: 1;
        overflow: auto;
        min-height: 2em;
    }
</style>