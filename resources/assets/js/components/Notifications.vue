<template>
    <li class="dropdown navbar-notification">

        <a href="#" class="dropdown-toggle" :class="{open: show}" @click="toggle"
           data-toggle="dropdown" data-hover="dropdown">

            <i class="fa fa-warning navbar-notification-icon"></i>
            <span class="visible-xs-inline">&nbsp;Alerts</span>

            <b v-if="count > 0" class="badge badge-primary">{{ count }}</b>

            <ul class="dropdown-menu">
                <div class="dropdown-header">&nbsp;Notifications</div>

                <div class="notification-list">

                    <li v-for="(notification, index) in notifications" class="notification" :class="itemClass(index)">
                        <span class="notification-icon"><i class="fa fa-cloud-upload text-primary"></i></span>
                        <span class="notification-title">{{ notification.title }}</span>
                        <span class="notification-description">{{ notification.message }}</span>
                        <span class="notification-time">ago</span>
                    </li>

                </div>

                <a href="#" class="notification-link">Alle Benachichtigungen</a>
            </ul>
        </a>
    </li>

</template>

<script>

    export default {

        props: ['user_id', 'unread'],

        data() {
            return {
                notifications: [],
                show: false,
                seen: 0
            }
        },

        computed: {
            count() {
                return this.notifications.length - this.seen;
            }
        },

        methods: {

            type(item) {
                return _.snakeCase(type.substring(item.type.lastIndexOf('/') + 1));
            },

            hasSeen(index) {
                return index <= this.seen;
            },

            toggle(event) {
                this.show = !this.show;

                if (this.show) {
                    this.seen = Math.max(this.count, this.seen);
                }
            },

            markNotificationsRead() {
                this.axios.post('/api/notifications/read')
                    .then(()=>{
                        this.notifications = [];
                    });
            },

            itemClass(index) {
                return (this.hasSeen(index)) ? 'notification-seen' : ''
            },

            assign(data) {
                let result = [];
                data.forEach(function(item) {
                    result.push({
                        'title': item.data.title,
                        'message': item.data.message,
                        'type': item.type
                    });
                });
                this.notifications = result;
            }
        },


        created() {
            this.assign(Object.values(this.unread));
        },

        mounted() {

            Echo.private('App.Entities.User.' + this.user_id)
                .notification((data) => {
                    this.notifications.push({
                        'title': data.title,
                        'message': data.message,
                        'type': data.type
                    });
                    console.log(data);
                });
        },

        beforeDestroy() {
            this.markNotificationsRead();
        }

    };

</script>

<style>
    .notification-seen {
        color: dimgrey;
    }
</style>
