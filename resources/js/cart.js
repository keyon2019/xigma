class Cart {

    constructor() {
        this.items = [];
        axios.get('/cart?json').then((response) => {
            this.items = response.data.items;
            this.vehicleVariations = _.map(_.flatten(_.map(response.data.vehicles, 'variations')), 'id')
        });
    }

    add(variation_id, quantity = 1) {
        if (this.vehicleVariations && this.vehicleVariations.length > 0) {
            if (!this.vehicleVariations.includes(variation_id)) {
                UIkit.modal.confirm("محصول انتخابی شما متعلق به هیچ یک از وسایل نقلیه انتخابی شما نیست، آیا از انتخاب خود مطمئنید؟", {
                    labels: {
                        'ok': 'بله',
                        'cancel': 'خیر'
                    }
                }).then(() => {
                    this.addMethod(variation_id, quantity);
                });
            } else {
                this.addMethod(variation_id, quantity);
            }
        } else {
            this.addMethod(variation_id, quantity);
        }
    }

    remove(variation_id) {
        axios.post('/cart', {variation_id: variation_id, _method: 'delete'}).then(() => {
            let index = _.findIndex(this.items, i => i.id === variation_id);
            if (index > -1) {
                this.items.splice(index, 1)
            }
            Toast.message("محصول با موفقیت از سبد خرید حذف شد").success().show();
        }).catch((e) => {
            Toast.message(e.response.data.message).danger().show();
        });
    }

    total() {
        return _.sumBy(this.items, (item) => {
            return item.quantity * item.price;
        });
    }

    totalQuantity() {
        return _.sumBy(this.items, (item) => {
            return item.quantity;
        })
    }

    totalDiscount() {
        return _.sumBy(this.items, (item) => {
            return item.discount;
        })
    }

    addMethod(variation_id, quantity) {
        axios.post('/cart', {variation_id: variation_id, quantity: quantity}).then((response) => {
            let item = response.data.item;
            let index = _.findIndex(this.items, i => i.id === item.id);
            if (index > -1) {
                this.items.splice(index, 1)
            }
            this.items.unshift(item);
            Toast.message("محصول با موفقیت به سبد خرید اضافه شد").success().show();
        }).catch((e) => {
            Toast.message(e.response.data.message).danger().show();
        });
    }
}

export {Cart};