/**
 * vue components
 */

/* Cash */
Vue.component('cash-trade', require('./components/cash/CashTrade.vue'));

/* Stocks */
Vue.component('stock-trade', require('./components/stocks/StockTrade.vue'));
Vue.component('stock-performance', require('./components/stocks/StockPerformance.vue'));
Vue.component('stock-chart', require('./components/stocks/StockChart.vue'));

/* Search Instrument */
Vue.component('search-instrument', require('./components/trading/SearchInstrument.vue'));


Vue.component('icon-stat', require('./components/IconStat.vue'));
Vue.component('cleave', require('./components/Cleave.vue'));
Vue.component('graph', require('./components/Graph.vue'));
Vue.component('chart', require('./components/Chart.vue'));
Vue.component('positions-chart', require('./components/PositionsChart.vue'));
Vue.component('value-chart', require('./components/ValueChart.vue'));
Vue.component('spinner', require('./components/Spinner.vue'));
Vue.component('limit-stats', require('./components/LimitsStats.vue'));

Vue.component('notifications', require('./components/Notifications.vue'));
Vue.component('create-limit', require('./components/CreateLimit.vue'));

