<template>
    <div>
        <b v-if="count > 0" class="badge badge-primary">{{ count }}</b>
        <div class="dropdown-menu">

            <div class="dropdown-header">&nbsp;Notifications</div>

            <div class="notification-list">

                <li v-for="notification in notifications" href="#" class="notification">
                    <span class="notification-icon"><i class="fa fa-cloud-upload text-primary"></i></span>
                    <span class="notification-title">{{ notification.data.title }}</span>
                    <span class="notification-description">{{ notification.data.message }}</span>
                    <span class="notification-time">ago</span>
                </li>

            </div>
        </div>
    </div>
</template>

<script>

    export default {

        props: ['user_id', 'unread'],

        data() {
            return {
                notifications: Object.values(this.unread),
            }
        },


        computed: {

            count() {
                return this.notifications.length;
            }
        },

        methods: {

            notificationsOfType(type) {
                let result = [];
                this.notifications.foreach(function(item) {
                    if (this.filename(item.type) == type) {
                        result.push(item)
                    }
                    return result;
                })
           },

            filename(type) {
                let file = _.snakeCase(type.substring(type.lastIndexOf('/') + 1));
                return 'notifications.unread.'.file;
            }
        },


        mounted() {

            Echo.private('App.Entities.User.' + this.user_id)
                .notification((data) => {
                    this.notifications.push(data);
                    console.log(data);
                });
        },

        created() {
            this.notifications = Object.values(this.unread)
        }

    };

</script>
