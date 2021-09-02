class Cart {

    constructor() {
        this.items = [];
        axios.get('/cart?json').then((response) => {
            this.items = response.data.items;
        });
    }

    add(variation_id, quantity = 1) {
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
}

export {Cart};