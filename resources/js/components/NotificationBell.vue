<template>
    <li class="uk-position-relative">
        <span v-if="notifications.length > 0" class="uk-badge bell-badge uk-position-absolute uk-position-top-left"
              v-text="notifications.length"></span>
        <a href="#" data-uk-icon="icon: bell"></a>
        <div v-if="notifications.length > 0" uk-drop="offset:5">
            <div class="uk-card uk-text-small uk-card-default uk-card-body uk-border-rounded uk-box-shadow-small uk-padding-remove light-border uk-overflow-hidden">
                <div class="uk-light uk-padding-small uk-text-bold uk-text-default" style="background-color:#222a30">اعلان‌ها
                </div>
                <a @click="redirect(notification)" v-for="notification in notifications"
                   class="notification-item uk-padding-small uk-link-reset uk-display-block"
                   style="border-bottom: 1px solid gainsboro" v-text="notification.data.message">
                </a>
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        name: "NotificationBell",
        props: ['initial-notifications'],
        data() {
            return {
                showMenu: false,
                notifications: this.initialNotifications,
            }
        },
        methods: {
            redirect(notification) {
                axios.post(`/notification/${notification.id}`).then(() => {
                }).catch(() => {
                }).then(() => window.location.href = notification.data.location);
            }
        },
        mounted() {

        }
    }
</script>

<style scoped>
    .bell-badge {
        min-width: 16px !important;
        height: 16px !important;
        font-size: 10px;
        margin-top: 2px;
    }

    .notification-item {
        transition: background-color 0.2s ease;
    }

    .notification-item:hover {
        background-color: #f3f3f3;
    }
</style>