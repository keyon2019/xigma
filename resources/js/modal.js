class Modal {
    constructor(name) {
        this.name = name;
    }

    show() {
        Event.$emit(`show-modal-${this.name}`);
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