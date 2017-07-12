
/**
 * The nvpready theme brings its own bootstrap based on version 3
 *
 * require('./bootstrap');
 */

import Vue from 'vue'
import axios from 'axios';
import Vuelidate from 'vuelidate';

import Form from './core/Form';
import Event from './core/Event';

/**
 * components from VueStrap
 * 
 */ 
import popover from 'vue-strap'


window.Vue = Vue;
window.axios = axios;
window.Form = Form;
window.Event = new Event;

Vue.use(Vuelidate);

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
Vue.component('positions-chart', require('./components/PositionsChart.vue'));


const app = new Vue({
    el: '#wrapper',
    
    components: {
        popover
    }
});


