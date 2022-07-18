<template>
    <form class="uk-inline" method="post" ref="form" :action="'/cart/from_invoice/' + invoice.id + '?' + clear">
        <input type="hidden" name="_token" :value="csrf">
        <button type="button" @click="handleCart" class="uk-button uk-button-success uk-text-white uk-border-rounded">انتقال به
            سبد خرید
        </button>
        <modal name="handle-cart-modal">
            <p>در حال حاضر سبد خرید شما دارای محصول است</p>
            <div class="uk-grid uk-grid-small">
                <div>
                    <div class="uk-button uk-button-default uk-width-expand uk-border-rounded" @click="submitForm(false)">محصولات
                        به سبد
                        اضافه شوند
                    </div>
                </div>
                <div>
                    <div class="uk-button uk-button-primary uk-width-expand uk-border-rounded" @click="submitForm(true)">محصولات
                        سبد
                        فعلی
                        حذف شوند
                    </div>
                </div>
            </div>
        </modal>
    </form>
</template>

<script>
    export default {
        props: ['invoice'],
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                clear: "",
                modal: new Modal('handle-cart-modal')
            }
        },
        methods: {
            handleCart() {
                if (Cart.items.length > 0) {
                    this.modal.show();
                    // UIkit.modal.confirm("در حال حاضر سبد خرید شما دارای محصول است", {
                    //     labels: {
                    //         'ok': 'محصولات به سبد اضافه شوند',
                    //         'cancel': 'محصولات سبد فعلی حذف شوند'
                    //     }
                    // }).then(() => {
                    //     this.$refs.form.submit();
                    // }, () => {
                    //     this.clear = "clear=1";
                    //     this.$nextTick(() => {
                    //         this.$refs.form.submit();
                    //     })
                    // });
                } else {
                    this.$refs.form.submit();
                }
            },
            submitForm(clear = false) {
                if (clear) {
                    this.clear = "clear=1";
                }
                this.$nextTick(() => {
                    this.$refs.form.submit();
                })
            }
        }
    }
</script>

<style scoped>

</style>