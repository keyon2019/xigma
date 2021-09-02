<template>
    <paginated-view @fetched="scroll">
        <template v-slot:sort>
            <div class="uk-flex uk-text-small uk-border-rounded uk-text-white"
                 style="justify-content: space-between;background: #565656">
                <div class="uk-padding-small uk-border-rounded uk-position-relative"
                     style="background: #828282;border-top-left-radius: 0; border-bottom-left-radius: 0;">
                    <div class="sort-item">ترتیب نمایش</div>
                    <div class="right-triangle"></div>
                </div>
                <div class="uk-padding-small">
                    <button class="uk-button sort-item uk-border-rounded" @click="sort = 'latest'" name="sort"
                            :class="{'uk-button uk-button-primary' : sort === 'latest'}" type="submit" value="latest">جدیدترین</button>
                </div>
                <div class="uk-padding-small">
                    <button class="uk-button sort-item uk-border-rounded" @click="sort = 'expensive'" name="sort"
                            :class="{'uk-button uk-button-primary' : sort === 'expensive'}" type="submit" value="latest">گرانترین</button>
                </div>
                <div class="uk-padding-small">
                    <button class="uk-button sort-item uk-border-rounded" @click="sort = 'price'" name="sort"
                            :class="{'uk-button uk-button-primary' : sort === 'price'}" type="submit" value="latest">ارزان‌ترین</button>
                </div>
                <div class="uk-padding-small">
                    <button class="uk-button sort-item uk-border-rounded" @click="sort = 'popular'" name="sort"
                            :class="{'uk-button uk-button-primary' : sort === 'popular'}" type="submit" value="latest">محبوب‌ترین</button>
                </div>
                <div class="uk-padding-small">
                    <button class="uk-button sort-item uk-border-rounded" @click="sort = 'most_viewed'" name="sort"
                            :class="{'uk-button uk-button-primary' : sort === 'most_viewed'}" type="submit" value="latest">پربازدید‌ترین</button>
                </div>
            </div>
        </template>
        <template v-slot:filters>
            <div class="uk-background-default uk-border-rounded uk-text-small uk-box-shadow-small">
                <p class="uk-text-center uk-text-small uk-padding-small uk-padding-remove-horizontal uk-margin-remove uk-text-bold">
                    تنظیمات نمایش محصولات</p>
                <div class="uk-background-default uk-flex custom-padding uk-flex-middle section-container">
                    <p class="uk-margin-remove" style="flex: 1">فقط کالاهای موجود</p>
                    <input name="available" value="1" class="apple-switch uk-margin-remove" type="checkbox">
                </div>
                <div class="uk-background-default uk-flex custom-padding uk-flex-middle section-container">
                    <p class="uk-margin-remove" style="flex: 1">فقط قطعات دارای تصویر</p>
                    <input name="has-picture" value="1" class="apple-switch uk-margin-remove" type="checkbox">
                </div>
                <div class="uk-background-default uk-flex custom-padding uk-flex-middle section-container">
                    <p class="uk-margin-remove" style="flex: 1">فقط قطعات موتور من</p>
                    <input name="owned" value="1" class="apple-switch uk-margin-remove" type="checkbox">
                </div>
                <hr class="uk-margin-small-left uk-margin-small-right uk-margin-small"/>
                <div v-for="(option, index) in options" class="uk-background-default section-container uk-margin-small">
                    <ul data-uk-accordion="" class="uk-margin-remove-bottom">
                        <li class="uk-open">
                            <a class="uk-accordion-title uk-text-small custom-padding">{{option.name}}</a>
                            <div class="uk-accordion-content uk-margin-remove">
                                <div v-for="value in option.values" class="custom-padding uk-text-meta">
                                    <div>
                                        <label><input :name="`option[${option.id}][]`" class="uk-checkbox" type="checkbox"
                                                      :value="value.id">
                                            {{value.name}}</label>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <hr v-if="index + 1 < options.length"
                        class="uk-margin-small-left uk-margin-small-right uk-margin-remove-vertical"/>
                </div>
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
        data() {
            return {
                sort: null
            }
        },
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

    .sort-item {
        /*padding: 8px 30px;*/
        border-radius: 6px;
        padding: 0 30px;
        line-height: 38px;
    }

    .sort-item.active {
        background: #FFAA1A;
        color: black;
    }

    .uk-button.sort-item:not(.uk-button-primary) {
        background: none
    }

    .right-triangle {
        width: 0px;
        height: 0px;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        border-right: 10px solid #565656;
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
    }
</style>