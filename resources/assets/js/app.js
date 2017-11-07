
require('./bootstrap');


import Vue from 'vue'
import axios from 'axios';
import Vuelidate from 'vuelidate';
import VueResource from 'vue-resource';

import Form from './core/Form';
import Event from './core/Event';
import Colors from './core/Colors';


import Raven from 'raven-js';
import RavenVue from 'raven-js/plugins/vue';

import { dropdown } from 'vue-strap';


window.Vue = Vue;
window.Form = Form;
window.Event = new Event;
window.Colors = new Colors;

Vue.use(Vuelidate);
Vue.use(VueResource);
//Vue.use(InstantSearch);

// Localization
window.trans = (string, args) => {
    let value = _.get(window.i18n, string);
    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });
    return value;
};


require('./components');
require('./passport-components');


Raven
    .config('https://962f2203bdb945a9be03e5d67e2935d5@sentry.io/178330')
    .addPlugin(RavenVue, Vue)
    .install();

const app = new Vue({
    el: '#wrapper',
});


