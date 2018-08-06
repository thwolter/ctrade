/**
 * vue components
 */


/* Coins */
Vue.component('search-coins', require('./components/SearchCoins.vue'));


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
Vue.component('update-limit', require('./components/limits/UpdateLimit.vue'));
Vue.component('a-limit', require('./components/limits/LinkLimit.vue'));

/* Notifications */
Vue.component('status-calculation', require('./components/notifications/StatusCalculation'));

/* Charting */
Vue.component('chart', require('./components/charts/ApiChart.vue'));
Vue.component('value-chart', require('./components/charts/ValueChart.vue'));
Vue.component('positions-chart', require('./components/charts/PositionsChart.vue'));
Vue.component('midget-chart', require('./components/charts/MidgetChart.vue'));


/* Helper */
Vue.component('cleave', require('./components/helper/Cleave.vue'));



Vue.component('limit-stats', require('./components/LimitsStats.vue'));
Vue.component('notifications', require('./components/Notifications.vue'));
Vue.component('graph', require('./components/charts/Graph.vue'));

