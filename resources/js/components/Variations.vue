<template>
    <paginated-view :fetch-url="fetchUrl">
        <template v-slot:sort>
            <div class="uk-background-default uk-text-small uk-margin-small-bottom uk-padding-small uk-border-rounded uk-box-shadow-small">
                <span class="uk-text-bold">ترتیب نمایش:</span>
                <div class="uk-margin-small-left uk-inline clickable uk-text-light uk-width-small">
                    <div data-uk-form-custom="target:true">
                        <select name="orderBy">
                            <option selected :value="null" disabled>پیش‌فرض</option>
                            <option value="items_count.desc">بیشترین موجودی</option>
                            <option value="items_count">کمترین موجودی</option>
                        </select>
                        <span></span>
                        <span><i data-uk-icon="icon:chevron-down"></i></span>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:filters>
            <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                <div class="uk-margin-remove">جستجو</div>
                <hr class="uk-margin-remove-top"/>
                <div>
                    <div>
                        <auto-complete name="product" value-key="id" api-result-key="data"
                                       method="get" api="/dashboard/product" placeholder="محصول"></auto-complete>
                    </div>
                    <div>
                        <ul data-uk-accordion="" class="uk-margin-small-top">
                            <li class="uk-open">
                                <a class="uk-accordion-title uk-text-small">دسته‌بندی</a>
                                <div class="uk-accordion-content">
                                    <ul v-for="category in categories" class="uk-list uk-list-hyphen">
                                        <li>
                                            <label><input name="categories[]" class="uk-checkbox"
                                                          type="checkbox"
                                                          :value="category.id">
                                                {{category.name}}</label>
                                            <ul v-for="sCategory in category.sub_categories" class="uk-list uk-list-hyphen">
                                                <li>
                                                    <label><input name="categories[]" class="uk-checkbox"
                                                                  type="checkbox"
                                                                  :value="sCategory.id">
                                                        {{sCategory.name}}</label>
                                                    <ul v-for="ssCategory in sCategory.sub_categories" class="uk-list uk-list-hyphen">
                                                        <li>
                                                            <label><input name="categories[]" class="uk-checkbox"
                                                                          type="checkbox"
                                                                          :value="ssCategory.id">
                                                                {{ssCategory.name}}</label>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
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
            <table class="uk-table uk-table-divider uk-table-middle uk-box-shadow-small uk-table-small
             uk-background-default uk-border-rounded">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام محصول</th>
                    <th>نوع</th>
                    <th>فیلترها</th>
                    <th>موجودی</th>
                    <th>مدیریت</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="variation in scopeData.records">
                    <td class="uk-table-shrink">{{variation.id}}</td>
                    <td>{{variation.product.name}}</td>
                    <td>{{variation.name}}</td>
                    <td>{{variation.filters}}</td>
                    <td>{{variation.items_count}}</td>
                    <td v-if="!chooseList">
                        <a :href="`/dashboard/variation/${variation.id}/item`"
                           class="uk-button uk-button-small uk-button-secondary">انبار</a>
                    </td>
                    <td v-else><a class="uk-button uk-button-small uk-button-secondary"
                                  @click="$emit('chosen', variation)">انتخاب</a></td>
                </tr>
                </tbody>
            </table>
        </template>
    </paginated-view>
</template>

<script>
    export default {
        props: ['fetch-url', 'choose-list', 'categories']
    }
</script>

<style scoped>

</style>