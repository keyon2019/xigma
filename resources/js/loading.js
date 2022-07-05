class Loading {
    show() {
        if (document.hasFocus())
            Event.$emit('show-loading-modal');
    }

    hide() {
        Event.$emit('hide-loading-modal');
    }

    close() {
        this.hide();
    }

    open() {
        this.show();
    }
}

export {Loading};