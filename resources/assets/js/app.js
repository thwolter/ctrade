
/**
 * The nvpready theme brings its own bootstrap based on version 3
 *
 * require('./bootstrap');
 */

import axios from 'axios';
import Form from './core/Form';
import Vuelidate from 'vuelidate';

/**
 * components from VueStrap
 * 
 */ 
import popover from 'vue-strap'


window.Vue = require('vue');
Vue.use(Vuelidate);

window.axios = axios;
window.Form = Form;


/**
 * vue components
 */

Vue.component('portlet', require('./components/Portlet.vue'));
Vue.component('icon-stat', require('./components/IconStat.vue'));
Vue.component('cash-trade', require('./components/CashTrade.vue'));
Vue.component('buy-sell-btn', require('./components/BuySellBtn.vue'));
Vue.component('cash-success', require('./components/CashSuccess.vue'));
Vue.component('create-portfolio', require('./components/CreatePortfolio.vue'));
Vue.component('search-stock', require('./components/SearchStock.vue'));
Vue.component('add-stock', require('./components/AddStock.vue'));
Vue.component('cleave', require('./components/Cleave.vue'));
Vue.component('trade-stock', require('./components/TradeStock.vue'));

Vue.component('graph', require('./components/Graph.vue'));


window.Event = new class {
    constructor() {
        this.vue = new Vue();
    }
    fire(event, data = null) {
        this.vue.$emit(event, data);
    }
    listen(event, callback) {
        this.vue.$on(event, callback);
    }
};

const app = new Vue({
    el: '#wrapper',
    
    components: {
        popover
    }
});


