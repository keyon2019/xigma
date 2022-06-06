class Modal {
    constructor(name) {
        this.name = name;
    }

    static show(modalName) {
        Event.$emit(`show-modal-${modalName}`);
    }

    show(onShow = null) {
        Event.$emit(`show-modal-${this.name}`);
        if(onShow) {
            UIkit.util.on(document, 'shown', `#${this.name}`, onShow)
        }
    }

    hide() {
        Event.$emit(`hide-modal-${this.name}`);
    }

    open() {
        this.show()
    }

    close() {
        this.hide()
    }
}

export {Modal};