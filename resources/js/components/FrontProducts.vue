<template>
    <paginated-view @fetched="scroll">
        <template v-slot:sort>
            <div class="section-container custom-padding uk-background-default uk-text-meta">
                <span data-uk-icon="settings" class="uk-margin-small-right"></span>
                <span>مرتب سازی بر اساس</span>
            </div>
        </template>
        <template v-slot:filters>
            <div class="uk-text-small">
                <div class="uk-background-default custom-padding section-container uk-margin-small">{{category.name}}</div>
                <div v-for="option in options" class="uk-background-default section-container uk-margin-small">
                    <ul data-uk-accordion="" class="uk-margin-remove-bottom">
                        <li class="uk-open">
                            <a class="uk-accordion-title uk-text-small custom-padding">{{option.name}}</a>
                            <hr class="uk-margin-remove"/>
                            <div class="uk-accordion-content uk-margin-remove">
                                <div v-for="value in option.values" class="custom-padding uk-text-meta">
                                    <div>
                                        <label><input :name="`option[${option.id}][]`" class="uk-checkbox" type="checkbox" :value="value.id">
                                            {{value.name}}</label>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="uk-background-default uk-flex custom-padding uk-flex-middle section-container uk-margin-small">
                    <p class="uk-margin-remove" style="flex: 1">فقط کالاهای موجود</p>
                    <input name="available" value="1" class="apple-switch uk-margin-remove" type="checkbox"></div>
            </div>
            <button class="uk-button uk-button-small uk-width-expand uk-button-primary uk-border-rounded"
                    type="submit">اعمال فیلترها
            </button>
        </template>
        <template v-slot="scopeData">
            <div data-uk-grid class="uk-grid uk-grid-small uk-child-width-1-3@m uk-child-width-1-2 uk-margin-small-top">
                <div v-for="product in scopeData.records">
                    <front-product-card :product="product"></front-product-card>
                </div>
            </div>
        </template>
    </paginated-view>
</template>

<script>
    export default {
        props: ['category', 'options'],
        methods: {
            scroll() {
                this.$el.scrollIntoView({behavior: 'smooth'});
            }
        }
    }
</script>

<style scoped>
    .section-container {
        font-weight: 300;
        border-radius: 10px;
    }

    .custom-padding {
        padding: 0.5rem;
    }

    .uk-accordion-title:before {
        background-image: url('/uploads/chevron-down.svg');
        opacity: 0.5;
    }

    .uk-open > .uk-accordion-title::before {
        background-image: url('/uploads/chevron-up.svg');
        opacity: 1;
    }
</style>