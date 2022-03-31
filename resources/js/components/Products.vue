<template>
    <paginated-view>
        <template v-slot:filters>
            <div class="uk-background-default uk-box-shadow-small uk-padding-small uk-border-rounded">
                <div class="uk-margin-remove">جستجو</div>
                <hr class="uk-margin-remove-top"/>
                <div>
                    <div class="uk-margin-small">
                        <label><input class="uk-checkbox" type="checkbox" value="1" name="available"> محصولات موجود </label>
                    </div>
                    <div>
                        <input type="text" name="keyword" class="uk-input uk-border-rounded" placeholder="نام محصول">
                    </div>
                    <div v-for="(option, index) in options" class=" section-container uk-margin-small">
                        <ul data-uk-accordion="" class="uk-margin-remove-bottom">
                            <li class="">
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
            </div>
        </template>
        <template v-slot="scopeData">
            <table class="uk-table uk-table-divider uk-table-small uk-margin-remove
            uk-table-middle uk-background-default uk-border-rounded uk-box-shadow-small">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عکس</th>
                    <th>نام</th>
                    <th>قیمت</th>
                    <th>قیمت استثنائی</th>
                    <th>مدیریت</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in scopeData.records">
                    <td class="uk-table-shrink">{{product.id}}</td>
                    <td class="uk-table-shrink"><img class="uk-img" :src="product.splashUrl" alt=""></td>
                    <td>{{product.name}}</td>
                    <td>{{product.price.toLocaleString()}}</td>
                    <td>{{product.special_price ? product.special_price.toLocaleString() : ''}}</td>
                    <td><a :href="`/dashboard/product/${product.id}/edit`" class="uk-button uk-button-small uk-button-primary">ویرایش</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </template>
    </paginated-view>
</template>

<script>
    export default {
        props: ['options'],
        data() {
            return {}
        },
    }
</script>

<style scoped>

</style>