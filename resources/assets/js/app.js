
require('./bootstrap');


import Vue from 'vue'
import axios from 'axios';
import Vuelidate from 'vuelidate';
import VueResource from 'vue-resource';

import Form from './core/Form';
import Event from './core/Event';
import Colors from './core/Colors';

/**
 * components from VueStrap
 * 
 */ 
import popover from 'vue-strap';

window.Vue = Vue;
window.Form = Form;
window.Event = new Event;
window.Colors = new Colors;

Vue.use(Vuelidate);
Vue.use(VueResource);

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
Vue.component('chart', require('./components/Chart.vue'));
Vue.component('positions-chart', require('./components/PositionsChart.vue'));
Vue.component('value-chart', require('./components/ValueChart.vue'));
Vue.component('spinner', require('./components/Spinner.vue'));
Vue.component('limit-stats', require('./components/LimitsStats.vue'));


const app = new Vue({
    el: '#wrapper',
    
    components: {
        popover
    }
});


