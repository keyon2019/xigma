<template>
    <div>
        <div class="uk-container">
            <div class="uk-grid uk-grid-collapse">
                <div class="uk-width-3-4@m">
                    <ul class="uk-breadcrumb">
                        <li><a href="/">زیگما</a></li>
                        <li v-if="category && category.parent_category && category.parent_category.parent_category"><a
                                :href="`/category/${category.parent_category.parent_category.id}`">{{category.parent_category.parent_category.name}}</a>
                        </li>
                        <li v-if="category && category.parent_category"><a :href="`/category/${category.parent_category.id}`">{{category.parent_category.name}}</a>
                        </li>
                        <li v-if="category"><a :href="`/category/${category.id}`">{{category.name}}</a></li>
                    </ul>
                    <div class="uk-grid uk-grid-collapse">
                        <div class="uk-width-2-5@m">
                            <p v-if="Date.parse(product.special_price_expiration) > Date.now()"
                               class="uk-display-inline-block uk-width-1-1 uk-margin-small uk-text-danger uk-text-bold">
                                    <span class="uk-float-right uk-text-light">
                                        <span class="uk-text-danger uk-display-inline-block" dir="ltr"
                                              :data-uk-countdown="`date: ${product.special_price_expiration}`">
                                            <span class="uk-countdown-number uk-text-small uk-countdown-days"></span>
                                            <span class="uk-countdown-separator uk-text-small">:</span>
                                            <span class="uk-countdown-number uk-text-small uk-countdown-hours"></span>
                                            <span class="uk-countdown-separator uk-text-small">:</span>
                                            <span class="uk-countdown-number uk-text-small uk-countdown-minutes"></span>
                                            <span class="uk-countdown-separator uk-text-small">:</span>
                                            <span class="uk-countdown-number uk-text-small uk-countdown-seconds"></span>
                                        </span>
                                    </span>
                                <span class="uk-float-left uk-text-light uk-text-bold"><span uk-icon="clock"
                                                                                             class="uk-margin-small-right"></span>فروش ویژه</span>
                            </p>
                            <a class="uk-link-reset" @click="showSlideshow()">
                                <img class="uk-width-expand"
                                     :src="selectedVariation ? variationPicture(selectedVariation) : product.splashUrl">
                            </a>
                            <div dir="ltr"
                                 class="uk-position-relative uk-visible-toggle uk-light uk-margin-small-top uk-margin-bottom"
                                 tabindex="-1" uk-slider>
                                <ul class="uk-slider-items uk-child-width-1-4 uk-grid uk-grid-small">
                                    <li v-for="(picture,index) in product.pictures">
                                        <a class="uk-link-reset" @click="showSlideshow(index)">
                                            <img class="uk-width-expand uk-border-rounded bordered" :src="picture.url"
                                                 :alt="product.name">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="uk-width-3-5@m">
                            <div class="uk-padding uk-padding-remove-vertical">
                                <div class="uk-clearfix">
                                    <div class="uk-float-right">
                                        <div class="uk-text-bold numeric-standard">{{product.en_name}}</div>
                                    </div>
                                    <div class="uk-float-left">
                                        <div class="uk-text-bold">{{product.name}}</div>
                                    </div>
                                </div>
                                <hr class="uk-margin-small"/>
                                <div class="uk-flex">
                                    <span data-uk-icon="star" class="star-filled"></span>
                                    <span class="uk-margin-small-left uk-text-muted">{{product.rating ? parseFloat(product.rating).toFixed(1) : '3'}} {{product.rating ? `(${product.comments.length})` : ''}}</span>
                                    <span class="uk-text-muted uk-margin-small-left">•</span>
                                    <span class="uk-flex-1 uk-margin-small-left"><a @click="showComments()">{{product.comments.length}} نظر کاربران</a></span>
                                    <span class="numeric-standard" v-text="selectedVariation ? selectedVariation.sku : ''">

                                    </span>
                                </div>
                                <div v-if="selectedVariation && selectedVariation.values.length > 0"
                                     class="uk-margin-large-top uk-text-small">
                                    <div class="uk-margin-small" v-for="(value,index) in selectedVariation.values"
                                         :class="index === 0 ? 'uk-first-column' : ''">
                                        <span class="uk-margin-small-bottom">{{value.option.name}}:</span>
                                        <span class="uk-margin-remove uk-text-bold">{{value.name}}</span>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">انتخاب نوع</label>
                                    <div class="uk-form-controls">
                                        <select class="uk-select uk-border-rounded uk-width-medium@s" v-model="selectedVariation">
                                            <option :value="null" disabled>انتخاب کنید</option>
                                            <option v-for="variation in product.variations" :value="variation"
                                                    v-text="variation.name"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">تعداد</label>
                                    <div class="uk-form-controls">
                                        <incrementer :disabled="product.onesie" class="uk-border-rounded"
                                                     style="border: 1px solid gainsboro"
                                                     v-model="quantity"></incrementer>
                                        <!--<select class="uk-select uk-border-rounded uk-width-small@s" v-model="quantity">-->
                                        <!--<option :value="null" disabled>انتخاب کنید</option>-->
                                        <!--<option v-for="i in 12" :value="i">{{i}}</option>-->
                                        <!--</select>-->
                                    </div>
                                </div>
                                <div v-if="selectedVariation" class="uk-margin">
                                    <a @click="pointsModal.show()" class="uk-link uk-margin-small-bottom"><span class="uk-margin-small-right"
                                                                                    data-uk-icon="warning"></span><span>{{selectedVariation.points}} امتیاز ویژه خرید زیگما</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-4@m">
                    <div class="uk-section-muted uk-border-rounded uk-padding-small">
                        <p class="uk-text-center uk-background-gray uk-text-white uk-border-rounded">اطلاعات فروشنده</p>
                        <div class="dot-container">
                            <div class=""
                                 style="width: 100%;height: 100%;padding: 10px;position: absolute;top:0;left:0;box-sizing:border-box;">
                                <div class="uk-position-relative" style="width: 100%;height: 100%;">
                                    <div class="uk-position-absolute uk-position-cover dots"></div>
                                </div>
                            </div>
                            <div class="uk-position-relative" style="z-index: 9">
                                <p v-if="retailers.length > 0" class="dot-icon-p"><span class="uk-background-muted"
                                                                                        data-uk-icon="check"></span><span
                                        class="uk-margin-small-left uk-text-small">موجود در <a
                                        @click="$refs.retailers.scrollIntoView({behavior: 'smooth'})">{{retailers.length}} نمایندگی</a></span>
                                </p>
                                <p class="dot-icon-p"><span class="uk-background-muted"
                                                            data-uk-icon="bolt"></span><span
                                        class="uk-margin-small-left uk-text-small">ارسال سریع کالا</span>
                                </p>
                                <p class="dot-icon-p"><span class="horizontal-dots"></span>
                                    <span class="uk-background-muted"
                                          data-uk-icon="user"></span><span
                                            class="uk-margin-small-left uk-text-small">انتخاب بهترین نمایندگی</span>
                                </p>
                                <p class="dot-icon-p"><span class="horizontal-dots"></span>
                                    <span class="uk-background-muted"
                                          data-uk-icon="location"></span><span
                                            class="uk-margin-small-left uk-text-small">انتخاب بهترین مسیر ارسال</span>
                                </p>
                                <p class="dot-icon-p"><span class="uk-background-muted"
                                                            data-uk-icon="check"></span><span
                                        class="uk-margin-small-left uk-text-small">ضمانت اصالت کالا</span>
                                </p>
                                <p class="dot-icon-p"><span class="uk-background-muted"
                                                            data-uk-icon="check"></span><span
                                        class="uk-margin-small-left uk-text-small">ضمانت سلامت و عملکرد کالا</span>
                                </p>
                                <p class="dot-icon-p"><span class="uk-background-muted"
                                                            data-uk-icon="refresh"></span><span
                                        class="uk-margin-small-left uk-text-small">۳ روز گارانتی تعویض کالای معیوب</span>
                                </p>
                            </div>
                        </div>
                        <hr class="uk-margin-small"/>
                        <p class="uk-text-muted">قیمت مصرف کننده</p>
                        <p class="uk-text-small uk-margin-small uk-text-center uk-text-line-through uk-text-danger"
                           v-if="selectedVariation && selectedVariation.available && selectedVariation.orderPrice < selectedVariation.price">
                            {{selectedVariation.price.toLocaleString()}} تومان
                        </p>
                        <p class="uk-text-large uk-margin-small uk-text-center uk-position-relative"
                           v-if="selectedVariation && selectedVariation.available"><span
                                v-if="selectedVariation.orderPrice < selectedVariation.price"
                                class="uk-position-absolute uk-position-top-right uk-label uk-label-danger">
                            {{(((selectedVariation.price - selectedVariation.orderPrice) / selectedVariation.price) * 100).toFixed(0)}}%
                        </span>
                            {{selectedVariation.orderPrice.toLocaleString()}} تومان</p>
                        <p v-else class="uk-text-center uk-text-danger">
                            ناموجود
                        </p>
                        <p v-if="product.onesie" class="uk-text-danger uk-margin-small-bottom"><span class="uk-margin-small-right"
                                                                                                     data-uk-icon="warning"></span><span>محدودیت خرید</span>
                        </p>
                        <button class="uk-button uk-button-success uk-border-rounded uk-text-white add-to-cart-button uk-width-expand"
                                @click="addToCart()"
                                :disabled="!selectedVariation || (!!selectedVariation && !selectedVariation.available)">
                    <span class="uk-grid uk-grid-small uk-flex uk-flex-middle uk-grid-divider">
                        <span class="uk-width-auto uk-first-column" data-uk-icon="icon:cart;ratio:1.5"></span>
                        <span class="uk-width-expand">افزودن به سبد خرید</span>
                    </span>
                        </button>
                    </div>
                </div>
            </div>
            <div ref="retailers" v-if="selectedVariation && retailers.length > 0">
                <p class="uk-text-lead half-title uk-margin-large-bottom">نمایندگی‌ها فروشنده قطعه شما</p>
                <div v-for="(retailer,index) in retailers">
                    <div class="uk-grid uk-grid-collapse uk-flex uk-flex-middle" data-uk-grid>
                        <div class="uk-width-2-5@m">
                            <p class="uk-flex uk-margin-small-bottom"><span data-uk-icon="home"
                                                                            class="uk-margin-small-right"></span>{{retailer.name || 'کارخانه مرکزی'}}
                            </p>
                            <p class="uk-margin-remove uk-text-meta"><span class="uk-text-success uk-text-bold">۹۲٪</span> رضایت
                                عملکرد</p>
                        </div>
                        <div class="uk-width-expand@s">
                            <p class="uk-margin-small-bottom"><span v-if="retailer.city">{{retailer.city}} نمایندگی</span><span v-else>قم</span></p>
                            <p class="uk-text-meta uk-margin-remove"><span v-if="retailer.address">{{retailer.address}}</span> <span class="uk-text-truncate" v-else>شهرک صنعتی شکوهیه، بلوار آیت اله خامنه ای، کوچه بنفشه2، پلاک 372</span></p>
                        </div>
                        <div class="uk-width-auto@s">
                            <div class="uk-grid uk-grid-small uk-child-width-auto uk-grid-divider">
                                <div class="uk-first-column uk-text-primary" data-uk-icon="icon:home;ratio:1.5"></div>
                                <div class="uk-text-primary" data-uk-icon="icon:comment;ratio:1.5"></div>
                                <div class="uk-text-primary" data-uk-icon="icon: check;ratio:1.5"></div>
                            </div>
                        </div>
                    </div>
                    <hr v-if="index + 1 < retailers.length" class="uk-margin-small-top"/>
                </div>
            </div>
        </div>
        <slot></slot>
        <!--<div class="uk-section-small uk-section-default" ref="comments">-->
        <div class="uk-background-default" ref="comments"
             style="position: sticky; bottom: 0;padding-top:20px;z-index:100;border-top: 1px solid gainsboro">
            <div class="uk-container">
                <ul class="uk-tab uk-child-width-1-5@m uk-child-width-1-2"
                    @click="$refs.comments.scrollIntoView({behavior: 'smooth'})"
                    uk-tab="connect:#tog-table;animation:uk-animation-fade" ref="tab"
                    data-uk-switcher="animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium">
                    <li><a class="text-small@m" href="#info">مشخصات قطعه</a></li>
                    <li><a class="text-small@m" href="#categories">امتیاز و دیدگاه کاربران</a></li>
                </ul>
            </div>
        </div>
        <div class="uk-background-default uk-padding">
            <div class="uk-container">
                <div class="uk-switcher uk-margin" id="tog-table">
                    <div v-html="product.description" class="ck-content"></div>
                    <div>
                        <div class="uk-grid uk-grid-large" data-uk-grid>
                            <div class="uk-width-1-4@m">
                                <div v-if="product.rating" class="uk-text-left@m uk-text-center">
                                    <stars-rating :rating="product.rating"></stars-rating>
                                    <span class="uk-heading-small">{{parseFloat(product.rating).toFixed(2)}}</span>
                                    <span>از ۵</span>
                                </div>
                                <p class="uk-text-center">نظر خود را به اشتراک بگذارید</p>
                                <button class="uk-button uk-button-primary uk-width-expand uk-border-rounded"
                                        @click="commentModal.show()">ثبت دیدگاه
                                </button>
                            </div>
                            <div class="uk-width-expand@m">
                                <div v-for="(comment) in product.comments">
                                    <p class="uk-margin-remove uk-text-bold">{{comment.user.name}}</p>
                                    <p class="uk-text-meta uk-margin-remove">
                                        <span class="uk-display-inline-block uk-width-expand">
                                            <span class="uk-float-left">{{comment.created_at}}</span>
                                            <span class="uk-float-right"><stars-rating
                                                    :rating="comment.rating"></stars-rating></span>
                                        </span>
                                    </p>
                                    <hr class="uk-margin-remove-top"/>
                                    <p class="uk-margin-large uk-margin-remove-top uk-padding-small uk-padding-remove-vertical uk-padding-remove-right"
                                       v-text="comment.text"></p>
                                </div>
                                <div v-if="product.comments.length === 0"
                                     class="uk-flex uk-flex-center uk-flex-middle uk-height-1-1">
                                    <p class="uk-text-center uk-text-muted">هیچ دیدگاهی تاکنون برای این محصول ثبت نشده است</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--</div>-->
        <modal class="uk-modal-container" name="comment">
            <form-comment @submit="commentModal.hide()" :product="product"></form-comment>
        </modal>
        <modal :close="true" name="slideshowmodal" class="" :transparent-dialog="true">
            <slideshow :images="productPictures" :index="selectedImageIndex"></slideshow>
        </modal>
        <modal name="pointsModal">
            <div>بعد از پایان مهلت مرجوعی، برای استفاده از امتیاز به قسمت امتیازات سر بزنید</div>
        </modal>
    </div>
</template>

<script>
    export default {
        props: ['product', 'category'],
        data() {
            return {
                selectedVariation: null,
                quantity: 1,
                pointsModal: new Modal('pointsModal'),
                retailers: [],
                commentModal: new Modal('comment'),
                slideShowModal: new Modal('slideshowmodal'),
                selectedImageIndex: 0
            }
        },
        methods: {
            addToCart() {
                Event.$emit('add-to-cart', this.selectedVariation.id, this.quantity);
            },
            variationPicture(variation) {
                const p = _.find(this.product.pictures, ['id', variation.splash]);
                return p ? p.url : '';
            },
            getRetailers() {
                Loading.show();
                axios.post(`/item/${this.selectedVariation.id}/retailer`).then((response) => {
                    this.retailers = response.data.retailers;
                }).catch((e) => {
                    Toast.message(e.response.data.message).danger().show();
                }).then(() => Loading.hide());
            },
            showSlideshow(index) {
                this.selectedImageIndex = index;
                this.slideShowModal.show();
            },
            showComments() {
                this.$refs.comments.scrollIntoView({behavior: 'smooth'});
                UIkit.tab(this.$refs.tab).show(1);
            }
        },
        beforeMount() {
            this.selectedVariation = _.first(this.product.variations);
        },
        computed: {
            productPictures() {
                return _.map(this.product.pictures, 'url');
            }
        },
        watch: {
            selectedVariation(v) {
                if (v)
                    this.getRetailers();
            }
        }
    }
</script>

<style scoped>
    .uk-breadcrumb > :nth-child(n+2):not(.uk-first-column)::before {
        margin: 0 3px;
    }

    .uk-background-gray {
        background: gray;
    }

    .add-to-cart-button {
        padding: 5px 10px;
        font-size: 1.2rem;
    }

    .dot-container {
        position: relative;
    }

    .dot-icon-p {
        padding: 5px 0;
    }

    .dots:before {
        content: "";
        width: 8px;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        background: url('/uploads/dot.png') repeat-y center;
        transform: translateX(-50%);
    }

    .horizontal-dots {
        background: url('/uploads/dot.png') repeat-x center;
        padding: 0 10px;
        margin-left: 12px;
    }

    .bordered {
        border: 1px solid gainsboro;
    }

    .uk-grid-divider > :not(.uk-first-column)::before {
        top: 20% !important;
        bottom: 20% !important;
        border-left: 1px solid #bdbdbd;
    }

    .half-title {
        position: relative;
    }

    .half-title:after {
        content: "";
        height: 3px;
        bottom: -30%;
        left: 0;
        width: 120px;
        background: #FFAA1A;
        position: absolute;
    }

    .uk-tab > * > a {
        font-size: 1.3rem;
        text-align: left;
        /*border-bottom: 4px;*/
    }

    .uk-tab > *:not(.uk-active) > a {
        border-bottom: 4px solid transparent;
    }

    .uk-tab > .uk-active > a {
        border-bottom: 4px solid #FFAA1A;
    }
</style>