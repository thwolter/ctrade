
require('./bootstrap');

import Vue from 'vue';

import Form from './core/Form';
import Colors from './core/Colors';

import Raven from 'raven-js';
import RavenVue from 'raven-js/plugins/vue';

window.Vue = Vue;
window.Form = Form;
window.Colors = new Colors;


// EventBus
import Event from './core/Event';
window.Event = new Event();

// Localization
window.trans = (string, args) => {
    let value = _.get(window.i18n, string);

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });

    return value ? value : string;
};

Vue.prototype.trans = (string, args) => window.trans(string, args);


require('./components');
require('./passport-components');


Raven
    .config('https://962f2203bdb945a9be03e5d67e2935d5@sentry.io/178330')
    .addPlugin(RavenVue, Vue)
    .install();

const app = new Vue({
    el: '#wrapper',

});



