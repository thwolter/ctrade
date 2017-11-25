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

/* Limits */
Vue.component('create-limit', require('./components/limits/CreateLimit.vue'));



Vue.component('graph', require('./components/charts/Graph.vue'));
Vue.component('chart', require('./components/charts/Chart.vue'));
Vue.component('positions-chart', require('./components/charts/PositionsChart.vue'));
Vue.component('value-chart', require('./components/charts/ValueChart.vue'));

/* Helper */
Vue.component('cleave', require('./components/helper/Cleave.vue'));



Vue.component('limit-stats', require('./components/LimitsStats.vue'));
Vue.component('notifications', require('./components/Notifications.vue'));

