<template>
    <div>
        <form @submit.prevent="onSubmit">
            <div class="form-group">
                <label for="amount" class="control-label col-xs-2 cursor-pointer"></label>
                <div class="col-xs-7">
                    <input type="text" id="amount" name="amount" class="form-control" v-model="form.amount">
                </div>
                <div class="col-xs-2">
                    <button class="btn btn-secondary">Einzahlen</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['route', 'action'],

        data() {
            return {
                form: new Form({
                    amount: null,
                })
            }
        },

        methods: {
            onSubmit() {
                this.form.post('/portfolios/1/deposit')
                    .then(response => alert('Wahoo!'));
            }
        }
    }
</script>