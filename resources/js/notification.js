class Notification {
    constructor() {
        this.notifications = JSON.parse(document.querySelector('meta[name="notifications"]').getAttribute('content'));
    }

    has(type, key, value) {
        return this.notifications.some((n) => {
            return (n.type === `App\\Notifications\\${type}` && n.data[key] === value);
        });
    }

    markAsRead(type, key, value) {
        const notif = this.notifications.find((n) => {
            return (n.type === `App\\Notifications\\${type}` && n.data[key] === value);
        });
        if (notif) {
            axios.post(`/notification/${notif.id}`);
        }
        return true;
    }
}

export {Notification};