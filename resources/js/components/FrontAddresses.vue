<template>
    <div>
        <button @click="createAddressModal.show()"
                class="uk-button uk-button-primary uk-border-rounded uk-margin"><span uk-icon="plus"></span>
            افزودن آدرس جدید
        </button>
        <paginated-view ref="pv" @fetched="scroll" filterless="true" fetch-url="/address?paginated=true">
            <template v-slot="scopeData">
                <div v-for="address in scopeData.records" class="uk-grid uk-grid-small uk-flex uk-flex-middle" data-uk-grid>
                    <div class="uk-width-expand@m">
                        <div class="uk-margin-bottom">
                            <span>استان: </span><a>{{address.province}}</a> <span class="uk-margin-large-left">شهر: </span><a>{{address.city}}</a>
                        </div>
                        <div class="uk-margin-bottom">
                            نشانی: {{address.directions}}
                        </div>
                        <div class="uk-margin-bottom">
                            کد پستی: {{address.zip}}
                        </div>
                        <a class="uk-margin-small-right" @click="editAddress(address)">ویرایش <span uk-icon="pencil"></span></a>
                        <a class="uk-text-danger" @click="deleteAddress(address)">حذف <span uk-icon="trash"></span></a>
                    </div>
                    <div class="uk-width-1-4@m">
                        <mapbox height="200" :value="[address.longitude, address.latitude]"></mapbox>
                    </div>
                    <div class="uk-width-1-1">
                        <hr/>
                    </div>
                </div>
            </template>
        </paginated-view>
        <modal class="uk-modal-container" name="address" dir="rtl">
            <h2>ویرایش آدرس</h2>
            <form-address :key="selectedAddress ? selectedAddress.id : 'addressKEy'" :address="selectedAddress"
                          @submit="updateAddress"></form-address>
        </modal>
        <modal class="uk-modal-container" name="create-address" dir="rtl">
            <h2>ثبت آدرس جدید</h2>
            <form-address @submit="createAddress"></form-address>
        </modal>
    </div>
</template>

<script>
    export default {
        props: ['category', 'options'],
        data() {
            return {
                addressModal: new Modal('address'),
                createAddressModal: new Modal('create-address'),
                selectedAddress: null,
            }
        },
        methods: {
            scroll() {
                this.$el.scrollIntoView({behavior: 'smooth'});
            },
            updateAddress(address) {
                Loading.show();
                axios.post(`/address/${this.selectedAddress.id}`, address.asFormData('patch')).then(() => {
                    Toast.message("نشانی با موفقیت به روز رسانی شد").success().show();
                    window.location.reload();
                })
                    .catch((e) => Toast.message(e.response.data.message).danger().show())
                    .then(() => {
                        Loading.hide();
                    })
            },
            deleteAddress(address) {
                Loading.show();
                axios.post(`/address/${address.id}`, {_method: 'delete'}).then(() => {
                    Toast.message("نشانی با موفقیت حذف شد").success().show();
                    window.location.reload();
                }).catch((e) => Toast.message(e.response.data.message).danger().show())
                    .then(() => Loading.hide());
            },
            editAddress(address) {
                this.selectedAddress = address;
                this.addressModal.show();
            },
            createAddress(form) {
                Loading.show();
                axios.post('/address', form.asFormData()).then((response) => {
                    Toast.message('آدرس جدید با موفقیت ثبت شد').success().show();
                    window.location.reload();
                }).catch((e) => {
                    Toast.message(e.response.data.message).danger().show();
                }).then(() => {
                    Loading.hide();
                })
            },
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