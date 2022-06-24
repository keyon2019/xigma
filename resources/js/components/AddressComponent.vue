<template>
    <form ref="form" method="post" :action="'/return_request/' + returnRequest.id + '/set_address'">
        <slot></slot>
        <div class="uk-padding-small address-container uk-border-rounded uk-margin">
            <div class="uk-text-bold">مشخصات گیرنده کالا</div>
            <div class="uk-margin-small">
                <label><input v-model="alternateReceiver" :true-value="false" :false-value="true"
                              class="uk-checkbox uk-margin-small-right" type="checkbox"
                              name="available">گیرنده کالا خودم هستم</label>
            </div>
            <template v-if="alternateReceiver">
                <div class="uk-margin-small">
                    <input name="receiver_name" class="uk-input uk-border-rounded" v-model="form.receiver_name.value"
                           placeholder="نام گیرنده">
                    <div v-if="form.errors.has('receiver_name')"
                         class="uk-text-danger uk-text-small">{{form.errors['receiver_name']}}
                    </div>
                </div>
                <div class="uk-margin-small">
                    <input name="receiver_number" class="uk-input uk-border-rounded" v-model="form.receiver_number.value"
                           placeholder="شماره گیرنده">
                    <div v-if="form.errors.has('receiver_number')"
                         class="uk-text-danger uk-text-small">{{form.errors['receiver_number']}}
                    </div>
                </div>
            </template>
        </div>
        <div class="address-container uk-padding-small uk-border-rounded">
            <div class="uk-grid uk-child-width-1-3@m uk-grid-small uk-grid-match" data-uk-grid>
                <div v-for="address in addresses">
                    <div class="address-container uk-border-rounded uk-padding-small">
                        <div class="uk-flex">
                            <div class="uk-margin-small-right">
                                <label><input @click="selectedAddress = address" class="uk-radio" type="radio"
                                              :value="address.id"
                                              name="address_id" v-model="form.address_id.value"></label>
                            </div>
                            <div>
                                <p class="uk-margin-small"><span class="uk-text-bold">استان: </span> {{address.province}}
                                </p>
                                <p class="uk-margin-small"><span class="uk-text-bold">شهر: </span> {{address.city}}</p>
                                <p class="uk-margin-small"><span class="uk-text-bold">آدرس: </span> {{address.directions}}
                                <p class="uk-margin-small"><span class="uk-text-bold">کدپستی: </span> {{address.zip}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-text-center uk-border-rounded uk-width-1-5@s">
                    <div class="address-container uk-border-rounded uk-padding-small clickable uk-flex uk-flex-middle uk-flex-center"
                         @click="showAddressModal">
                        <div>
                            <i class="uk-margin-small-bottom uk-text-primary" data-uk-icon="icon:plus;ratio:2"></i>
                            <p class="uk-margin-remove uk-text-small uk-text-primary">افزودن آدرس جدید</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal class="uk-modal-container" name="address">
            <h2>ثبت آدرس جدید</h2>
            <form-address v-if="showModalMap" @submit="createAddress"></form-address>
        </modal>
        <div class="uk-text-center uk-margin-top">
            <button type="submit" @click.prevent="submitForm" class="uk-button uk-button-success uk-text-white uk-border-rounded">ثبت اطلاعات
            </button>
        </div>
    </form>
</template>

<script>
    export default {
        props: ['return-request'],
        name: "AddressComponent",
        mounted() {
            axios.get('/address').then((resposne) => {
                this.addresses = resposne.data.addresses;
            }).catch((e) => Toast.message(e.response.data.message))
        },
        data() {
            return {
                form: new Form({
                    address_id: {
                        rules: 'required|numeric',
                        value: null,
                    },
                    receiver_name: {
                        rules: 'required|string',
                        value: ''
                    },
                    receiver_number: {
                        rules: 'required|numeric',
                        value: ''
                    }
                }),
                addressModal: new Modal('address'),
                showModalMap: false,
                addresses: null,
                selectedAddress: null,
                alternateReceiver: false,
            }
        },
        methods: {
            showAddressModal() {
                this.addressModal.show(() => {
                    this.showModalMap = true;
                })
            },
            submitForm() {
                if (this.form.validate()) {
                    Loading.show();
                    this.$refs.form.submit();
                }
            }
        },
        watch: {
            'alternateReceiver': {
                immediate: true,
                handler(value) {
                    if (!value) {
                        this.form.receiver_name.value = this.user.name;
                        this.form.receiver_number.value = this.user.mobile;
                    } else {
                        this.form.receiver_name.value = '';
                        this.form.receiver_number.value = '';
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .address-container {
        border: 1px solid #474747;
    }
</style>