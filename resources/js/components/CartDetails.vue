<template>
    <div>
        <div v-if="cart.items.length <= 0" class="uk-card uk-card-body uk-box-shadow-medium uk-border-rounded">
            <h2 class="uk-text-center uk-text-light uk-padding-large">سبد خرید شما خالی است</h2>
        </div>
        <div v-else class="uk-grid uk-grid-small">
            <div class="uk-width-3-4@m">
                <div v-for="item in cart.items" class="uk-background-muted uk-border-rounded uk-margin-small-bottom"
                     style="border: 1px solid gainsboro">
                    <div class="uk-grid uk-padding-small uk-border-rounded">
                        <div class="uk-width-1-5@m">
                            <a class="" :href="`/product/${item.product.id}`">
                                <img class="uk-margin-top" :src="item.splash">
                            </a>
                        </div>
                        <div class="uk-width-expand">
                            <h3 class="uk-title uk-margin-remove">{{item.productName}}</h3>
                            <div class="uk-text-small">
                                <div class="uk-text-meta">
                                    <p class="uk-subtitle">{{item.name}}</p>
                                    <p><span class="uk-background-muted"
                                             data-uk-icon="check"></span><span
                                            class="uk-margin-small-left uk-text-small">ضمانت اصالت کالا</span></p>
                                    <p><span class="uk-background-muted"
                                             data-uk-icon="bolt"></span><span
                                            class="uk-margin-small-left uk-text-small">ضمانت سلامت و عمکرد کالا</span></p>
                                    <p><span class="uk-background-muted"
                                             data-uk-icon="reply"></span><span
                                            class="uk-margin-small-left uk-text-small">۳ روز گارانتی تعویض کالای معیوب</span></p>
                                    <div class="uk-grid uk-flex uk-flex-middle uk-text-emphasis" style="margin-top:35px;">
                                        <div class="uk-flex uk-flex-middle uk-width-expand">
                                            <div class="uk-text-bold uk-text-default uk-text-emphasis uk-margin-right">
                                                تعداد کالا
                                            </div>
                                            <incrementer :disabled="item.product.onesie" name="quantity" v-model="item.quantity"
                                                         class="uk-background-default uk-border-rounded"
                                                         style="border: 1px solid gainsboro;"></incrementer>
                                        </div>
                                        <div class="uk-width-2-5@m">
                                            <div v-if="item.discount > 0"
                                                 class="uk-grid uk-grid-small uk-text-danger uk-flex uk-flex-middle" uk-grid>
                                                <div class="uk-width-expand">تخفیف</div>
                                                <div><span
                                                        class="">{{(item.quantity * item.discount).toLocaleString()}}</span>
                                                    ریال
                                                </div>
                                            </div>
                                            <div class="uk-grid uk-grid-small uk-text-emphasis uk-flex uk-flex-middle" uk-grid>
                                                <div class="uk-width-expand">قیمت</div>
                                                <div><span
                                                        class="uk-text-large">{{(item.quantity * item.price).toLocaleString()}}</span>
                                                    ریال
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="uk-margin-small"/>
                                <div class="uk-grid uk-grid-divider uk-grid-small uk-text-small uk-text-light">
                                    <a @click="cart.remove(item.id)" class="uk-text-danger"><span data-uk-icon="trash"></span> حذف
                                        از سبد خرید</a>
                                    <div><a @click="cart.add(item.id, item.quantity)"><span data-uk-icon="pencil"></span> ویرایش
                                        خرید</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-4@m">
                <div class="uk-background-muted uk-border-rounded uk-padding-small" style="border: 1px solid gainsboro;">
                    <div class="uk-grid uk-grid-small uk-text-emphasis uk-flex uk-flex-middle" uk-grid>
                        <div class="uk-width-expand">قیمت اقلام ({{cart.totalQuantity()}})</div>
                        <div><span>{{(cart.total() + cart.totalDiscount()).toLocaleString()}}</span> ریال</div>
                    </div>
                    <div class="uk-grid uk-grid-small uk-text-danger uk-flex uk-flex-middle" uk-grid>
                        <div class="uk-width-expand">جمع تخفیف‌ها</div>
                        <div><span>{{cart.totalDiscount().toLocaleString()}}</span> ریال</div>
                    </div>
                    <hr/>
                    <div class="uk-grid uk-grid-small uk-text-emphasis uk-flex uk-flex-middle" uk-grid>
                        <div class="uk-width-expand">مبلغ سبد خرید</div>
                        <div><span>{{(cart.total()).toLocaleString()}}</span> ریال</div>
                    </div>
                    <p class="uk-text-meta">جهت نهایی کردن فاکتور خود و انتخاب نحوه ارسال قطعات وارد مرحله بعد شوید</p>
                    <a href="/checkout" class="uk-button uk-button-danger uk-button-large uk-width-expand uk-border-rounded">نهایی
                        کردن خرید</a>
                    <form method="post" action="/invoice">
                        <input type="hidden" name="_token" :value="CSRF">
                        <div class="uk-text-center">
                            <button class="uk-button-text uk-button uk-text-small uk-button-small uk-margin-small-top">
                                ثبت پیش‌فاکتور از سبد خرید
                            </button>
                        </div>
                    </form>
                </div>
                <div class="uk-flex uk-text-meta uk-margin-top uk-padding-small">
                    <div class="uk-margin-small-right"><span data-uk-icon="icon:warning;ratio:2"></span></div>
                    <div class="uk-text-justify">قطعات انتخابی شما در حال حاضر به نام شما به ثبت نرسیده و دیگران امکان خرید آن را
                        دارند.<br/>جهت ثبت کالا و اطمینان از خرید آن وارد قسمت نهایی کردن خرید شوید و فرآیند خرید خود را کامل
                        نمایید.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                cart: window.Cart,
            }
        }
    }
</script>

<style scoped>

</style>