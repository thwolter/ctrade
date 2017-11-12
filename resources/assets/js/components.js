/**
 * vue components
 */

Vue.component('cash-trade', require('./components/trading/CashTrade.vue'));
Vue.component('buy-sell-btn', require('./components/trading/BuySellBtn.vue'));
Vue.component('deposit-btn', require('./components/trading/DepositButton.vue'));
Vue.component('withdraw-btn', require('./components/trading/WithdrawButton.vue'));

Vue.component('search-stock', require('./components/trading/SearchStock.vue'));
Vue.component('trade-stock', require('./components/trading/TradeStock.vue'));

Vue.component('stock-performance', require('./components/stock/StockPerformance.vue'));
Vue.component('stock-chart', require('./components/stock/StockChart.vue'));

Vue.component('portlet', require('./components/Portlet.vue'));
Vue.component('icon-stat', require('./components/IconStat.vue'));
Vue.component('cash-success', require('./components/CashSuccess.vue'));
Vue.component('cleave', require('./components/Cleave.vue'));
Vue.component('graph', require('./components/Graph.vue'));
Vue.component('chart', require('./components/Chart.vue'));
Vue.component('positions-chart', require('./components/PositionsChart.vue'));
Vue.component('value-chart', require('./components/ValueChart.vue'));
Vue.component('spinner', require('./components/Spinner.vue'));
Vue.component('limit-stats', require('./components/LimitsStats.vue'));

Vue.component('notifications', require('./components/Notifications.vue'));
Vue.component('create-limit', require('./components/CreateLimit.vue'));

