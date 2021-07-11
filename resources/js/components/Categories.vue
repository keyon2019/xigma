<template>
    <paginated-view :fetch-url="fetchUrl">
        <template v-slot:filters>
            <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                <div class="uk-margin-remove">جستجو</div>
                <hr class="uk-margin-remove-top"/>
                <div>
                    <div>
                        <input name="keyword" class="uk-input uk-border-rounded" placeholder="نام دسته‌بندی">
                    </div>
                    <div class="uk-margin-small-top">
                        <button class="uk-button uk-width-expand uk-button-primary uk-border-rounded"
                                type="submit">اعمال فیلترها
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot="scopeData">
            <div class="uk-grid uk-grid-small uk-child-width-1-6 uk-margin" data-uk-grid>
                <div v-for="category in scopeData.records">
                    <div @click="selected(category)"
                         class="uk-card uk-card-default uk-card-small uk-border-rounded uk-box-shadow-medium clickable">
                        <div class="uk-card-media-top">
                            <img :src="category.splash">
                        </div>
                        <div class="uk-card-body">
                            <p v-text="category.name"></p>
                            <p class="uk-text-meta uk-text-truncate" v-text="category.description"></p>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </paginated-view>
</template>

<script>
    export default {
        props: ['fetch-url', 'choose-list'],
        methods: {
            selected(category) {
                if (this.chooseList) {
                    this.$emit('chosen', category);
                    return
                }
                window.location.replace(`/dashboard/category/${category.id}/edit`);
            }
        }
    }
</script>

<style scoped>

</style>