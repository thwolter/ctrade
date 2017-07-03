<template>
    <div>
        <h4 class="title">{{ title }}</h4>

        <form @submit.prevent="onSubmit">
            <div class="form-group">
                <label for="amount" class="control-label col-xs-2 cursor-pointer"></label>
                <div class="col-xs-7">
                    <input type="text" id="amount" name="amount" class="form-control" v-model="form.amount">
                </div>
                <div class="col-xs-2">
                    <button :class="btnClass">{{ btnTitle }}</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            route: String,
            deposit: Boolean
        },

        data() {
            return {
                form: new Form({
                    amount: null,
                }),
                title: null,
                btnTitle: null,
                btnClass: null
            }
        },

        methods: {
            onSubmit() {
                this.form.post(this.route)
                    .then(response => alert('Wahoo!'));
            }
        },

        created() {
            if (this.deposit) {
                this.title = 'Cash einzahlen';
                this.btnTitle = 'Einzahlen';
                this.btnClass = 'btn btn-secondary';
            } else {
                this.title = 'Cash auszahlen';
                this.btnTitle = 'Auszahlen';
                this.btnClass = 'btn btn-primary'
            }
        }
    }
</script>