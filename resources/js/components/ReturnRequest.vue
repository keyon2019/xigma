<template>
    <div>
        <a v-if="!returnRequest && order.status === 4" @click="modal.show()"
           class="uk-button uk-button-link uk-button-small uk-text-danger uk-border-rounded uk-flex uk-flex-middle">
            <i class="fa-solid fa-minus uk-margin-small-right"></i>
            <span>مرجوع کردن کالا</span>
        </a>
        <a v-else :href="'/return_request/' + returnRequest.id" class="uk-text-primary">
            <i class="fa-solid fa-rotate-left uk-margin-small-right"></i>
            <span>مشاهده مرجوعی</span>
        </a>
        <modal :overflow="true" :name="'return-' + order.id + '-' + variation.id">
            <div class="uk-text-bold">ثبت درخواست مرجوعی کالا</div>
            <div>لطفا جهت سهولت در بررسی کارشناسی، موارد زیر را تکمیل فرمایید</div>
            <div class="uk-padding-small uk-background-default uk-box-shadow-small uk-border-rounded uk-margin-small-top bordered">
                <div class="uk-grid uk-grid-small">
                    <div>
                        <img width="170" :src="variation.picture ? variation.picture.url : ''">
                    </div>
                    <div>
                        <div class="uk-text-bold uk-margin-small">{{variation.name}}</div>
                        <div class="uk-text-bold uk-margin-small"><span>نوع: </span><span>{{variation.filters}}</span></div>
                        <div class="uk-margin-small uk-text-muted"><span>کد محصول: </span><span>{{variation.sku}}</span></div>
                        <div class="uk-margin-small uk-text-muted">
                            <span>تعداد: </span><span>{{variation.quantity}}</span>
                        </div>
                        <div class="">
                            <span class="uk-text-muted">تعداد درخواست مرجوعی</span>
                            <incrementer v-model="form.quantity.value" class="uk-border-rounded uk-margin-small-left bordered"
                                         :max="variation.quantity"></incrementer>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-padding-small uk-background-default uk-box-shadow-small uk-border-rounded uk-margin-small-top bordered">
                <div class="uk-text-bold">علت مرجوعی</div>
                <div class="uk-margin-small" v-for="(reason, key) in reasons">
                    <label><input class="uk-radio" type="radio" v-model="form.reason.value" :value="key"> {{reason}}
                    </label>
                </div>
                <div v-if="form.errors.has('reason')"
                     class="uk-text-danger uk-text-small">{{form.errors['reason']}}
                </div>
            </div>
            <div class="uk-padding-small uk-background-default uk-box-shadow-small uk-border-rounded uk-margin-small-top bordered">
                <div class="uk-text-bold ">ارسال تصویر</div>
                <div class="">لطفا تصویر کالا و قسمت معیوب کالا را ارسال کنید</div>
                <div class="uk-text-small uk-text-primary">حداکثر حجم هر تصویر ۵۰۰ کیلوبایت</div>
                <div style="height: 100px;" class="uk-margin-small-top uk-inline">
                    <image-input v-model="form.images.value[0]" height="100" style="min-height:100px;width:100px;"></image-input>
                </div>
                <div style="height: 100px;" class="uk-margin-small-top uk-inline uk-margin-small-left">
                    <image-input v-if="form.images.value[0] != null" v-model="form.images.value[1]" height="100"
                                 style="min-height:100px;width:100px;"></image-input>
                </div>
                <div style="height: 100px;" class="uk-margin-small-top uk-inline uk-margin-small-left">
                    <image-input v-if="form.images.value[1] != null" v-model="form.images.value[2]" height="100"
                                 style="min-height:100px;width:100px;"></image-input>
                </div>
            </div>
            <div v-if="form.errors.has('images')"
                 class="uk-text-danger uk-text-small">{{form.errors['images']}}
            </div>
            <div class="uk-padding-small uk-background-default uk-box-shadow-small uk-border-rounded uk-margin-small-top bordered">
                <div class="uk-text-bold ">درخواست شما</div>
                <div class="uk-margin-small" v-for="(enquiry, key) in enquiries">
                    <label><input class="uk-radio" type="radio" v-model="form.enquiry.value" :value="key"> {{enquiry}}
                    </label>
                </div>
                <div v-if="form.errors.has('enquiry')"
                     class="uk-text-danger uk-text-small">{{form.errors['enquiry']}}
                </div>
            </div>
            <div class="uk-padding-small uk-background-default uk-box-shadow-small uk-border-rounded uk-margin-small-top bordered">
                <div class="uk-text-bold ">شرح مشکل</div>
                <textarea class="uk-textarea uk-text-small uk-border-rounded" rows="3" v-model="form.elaboration.value"
                          placeholder="لطفا جهت راهنمایی بهتر کارشناسان ما مشکل کالا را به طول خلاصه شرح دهید">
                </textarea>
                <div v-if="form.errors.has('elaboration')"
                     class="uk-text-danger uk-text-small">{{form.errors['elaboration']}}
                </div>
            </div>
            <div class="uk-margin-small uk-text-center">
                <label><input class="uk-checkbox" type="checkbox" value="1" name="consent"> قوانین و مقررات مرجوعی کالا را مطالعه
                    نموده و با کلیه موارد آن موافقم. </label>
            </div>
            <div class="uk-text-center uk-margin-small">
                <button class="uk-button uk-button-secondary uk-border-rounded" @click="submitReturnRequest()">ثبت درخواست
                </button>
            </div>
        </modal>
    </div>
</template>

<script>
    import Incrementer from "./Incrementer";

    export default {
        components: {Incrementer},
        props: {'order': {}, 'variation': {}, 'reasons': {}, 'enquiries': {}, 'initial-return-request':{default: null}},
        data() {
            return {
                returnRequest: this.initialReturnRequest,
                modal: new Modal('return-' + this.order.id + '-' + this.variation.id),
                form: new Form({
                    order_id: {
                        value: this.order.id,
                        rules: 'required|numeric',
                    },
                    variation_id: {
                        value: this.variation.id,
                        rules: 'required|numeric',
                    },
                    quantity: {
                        value: 1,
                        rules: 'required|numeric',
                    },
                    reason: {
                        value: null,
                        rules: 'required|numeric'
                    },
                    enquiry: {
                        value: null,
                        rules: 'required|numeric'
                    },
                    elaboration: {
                        value: null,
                        rules: 'required'
                    },
                    images: {
                        value: [],
                        rules: 'required|array'
                    }
                }),
            }
        },
        methods: {
            submitReturnRequest() {
                this.form.errors.clear();
                if (this.form.validate()) {
                    Loading.show();
                    axios.post('/return_request', this.form.asFormData()).then((response) => {
                        Toast.message("درخواست عودت شما با موفقیت ثبت شد").success().show();
                        this.returnRequest = response.data;
                        this.modal.hide();
                    }).catch((e) => {
                        Toast.message(e.response.data.message).danger().show();
                    }).then(() => Loading.hide());
                }
            }
        }
    }
</script>

<style scoped>
    .bordered {
        border: 1px solid gainsboro;
    }
</style>