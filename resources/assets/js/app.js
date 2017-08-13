
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
import { dropdown } from 'vue-strap';



//import 'vue-instant/dist/vue-instant.css';
//import VueInstant from 'vue-instant';

window.Vue = Vue;
window.Form = Form;
window.Event = new Event;
window.Colors = new Colors;

Vue.use(Vuelidate);
Vue.use(VueResource);
//Vue.use(InstantSearch);

require('./components');


const app = new Vue({
    el: '#wrapper',
    
    components: {
        popover,
        //dropdown
    }
});


