<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div>
        <paginated-view :fetch-url="fetchUrl">
            <template v-slot:sort>
                <div
                    class="uk-background-default uk-text-small uk-margin-small-bottom uk-padding-small uk-border-rounded uk-box-shadow-small">
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
                        <div class="uk-margin-small">
                            <input type="text" name="keyword" class="uk-input uk-border-rounded" placeholder="نام محصول">
                        </div>
                        <div>
                            <input type="text" name="sku" class="uk-input uk-border-rounded" placeholder="سریال">
                        </div>
                        <div>
                            <accordion title="دسته‌بندی" class="uk-margin-small-top">
                                <template v-for="category in categories" class="uk-list uk-list-hyphen">
                                    <accordion class="uk-margin-top">
                                        <template v-slot:title>
                                            <label class="uk-margin-small-left"><input name="categories[]" class="uk-checkbox"
                                                                                       type="checkbox"
                                                                                       :value="category.id">
                                                {{ category.name }}</label>
                                        </template>
                                        <template v-for="sCategory in category.sub_categories" class="uk-list uk-list-hyphen">
                                            <accordion class="uk-margin-small-top">
                                                <template v-slot:title>
                                                    <label class="uk-margin-left"><input name="categories[]" class="uk-checkbox"
                                                                                         type="checkbox"
                                                                                         :value="sCategory.id">
                                                        {{ sCategory.name }}</label>
                                                </template>
                                                <template v-for="ssCategory in sCategory.sub_categories"
                                                          class="uk-list uk-list-hyphen">
                                                    <div class="uk-margin-small-top">
                                                        <label class="uk-margin-large-left"><input name="categories[]"
                                                                                                   class="uk-checkbox"
                                                                                                   type="checkbox"
                                                                                                   :value="ssCategory.id">
                                                            {{ ssCategory.name }}</label>
                                                    </div>
                                                </template>
                                            </accordion>
                                        </template>
                                    </accordion>
                                </template>
                            </accordion>
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
                        <th>سریال</th>
                        <th>نوع</th>
                        <th>فیلترها</th>
                        <th>موجودی</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="variation in scopeData.records">
                        <td class="uk-table-shrink">{{ variation.id }}</td>
                        <td>{{ variation.product.name }}</td>
                        <td>{{ variation.sku }}</td>
                        <td>{{ variation.name }}</td>
                        <td>{{ variation.filters }}</td>
                        <td>{{ totalQuantity(variation) }}</td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </paginated-view>
    </div>
</template>

<script>
import Accordion from "./Accordion";

export default {
    components: {Accordion},
    props: ['fetch-url', 'choose-list', 'categories'],
    methods: {
        totalQuantity(variation) {
            return _.sumBy(variation.stocks, (stock) => {
                return stock.pivot.quantity;
            })
        }
    }
}
</script>

<style scoped>

</style>
