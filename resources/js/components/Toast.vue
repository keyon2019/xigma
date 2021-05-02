<template>
    <div class="notification uk-padding uk-light uk-border-rounded uk-box-shadow-medium toast" v-html="payload.message || ''"
         :class="[payload.type, show]">
    </div>
</template>

<script>
    export default {
        props: {
            message: {
                required: true,
                type: String
            }
        },
        data() {
            return {
                payload: {message: null, type: null},
                show: ''
            }
        },
        mounted() {
            Event.$on('toast', (p) => {
                this.payload = p;
                this.showMessage();
            });
            if (this.message) {
                this.payload = JSON.parse(this.message);
                this.showMessage(5000);
            }
        },
        methods: {
            clear() {
                this.payload.message = null;
                this.payload.type = null;
            },
            showMessage(time = 3000) {
                this.show = "show";
                setTimeout(() => {
                    this.show = '';
                }, time);
            }
        }
    }

    class Toast {
        constructor() {
            this.text = "Default Message";
            this.type = "primary";
            this.event = window.Event;
        }

        message(message) {
            this.text = message;
            return this;
        }

        success() {
            this.type = 'success';
            return this;
        }

        danger() {
            this.type = 'danger';
            return this;
        }

        info() {
            this.type = 'primary';
            return this;
        }

        warning() {
            this.type = 'warning';
            return this;
        }

        show() {
            UIkit.notification({message: this.text, status: this.type, pos: 'bottom-right'});
            // Event.$emit('toast', {
            //     message: this.text,
            //     type: this.type,
            // });
        }
    }

    window.Toast = new Toast();
</script>

<style scoped>

</style>