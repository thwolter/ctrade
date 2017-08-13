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

                    <li v-for="notification in notifications" class="notification">
                        <span class="notification-icon"><i class="fa fa-cloud-upload text-primary"></i></span>
                        <span class="notification-title">{{ notification.title }}</span>
                        <span class="notification-description">{{ notification.message }}</span>
                        <span class="notification-time">{{ ago(notification) }}</span>
                    </li>

                </div>

                <a :href="show_url" class="notification-link">Alle Benachichtigungen</a>
            </ul>
        </a>
    </li>

</template>

<script>
    var moment = require('moment');

    export default {

        props: ['user_id', 'unread', 'show_url'],

        data() {
            return {
                notifications: [],
                show: false,
            }
        },

        computed: {
            count() {
                return this.notifications.length;
            }
        },

        methods: {

            type(item) {
                return _.snakeCase(type.substring(item.type.lastIndexOf('/') + 1));
            },

            toggle(event) {
                this.show = !this.show;

                if (this.show) {
                    this.markNotificationsRead();
                } else {
                    this.notifications = [];
                }
            },

            markNotificationsRead() {
                axios.post('/api/notifications/read', {
                    'id': this.user_id
                })
                    .then(()=>{
                        //this.notifications = [];
                    });
            },


            assign(data) {
                let result = [];
                data.forEach(function(item) {
                    result.push({
                        'title': item.data.title,
                        'message': item.data.message,
                        'type': item.type,
                        'updated': item.updated_at
                    });
                });
                this.notifications = result;
            },

            ago(item) {
                return moment(item.updated, "YYYYMMDD hh:mm:ss").fromNow()
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
                        'type': data.type,
                        'updated': data.updated_at,
                    });
                });
        }
    };

</script>
