webpackJsonp([0],[
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.regex = exports.ref = exports.len = exports.req = exports.withParams = undefined;

var _withParams = __webpack_require__(76);

var _withParams2 = _interopRequireDefault(_withParams);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.withParams = _withParams2.default;

// "required" core, used in almost every validator to allow empty values

var req = exports.req = function req(value) {
  if (Array.isArray(value)) return !!value.length;
  if (value === undefined || value === null || value === false) {
    return false;
  }

  if (typeof value === 'object') {
    for (var _ in value) {
      return true;
    }return false;
  }

  return !!String(value).length;
};

// get length in type-agnostic way
var len = exports.len = function len(value) {
  if (Array.isArray(value)) return value.length;
  if (typeof value === 'object') {
    return Object.keys(value).length;
  }
  return String(value).length;
};

// resolve referenced value
var ref = exports.ref = function ref(reference, vm, parentVm) {
  return typeof reference === 'function' ? reference.call(vm, parentVm) : parentVm[reference];
};

// regex based validator template
var regex = exports.regex = function regex(type, expr) {
  return (0, _withParams2.default)({ type: type }, function (value) {
    return !req(value) || expr.test(value);
  });
};

/***/ }),
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */,
/* 6 */,
/* 7 */,
/* 8 */,
/* 9 */,
/* 10 */,
/* 11 */,
/* 12 */,
/* 13 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var Input = {

    methods: {

        /**
         * test if a string value corresponds the float Value
         *
         * @param floatVal
         * @param stringVal
         * @returns {boolean}
         */
        floatMatchesString: function floatMatchesString(floatVal, stringVal) {
            var a = floatVal;
            var b = stringVal;

            var rounded = Math.round(a * 100) / 100;
            a = rounded.toString().replace('.', ',').replace(/,\s*$/, '');

            if (b.includes(',')) b = b.replace(/((,0*)|,?0*)$/, '');

            console.log('floatVal = ' + a);
            console.log('stringVal = ' + b);
            return a === b;
        },


        /**
         * Format provided value to number type.
         * @param {String} value
         * @return {Number}
         */
        formatToNumber: function formatToNumber(value) {
            var decimal = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : ',';

            var number = 0;
            if (decimal === ',') {
                number = Number(String(value).replace(/[^0-9-,]+/g, '').replace(',', '.'));
            } else {
                number = Number(String(value).replace(/[^0-9-.]+/g, ''));
            }
            return number;
        },


        /**
         * Returns a string formated as a Price.
         *
         * @param {float} value
         * @param {string} currency
         *
         * @returns {string}
         */
        formatMoney: function formatMoney(value, currency) {
            var decimal = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : ',';

            var amount = value.toFixed(2) + ' ' + currency;

            if (decimal = ',') {
                amount = amount.replace('.', ',');
            }
            return amount;
        }
    }
};

/* harmony default export */ __webpack_exports__["a"] = (Input);

/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

exports.pushParams = pushParams;
exports.popParams = popParams;
exports.withParams = withParams;

var stack = [];

// exported for tests
var target = exports.target = null;
var _setTarget = exports._setTarget = function _setTarget(x) {
  exports.target = target = x;
};

function pushParams() {
  if (target !== null) {
    stack.push(target);
  }
  exports.target = target = {};
}

function popParams() {
  var lastTarget = target;
  var newTarget = exports.target = target = stack.pop() || null;
  if (newTarget) {
    if (!Array.isArray(newTarget.$sub)) {
      newTarget.$sub = [];
    }
    newTarget.$sub.push(lastTarget);
  }
  return lastTarget;
}

function addParams(params) {
  if (typeof params === 'object' && !Array.isArray(params)) {
    exports.target = target = _extends({}, target, params);
  } else {
    throw new Error('params must be an object');
  }
}

function withParamsDirect(params, validator) {
  return withParamsClosure(function (add) {
    return function () {
      add(params);

      for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
        args[_key] = arguments[_key];
      }

      return validator.apply(this, args);
    };
  });
}

function withParamsClosure(closure) {
  var validator = closure(addParams);
  return function () {
    pushParams();
    try {
      for (var _len2 = arguments.length, args = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
        args[_key2] = arguments[_key2];
      }

      return validator.apply(this, args);
    } finally {
      popParams();
    }
  };
}

function withParams(paramsOrClosure, maybeValidator) {
  if (typeof paramsOrClosure === 'object' && maybeValidator !== undefined) {
    return withParamsDirect(paramsOrClosure, maybeValidator);
  }
  return withParamsClosure(paramsOrClosure);
}

/***/ }),
/* 15 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_axios__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__core_Form__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vuelidate__ = __webpack_require__(59);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vuelidate___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_vuelidate__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/*
var Chart = require('chart.js');

var context = document.getElementById("myChart").getContext('2d');

new Chart(context, {
    type: 'bar',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    }
});
*/

/**
 * The nvpready theme brings its own bootstrap based on version 3
 *
 * require('./bootstrap');
 */





window.Vue = __webpack_require__(7);
Vue.use(__WEBPACK_IMPORTED_MODULE_2_vuelidate___default.a);

window.axios = __WEBPACK_IMPORTED_MODULE_0_axios___default.a;
window.Form = __WEBPACK_IMPORTED_MODULE_1__core_Form__["a" /* default */];

/**
 * vue components
 */

Vue.component('example', __webpack_require__(48));
Vue.component('portlet', __webpack_require__(51));
Vue.component('inputPrice', __webpack_require__(50));
Vue.component('icon-stat', __webpack_require__(49));
Vue.component('cash-trade', __webpack_require__(47));
Vue.component('buy-sell-btn', __webpack_require__(45));
Vue.component('cash-success', __webpack_require__(46));

window.Event = new (function () {
    function _class() {
        _classCallCheck(this, _class);

        this.vue = new Vue();
    }

    _createClass(_class, [{
        key: 'fire',
        value: function fire(event) {
            var data = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

            this.vue.$emit(event, data);
        }
    }, {
        key: 'listen',
        value: function listen(event, callback) {
            this.vue.$on(event, callback);
        }
    }]);

    return _class;
}())();

var app = new Vue({
    el: '#wrapper'
});

/***/ }),
/* 16 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 17 */,
/* 18 */,
/* 19 */,
/* 20 */,
/* 21 */,
/* 22 */,
/* 23 */,
/* 24 */,
/* 25 */,
/* 26 */,
/* 27 */,
/* 28 */,
/* 29 */,
/* 30 */,
/* 31 */,
/* 32 */,
/* 33 */,
/* 34 */,
/* 35 */,
/* 36 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            show: false,
            direction: null
        };
    },


    methods: {
        doBuy: function doBuy() {
            this.setFocus('buy');
        },
        doSell: function doSell() {
            this.setFocus('sell');
        },
        setFocus: function setFocus(direction) {
            if (this.direction !== direction) {
                this.show = true;
                this.direction = direction;
                this.fireEvent();
            } else {
                this.show = false;
                this.direction = null;
            }
        },
        fireEvent: function fireEvent() {
            if (this.buy) {
                Event.fire('onBuy');
            } else {
                Event.fire('onSell');
            }
        }
    },

    computed: {
        buy: function buy() {
            return this.direction === 'buy';
        },
        sell: function sell() {
            return this.direction === 'sell';
        }
    }
});

/***/ }),
/* 37 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mixins_Input_js__ = __webpack_require__(13);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({

    mixins: [__WEBPACK_IMPORTED_MODULE_0__mixins_Input_js__["a" /* default */]],

    props: ['route', 'decimal', 'currency'],

    data: function data() {
        return {
            show: false,
            form: new Form(),
            text: '',
            body: '',
            textDeposit: {
                title: 'Einzahlung erfolgreich',
                body: 'Auf dein Konto wurden %s eingezahlt.'
            },
            textWithdrawal: {
                title: 'Auszahlung erfolgreich',
                body: 'Von deinem Konto wurden %s ausgezahlt.'
            }
        };
    },
    created: function created() {
        var vm = this;

        Event.listen('deposit-success', function (amount) {
            console.log('deposit confirmed with amount ' + amount);
            vm.setText('deposit', amount);
            vm.showModal();
        });

        Event.listen('withdraw-success', function (amount) {
            console.log('withdrawal confirmed with amount ' + amount);
            vm.setText('withdraw', amount);
            vm.showModal();
        });
    },


    methods: {
        showModal: function showModal() {
            this.show = true;
        },
        hide: function hide() {
            this.show = false;
            location.reload(true);
        },
        setText: function setText(direction, amount) {
            var amountString = this.formatMoney(amount, this.currency, this.decimal);

            if (direction === 'deposit') {
                this.title = this.textDeposit.title;
                this.body = this.textDeposit.body.replace('%s', amountString);
            } else {
                this.title = this.textWithdrawal.title;
                this.body = this.textWithdrawal.body.replace('%s', amountString);
            }
        }
    }
});

/***/ }),
/* 38 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuelidate_lib_validators__ = __webpack_require__(65);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuelidate_lib_validators___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vuelidate_lib_validators__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_Input_js__ = __webpack_require__(13);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = ({

    mixins: [__WEBPACK_IMPORTED_MODULE_1__mixins_Input_js__["a" /* default */]],

    props: {
        route: String,
        deposit: Boolean
    },

    data: function data() {
        return {
            form: new Form({
                value: '',
                amount: null
            }),
            title: null,
            btn: {
                cls: null,
                title: null
            },
            decimal: ','
        };
    },


    validations: {
        form: {
            amount: {
                between: __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_vuelidate_lib_validators__["between"])(0, Infinity)
            }
        }
    },

    methods: {
        onSubmit: function onSubmit() {
            this.form.post(this.route).then(Event.fire(this.eventName, this.form.amount));
        }
    },

    computed: {
        classObject: function classObject() {
            if (this.error) {
                return 'form-control error';
            } else {
                return 'form-control';
            }
        },
        error: function error() {
            var match = this.floatMatchesString(this.form.amount, this.form.value);
            return this.form.amount !== null && (this.$v.form.amount.$invalid || !match);
        },
        eventName: function eventName() {
            return this.deposit ? 'deposit-success' : 'withdraw-success';
        }
    },

    watch: {
        form: {
            handler: function handler() {
                if (this.form.value === '') {
                    this.form.amount = null;
                } else {
                    this.form.amount = this.formatToNumber(this.form.value, this.decimal);
                }
            },

            deep: true
        }
    },

    created: function created() {
        if (this.deposit) {
            this.title = 'Cash einzahlen';
            this.btn.title = 'Einzahlen';
            this.btn.cls = 'btn btn-secondary';
        } else {
            this.title = 'Cash auszahlen';
            this.btn.title = 'Auszahlen';
            this.btn.cls = 'btn btn-primary';
        }
    }
});

/***/ }),
/* 39 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    mounted: function mounted() {
        console.log('Component mounted.');
    }
});

/***/ }),
/* 40 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            iconClass: 'fa icon-stat-visual '
        };
    },

    props: {
        label: { required: true },
        icon: { default: 'fa-dollar bg-primary' }
    },
    created: function created() {
        this.iconClass = this.iconClass + this.icon;
    }
});

/***/ }),
/* 41 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_numeric__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_numeric___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue_numeric__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({

    props: ['currency'],

    components: {
        VueNumeric: __WEBPACK_IMPORTED_MODULE_0_vue_numeric___default.a
    },

    data: function data() {
        return {
            price: null,
            symbol: 'EUR'
        };
    },


    methods: {
        setValue: function setValue() {
            Event.fire('set-value', this.price);
        }
    }
});

/***/ }),
/* 42 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    props: ['title']
});

/***/ }),
/* 43 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Errors = function () {
    /**
     * Create a new Errors instance.
     */
    function Errors() {
        _classCallCheck(this, Errors);

        this.errors = {};
    }

    /**
     * Determine if an errors exists for the given field.
     *
     * @param {string} field
     */


    _createClass(Errors, [{
        key: "has",
        value: function has(field) {
            return this.errors.hasOwnProperty(field);
        }

        /**
         * Determine if we have any errors.
         */

    }, {
        key: "any",
        value: function any() {
            return Object.keys(this.errors).length > 0;
        }

        /**
         * Retrieve the error message for a field.
         *
         * @param {string} field
         */

    }, {
        key: "get",
        value: function get(field) {
            if (this.errors[field]) {
                return this.errors[field][0];
            }
        }

        /**
         * Record the new errors.
         *
         * @param {object} errors
         */

    }, {
        key: "record",
        value: function record(errors) {
            this.errors = errors;
        }

        /**
         * Clear one or all error fields.
         *
         * @param {string|null} field
         */

    }, {
        key: "clear",
        value: function clear(field) {
            if (field) {
                delete this.errors[field];

                return;
            }

            this.errors = {};
        }
    }]);

    return Errors;
}();

/* harmony default export */ __webpack_exports__["a"] = (Errors);

/***/ }),
/* 44 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__Errors__ = __webpack_require__(43);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }



var Form = function () {
    /**
     * Create a new Form instance.
     *
     * @param {object} data
     */
    function Form(data) {
        _classCallCheck(this, Form);

        this.originalData = data;

        for (var field in data) {
            this[field] = data[field];
        }

        this.errors = new __WEBPACK_IMPORTED_MODULE_0__Errors__["a" /* default */]();
    }

    /**
     * Fetch all relevant data for the form.
     */


    _createClass(Form, [{
        key: 'data',
        value: function data() {
            var data = {};

            for (var property in this.originalData) {
                data[property] = this[property];
            }

            return data;
        }

        /**
         * Reset the form fields.
         */

    }, {
        key: 'reset',
        value: function reset() {
            for (var field in this.originalData) {
                this[field] = '';
            }

            this.errors.clear();
        }

        /**
         * Send a POST request to the given URL.
         * .
         * @param {string} url
         */

    }, {
        key: 'post',
        value: function post(url) {
            return this.submit('post', url);
        }

        /**
         * Send a PUT request to the given URL.
         * .
         * @param {string} url
         */

    }, {
        key: 'put',
        value: function put(url) {
            return this.submit('put', url);
        }

        /**
         * Send a PATCH request to the given URL.
         * .
         * @param {string} url
         */

    }, {
        key: 'patch',
        value: function patch(url) {
            return this.submit('patch', url);
        }

        /**
         * Send a DELETE request to the given URL.
         * .
         * @param {string} url
         */

    }, {
        key: 'delete',
        value: function _delete(url) {
            return this.submit('delete', url);
        }

        /**
         * Submit the form.
         *
         * @param {string} requestType
         * @param {string} url
         */

    }, {
        key: 'submit',
        value: function submit(requestType, url) {
            var _this = this;

            return new Promise(function (resolve, reject) {
                axios[requestType](url, _this.data()).then(function (response) {
                    _this.onSuccess(response.data);

                    resolve(response.data);
                }).catch(function (error) {
                    _this.onFail(error.response.data);

                    reject(error.response.data);
                });
            });
        }

        /**
         * Handle a successful form submission.
         *
         * @param {object} data
         */

    }, {
        key: 'onSuccess',
        value: function onSuccess(data) {
            this.reset();
        }

        /**
         * Handle a failed form submission.
         *
         * @param {object} errors
         */

    }, {
        key: 'onFail',
        value: function onFail(errors) {
            this.errors.record(errors);
        }
    }]);

    return Form;
}();

/* harmony default export */ __webpack_exports__["a"] = (Form);

/***/ }),
/* 45 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(2)(
  /* script */
  __webpack_require__(36),
  /* template */
  null,
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/home/vagrant/Code/ctrade/resources/assets/js/components/BuySellBtn.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0c7af38e", Component.options)
  } else {
    hotAPI.reload("data-v-0c7af38e", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),
/* 46 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(2)(
  /* script */
  __webpack_require__(37),
  /* template */
  __webpack_require__(53),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/home/vagrant/Code/ctrade/resources/assets/js/components/CashSuccess.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] CashSuccess.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3c6c022b", Component.options)
  } else {
    hotAPI.reload("data-v-3c6c022b", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),
/* 47 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(2)(
  /* script */
  __webpack_require__(38),
  /* template */
  __webpack_require__(52),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/home/vagrant/Code/ctrade/resources/assets/js/components/CashTrade.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] CashTrade.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3237c1e8", Component.options)
  } else {
    hotAPI.reload("data-v-3237c1e8", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),
/* 48 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(2)(
  /* script */
  __webpack_require__(39),
  /* template */
  __webpack_require__(54),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/home/vagrant/Code/ctrade/resources/assets/js/components/Example.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Example.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-431fba76", Component.options)
  } else {
    hotAPI.reload("data-v-431fba76", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),
/* 49 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(2)(
  /* script */
  __webpack_require__(40),
  /* template */
  __webpack_require__(57),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/home/vagrant/Code/ctrade/resources/assets/js/components/IconStat.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] IconStat.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-b11249bc", Component.options)
  } else {
    hotAPI.reload("data-v-b11249bc", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),
/* 50 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(2)(
  /* script */
  __webpack_require__(41),
  /* template */
  __webpack_require__(58),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/home/vagrant/Code/ctrade/resources/assets/js/components/InputPrice.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] InputPrice.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-c7edb7d8", Component.options)
  } else {
    hotAPI.reload("data-v-c7edb7d8", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),
/* 51 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(2)(
  /* script */
  __webpack_require__(42),
  /* template */
  __webpack_require__(56),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/home/vagrant/Code/ctrade/resources/assets/js/components/Portlet.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Portlet.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7eaaf755", Component.options)
  } else {
    hotAPI.reload("data-v-7eaaf755", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),
/* 52 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('h4', {
    staticClass: "title"
  }, [_vm._v(_vm._s(_vm.title))]), _vm._v(" "), _c('form', {
    on: {
      "submit": function($event) {
        $event.preventDefault();
        _vm.onSubmit($event)
      }
    }
  }, [_c('div', {
    staticClass: "form-group"
  }, [_c('label', {
    staticClass: "control-label col-xs-2 cursor-pointer",
    attrs: {
      "for": "amount"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "col-xs-7"
  }, [_c('div', {
    staticClass: "input-group"
  }, [_c('span', {
    staticClass: "input-group-addon"
  }, [_vm._v("EUR")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.form.value),
      expression: "form.value"
    }],
    class: _vm.classObject,
    attrs: {
      "type": "text",
      "id": "value",
      "name": "value",
      "placeholder": "Betrag"
    },
    domProps: {
      "value": (_vm.form.value)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.form.value = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('p', {
    staticClass: "error-text"
  }, [(_vm.error) ? _c('span', [_vm._v("Ungültiger Wert.")]) : _vm._e(), _vm._v(" "), (_vm.form.errors.has('amount')) ? _c('span', {
    domProps: {
      "textContent": _vm._s(_vm.form.errors.get('amount'))
    }
  }) : _vm._e()]), _vm._v(" "), _c('input', {
    attrs: {
      "amount": _vm.form.amount,
      "type": "hidden",
      "name": "cash",
      "id": "cash"
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "col-xs-2"
  }, [_c('button', {
    class: _vm.btn.cls
  }, [_vm._v(_vm._s(_vm.btn.title))])])])])])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-3237c1e8", module.exports)
  }
}

/***/ }),
/* 53 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return (_vm.show) ? _c('div', [_c('div', {
    staticClass: "modal-backdrop fade in",
    on: {
      "click": _vm.hide
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "modal show",
    attrs: {
      "id": "confirm",
      "role": "dialog",
      "aria-labelledby": "confirm"
    }
  }, [_c('div', {
    staticClass: "modal-dialog",
    attrs: {
      "role": "document"
    }
  }, [_c('div', {
    staticClass: "modal-content"
  }, [_c('div', {
    staticClass: "modal-header"
  }, [_c('button', {
    staticClass: "close",
    attrs: {
      "type": "button",
      "data-dismiss": "modal",
      "aria-hidden": "true"
    },
    on: {
      "click": _vm.hide
    }
  }, [_vm._v("\n                        ×\n                    ")]), _vm._v(" "), _c('h3', {
    staticClass: "modal-title"
  }, [_vm._v(_vm._s(_vm.title))])]), _vm._v(" "), _c('div', {
    staticClass: "modal-body"
  }, [_vm._v("W\n                    "), _c('span', {
    staticClass: "lead"
  }, [_vm._v(_vm._s(_vm.body))])]), _vm._v(" "), _c('div', {
    staticClass: "modal-footer"
  }, [_c('button', {
    staticClass: "btn btn-success",
    attrs: {
      "type": "button"
    },
    on: {
      "click": _vm.hide
    }
  }, [_vm._v("Weiter")])])])])])]) : _vm._e()
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-3c6c022b", module.exports)
  }
}

/***/ }),
/* 54 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _vm._m(0)
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "container"
  }, [_c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-md-8 col-md-offset-2"
  }, [_c('div', {
    staticClass: "panel panel-default"
  }, [_c('div', {
    staticClass: "panel-heading"
  }, [_vm._v("Example Component")]), _vm._v(" "), _c('div', {
    staticClass: "panel-body"
  }, [_vm._v("\n                    I'm an example component!\n                ")])])])])])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-431fba76", module.exports)
  }
}

/***/ }),
/* 55 */,
/* 56 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "portlet portlet-boxed"
  }, [_c('div', {
    staticClass: "portlet-header"
  }, [_c('h3', {
    staticClass: "portlet-title"
  }, [_c('u', [_vm._v(_vm._s(_vm.title))])])]), _vm._v(" "), _c('div', {
    staticClass: "portlet-body"
  }, [_c('div', {
    staticClass: "row"
  }, [_vm._t("default")], 2)])])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-7eaaf755", module.exports)
  }
}

/***/ }),
/* 57 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "icon-stat"
  }, [_c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-xs-8 text-left"
  }, [_c('span', {
    staticClass: "icon-stat-label"
  }, [_vm._v(_vm._s(_vm.label))]), _vm._v(" "), _c('span', {
    staticClass: "icon-stat-value"
  }, [_vm._t("default")], 2)]), _vm._v(" "), _c('div', {
    staticClass: "col-xs-4 text-center"
  }, [_c('i', {
    class: _vm.iconClass
  })])]), _vm._v(" "), _vm._m(0)])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "icon-stat-footer"
  }, [_c('i', {
    staticClass: "fa fa-clock-o"
  }), _vm._v(" Updated Now\n    ")])
}]}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-b11249bc", module.exports)
  }
}

/***/ }),
/* 58 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('vue-numeric', {
    attrs: {
      "currency": _vm.currency,
      "min": "0",
      "placeholder": "only number allowed",
      "separator": ".",
      "minus": false,
      "precision": 2,
      "currency-symbol-position": "suffix"
    },
    on: {
      "input": _vm.setValue
    },
    model: {
      value: (_vm.price),
      callback: function($$v) {
        _vm.price = $$v
      },
      expression: "price"
    }
  })
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-c7edb7d8", module.exports)
  }
}

/***/ }),
/* 59 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.withParams = exports.validationMixin = exports.Vuelidate = undefined;

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

var _vval = __webpack_require__(75);

var _params = __webpack_require__(14);

var buildFromKeys = function buildFromKeys(keys, fn, keyFn) {
  return keys.reduce(function (build, key) {
    build[keyFn ? keyFn(key) : key] = fn(key);
    return build;
  }, {});
};

function isPromise(object) {
  return (typeof object === 'object' || typeof object === 'function') && typeof object.then === 'function';
}

var getPath = function getPath(ctx, obj, path, fallback) {
  if (typeof path === 'function') {
    return path.call(ctx, obj, fallback);
  }

  path = Array.isArray(path) ? path : path.split('.');
  for (var i = 0; i < path.length; i++) {
    if (obj && typeof obj === 'object') {
      obj = obj[path[i]];
    } else {
      return fallback;
    }
  }

  return typeof obj === 'undefined' ? fallback : obj;
};

var __isVuelidateAsyncVm = '__isVuelidateAsyncVm';
function makePendingAsyncVm(Vue, promise) {
  var asyncVm = new Vue({
    data: {
      p: true, // pending
      v: false // value
    }
  });

  promise.then(function (value) {
    asyncVm.p = false;
    asyncVm.v = value;
  }, function (error) {
    asyncVm.p = false;
    asyncVm.v = false;
    throw error;
  });

  asyncVm[__isVuelidateAsyncVm] = true;
  return asyncVm;
}

var validationGetters = {
  $invalid: function $invalid() {
    var proxy = this.proxy;
    return this.nestedKeys.some(function (nested) {
      return proxy[nested].$invalid;
    }) || this.ruleKeys.some(function (rule) {
      return !proxy[rule];
    });
  },
  $dirty: function $dirty() {
    if (this.dirty) {
      return true;
    }
    if (this.nestedKeys.length === 0) {
      return false;
    }

    var proxy = this.proxy;
    return this.nestedKeys.every(function (key) {
      return proxy[key].$dirty;
    });
  },
  $error: function $error() {
    return this.$dirty && !this.$pending && this.$invalid;
  },
  $pending: function $pending() {
    var _this = this;

    var proxy = this.proxy;
    return this.nestedKeys.some(function (key) {
      return proxy[key].$pending;
    }) || this.ruleKeys.some(function (key) {
      return _this.getRef(key).$pending;
    });
  },
  $params: function $params() {
    var _this2 = this;

    var vals = this.validations;
    return _extends({}, buildFromKeys(this.nestedKeys, function (key) {
      return vals[key] && vals[key].$params || null;
    }), buildFromKeys(this.ruleKeys, function (key) {
      return _this2.getRef(key).$params;
    }));
  }
};

function setDirtyRecursive(newState) {
  this.dirty = newState;
  var proxy = this.proxy;
  var method = newState ? '$touch' : '$reset';
  this.nestedKeys.forEach(function (key) {
    proxy[key][method]();
  });
}

var validationMethods = {
  $touch: function $touch() {
    setDirtyRecursive.call(this, true);
  },
  $reset: function $reset() {
    setDirtyRecursive.call(this, false);
  },
  $flattenParams: function $flattenParams() {
    var proxy = this.proxy;
    var params = [];
    for (var key in this.$params) {
      if (this.isNested(key)) {
        var childParams = proxy[key].$flattenParams();
        for (var j = 0; j < childParams.length; j++) {
          childParams[j].path.unshift(key);
        }
        params = params.concat(childParams);
      } else {
        params.push({ path: [], name: key, params: this.$params[key] });
      }
    }
    return params;
  }
};

var getterNames = Object.keys(validationGetters);
var methodNames = Object.keys(validationMethods);

var _cachedComponent = null;
var getComponent = function getComponent(Vue) {
  if (_cachedComponent) {
    return _cachedComponent;
  }

  var VBase = Vue.extend({
    beforeCreate: function beforeCreate() {
      this._vval = null;
    },
    beforeDestroy: function beforeDestroy() {
      if (this._vval) {
        (0, _vval.patchChildren)(this._vval);
      }
    },

    computed: {
      refs: function refs() {
        var oldVval = this._vval;
        this._vval = this.children;
        (0, _vval.patchChildren)(oldVval, this._vval);
        var refs = {};
        this._vval.forEach(function (c) {
          refs[c.key] = c.vm;
        });
        return refs;
      }
    }
  });

  var ValidationRule = VBase.extend({
    data: function data() {
      return {
        rule: null,
        model: null,
        parentModel: null,
        rootModel: null
      };
    },

    methods: {
      runRule: function runRule(parent) {
        // Avoid using this.parentModel to not get dependent on it.
        // Passed as an argument for workaround
        (0, _params.pushParams)();
        var rawOutput = this.rule.call(this.rootModel, this.model, parent);
        var output = isPromise(rawOutput) ? makePendingAsyncVm(Vue, rawOutput) : rawOutput;

        var rawParams = (0, _params.popParams)();
        var params = rawParams && rawParams.$sub ? rawParams.$sub.length > 1 ? rawParams : rawParams.$sub[0] : null;

        return { output: output, params: params };
      }
    },
    computed: {
      run: function run() {
        var _this3 = this;

        var parent = this.parentModel;
        var isArrayDependant = Array.isArray(parent) && parent.__ob__;

        if (isArrayDependant) {
          // force depend on the array
          var arrayDep = parent.__ob__.dep;
          arrayDep.depend();

          var target = arrayDep.constructor.target;

          if (!this._indirectWatcher) {
            var Watcher = target.constructor;
            this._indirectWatcher = new Watcher(this.rootModel, function () {
              return _this3.runRule(parent);
            }, null, { lazy: true });
          }

          // if the update cause is only the array update
          // and value stays the same, don't recalculate
          if (!this._indirectWatcher.dirty && this._lastModel === this.model) {
            this._indirectWatcher.depend();
            return target.value;
          }

          this._lastModel = this.model;
          this._indirectWatcher.evaluate();
          this._indirectWatcher.depend();
        }

        return this._indirectWatcher ? this._indirectWatcher.value : this.runRule(parent);
      },
      $params: function $params() {
        return this.run.params;
      },
      proxy: function proxy() {
        var output = this.run.output;
        if (output[__isVuelidateAsyncVm]) {
          return !!output.v;
        }
        return !!output;
      },
      $pending: function $pending() {
        var output = this.run.output;
        if (output[__isVuelidateAsyncVm]) {
          return output.p;
        }
        return false;
      }
    }
  });

  var Validation = VBase.extend({
    data: function data() {
      return {
        dirty: false,
        validations: null,
        model: null,
        prop: null,
        parentModel: null,
        rootModel: null
      };
    },

    methods: _extends({}, validationMethods, {
      getRef: function getRef(key) {
        return this.refs[key];
      },
      isNested: function isNested(key) {
        return typeof this.validations[key] !== 'function';
      }
    }),
    computed: _extends({}, validationGetters, {
      nestedKeys: function nestedKeys() {
        return this.keys.filter(this.isNested);
      },
      ruleKeys: function ruleKeys() {
        var _this4 = this;

        return this.keys.filter(function (k) {
          return !_this4.isNested(k);
        });
      },
      keys: function keys() {
        return Object.keys(this.validations).filter(function (k) {
          return k !== '$params';
        });
      },
      proxy: function proxy() {
        var _this5 = this;

        var keyDefs = buildFromKeys(this.keys, function (key) {
          return {
            enumerable: true,
            configurable: false,
            get: function get() {
              return _this5.getRef(key).proxy;
            }
          };
        });

        var getterDefs = buildFromKeys(getterNames, function (key) {
          return {
            enumerable: true,
            configurable: false,
            get: function get() {
              return _this5[key];
            }
          };
        });

        var methodDefs = buildFromKeys(methodNames, function (key) {
          return {
            enumerable: false,
            configurable: false,
            get: function get() {
              return _this5[key];
            }
          };
        });

        return Object.defineProperties({}, _extends({}, keyDefs, getterDefs, methodDefs));
      },
      children: function children() {
        var _this6 = this;

        return [].concat(this.nestedKeys.map(function (key) {
          return renderNested(_this6, key);
        }), this.ruleKeys.map(function (key) {
          return renderRule(_this6, key);
        })).filter(Boolean);
      }
    })
  });

  var GroupValidation = Validation.extend({
    methods: {
      isNested: function isNested(key) {
        return typeof this.validations[key]() !== 'undefined';
      },
      getRef: function getRef(key) {
        var vm = this;
        return {
          get proxy() {
            // default to invalid
            return vm.validations[key]() || false;
          }
        };
      }
    }
  });

  var EachValidation = Validation.extend({
    computed: {
      keys: function keys() {
        return Object.keys(this.model);
      },
      tracker: function tracker() {
        var _this7 = this;

        var trackBy = this.validations.$trackBy;
        return trackBy ? function (key) {
          return '' + getPath(_this7.rootModel, _this7.model[key], trackBy);
        } : function (x) {
          return '' + x;
        };
      },
      children: function children() {
        var _this8 = this;

        var def = this.validations;

        var validations = _extends({}, def);
        delete validations['$trackBy'];

        var usedTracks = {};

        return this.keys.map(function (key) {
          var track = _this8.tracker(key);
          if (usedTracks.hasOwnProperty(track)) {
            return null;
          }
          usedTracks[track] = true;
          return (0, _vval.h)(Validation, track, {
            validations: validations,
            prop: key,
            parentModel: _this8.model,
            model: _this8.model[key],
            rootModel: _this8.rootModel
          });
        }).filter(Boolean);
      }
    },
    methods: {
      isNested: function isNested() {
        return true;
      },
      getRef: function getRef(key) {
        return this.refs[this.tracker(key)];
      }
    }
  });

  var renderNested = function renderNested(vm, key) {
    if (key === '$each') {
      return (0, _vval.h)(EachValidation, key, {
        validations: vm.validations[key],
        parentModel: vm.parentModel,
        prop: key,
        model: vm.model,
        rootModel: vm.rootModel
      });
    }
    var validations = vm.validations[key];
    if (Array.isArray(validations)) {
      var root = vm.rootModel;
      var refVals = buildFromKeys(validations, function (path) {
        return function () {
          return getPath(root, root.$v, path);
        };
      }, function (v) {
        return Array.isArray(v) ? v.join('.') : v;
      });
      return (0, _vval.h)(GroupValidation, key, {
        validations: refVals,
        parentModel: null,
        prop: key,
        model: null,
        rootModel: root
      });
    }
    return (0, _vval.h)(Validation, key, {
      validations: validations,
      parentModel: vm.model,
      prop: key,
      model: vm.model[key],
      rootModel: vm.rootModel
    });
  };

  var renderRule = function renderRule(vm, key) {
    return (0, _vval.h)(ValidationRule, key, {
      rule: vm.validations[key],
      parentModel: vm.parentModel,
      model: vm.model,
      rootModel: vm.rootModel
    });
  };

  _cachedComponent = { VBase: VBase, Validation: Validation };
  return _cachedComponent;
};

var _cachedVue = null;
function getVue(rootVm) {
  if (_cachedVue) return _cachedVue;
  var Vue = rootVm.constructor;
  /* istanbul ignore next */
  while (Vue.super) {
    Vue = Vue.super;
  }_cachedVue = Vue;
  return Vue;
}

var validateModel = function validateModel(model, validations) {
  var Vue = getVue(model);

  var _getComponent = getComponent(Vue),
      Validation = _getComponent.Validation,
      VBase = _getComponent.VBase;

  var root = new VBase({
    computed: {
      children: function children() {
        var vals = typeof validations === 'function' ? validations.call(model) : validations;

        return [(0, _vval.h)(Validation, '$v', {
          validations: vals,
          parentModel: null,
          prop: '$v',
          model: model,
          rootModel: model
        })];
      }
    }
  });
  return root;
};

var validationMixin = {
  data: function data() {
    var vals = this.$options.validations;
    if (vals) {
      this._vuelidate = validateModel(this, vals);
    }
    return {};
  },
  beforeCreate: function beforeCreate() {
    var _this9 = this;

    var options = this.$options;
    var vals = options.validations;
    if (!vals) return;
    if (!options.computed) options.computed = {};
    options.computed.$v = function () {
      return _this9._vuelidate.refs.$v.proxy;
    };
  },
  beforeDestroy: function beforeDestroy() {
    if (this._vuelidate) {
      this._vuelidate.$destroy();
      this._vuelidate = null;
    }
  }
};

function Vuelidate(Vue) {
  Vue.mixin(validationMixin);
}

exports.Vuelidate = Vuelidate;
exports.validationMixin = validationMixin;
exports.withParams = _params.withParams;
exports.default = Vuelidate;

/***/ }),
/* 60 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _common = __webpack_require__(0);

exports.default = (0, _common.regex)('alpha', /^[a-zA-Z]*$/);

/***/ }),
/* 61 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _common = __webpack_require__(0);

exports.default = (0, _common.regex)('alphaNum', /^[a-zA-Z0-9]*$/);

/***/ }),
/* 62 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _common = __webpack_require__(0);

exports.default = function () {
  for (var _len = arguments.length, validators = Array(_len), _key = 0; _key < _len; _key++) {
    validators[_key] = arguments[_key];
  }

  return (0, _common.withParams)({ type: 'and' }, function () {
    var _this = this;

    for (var _len2 = arguments.length, args = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
      args[_key2] = arguments[_key2];
    }

    return validators.length > 0 && validators.reduce(function (valid, fn) {
      return valid && fn.apply(_this, args);
    }, true);
  });
};

/***/ }),
/* 63 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _common = __webpack_require__(0);

exports.default = function (min, max) {
  return (0, _common.withParams)({ type: 'between', min: min, max: max }, function (value) {
    return !(0, _common.req)(value) || !/\s/.test(value) && +min <= +value && +max >= +value;
  });
};

/***/ }),
/* 64 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _common = __webpack_require__(0);

var emailRegex = /(^$|^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$)/;

exports.default = (0, _common.regex)('email', emailRegex);

/***/ }),
/* 65 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.and = exports.or = exports.url = exports.sameAs = exports.requiredUnless = exports.requiredIf = exports.required = exports.minLength = exports.maxLength = exports.email = exports.between = exports.numeric = exports.alphaNum = exports.alpha = undefined;

var _alpha = __webpack_require__(60);

var _alpha2 = _interopRequireDefault(_alpha);

var _alphaNum = __webpack_require__(61);

var _alphaNum2 = _interopRequireDefault(_alphaNum);

var _numeric = __webpack_require__(68);

var _numeric2 = _interopRequireDefault(_numeric);

var _between = __webpack_require__(63);

var _between2 = _interopRequireDefault(_between);

var _email = __webpack_require__(64);

var _email2 = _interopRequireDefault(_email);

var _maxLength = __webpack_require__(66);

var _maxLength2 = _interopRequireDefault(_maxLength);

var _minLength = __webpack_require__(67);

var _minLength2 = _interopRequireDefault(_minLength);

var _required = __webpack_require__(70);

var _required2 = _interopRequireDefault(_required);

var _requiredIf = __webpack_require__(71);

var _requiredIf2 = _interopRequireDefault(_requiredIf);

var _requiredUnless = __webpack_require__(72);

var _requiredUnless2 = _interopRequireDefault(_requiredUnless);

var _sameAs = __webpack_require__(73);

var _sameAs2 = _interopRequireDefault(_sameAs);

var _url = __webpack_require__(74);

var _url2 = _interopRequireDefault(_url);

var _or = __webpack_require__(69);

var _or2 = _interopRequireDefault(_or);

var _and = __webpack_require__(62);

var _and2 = _interopRequireDefault(_and);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.alpha = _alpha2.default;
exports.alphaNum = _alphaNum2.default;
exports.numeric = _numeric2.default;
exports.between = _between2.default;
exports.email = _email2.default;
exports.maxLength = _maxLength2.default;
exports.minLength = _minLength2.default;
exports.required = _required2.default;
exports.requiredIf = _requiredIf2.default;
exports.requiredUnless = _requiredUnless2.default;
exports.sameAs = _sameAs2.default;
exports.url = _url2.default;
exports.or = _or2.default;
exports.and = _and2.default;

/***/ }),
/* 66 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _common = __webpack_require__(0);

exports.default = function (length) {
  return (0, _common.withParams)({ type: 'maxLength', max: length }, function (value) {
    return !(0, _common.req)(value) || (0, _common.len)(value) <= length;
  });
};

/***/ }),
/* 67 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _common = __webpack_require__(0);

exports.default = function (length) {
  return (0, _common.withParams)({ type: 'minLength', min: length }, function (value) {
    return !(0, _common.req)(value) || (0, _common.len)(value) >= length;
  });
};

/***/ }),
/* 68 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _common = __webpack_require__(0);

exports.default = (0, _common.regex)('numeric', /^[0-9]*$/);

/***/ }),
/* 69 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _common = __webpack_require__(0);

exports.default = function () {
  for (var _len = arguments.length, validators = Array(_len), _key = 0; _key < _len; _key++) {
    validators[_key] = arguments[_key];
  }

  return (0, _common.withParams)({ type: 'or' }, function () {
    var _this = this;

    for (var _len2 = arguments.length, args = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
      args[_key2] = arguments[_key2];
    }

    return validators.length > 0 && validators.reduce(function (valid, fn) {
      return valid || fn.apply(_this, args);
    }, false);
  });
};

/***/ }),
/* 70 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _common = __webpack_require__(0);

exports.default = (0, _common.withParams)({ type: 'required' }, _common.req);

/***/ }),
/* 71 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _common = __webpack_require__(0);

exports.default = function (prop) {
  return (0, _common.withParams)({ type: 'requiredIf', prop: prop }, function (value, parentVm) {
    return (0, _common.ref)(prop, this, parentVm) ? (0, _common.req)(value) : true;
  });
};

/***/ }),
/* 72 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _common = __webpack_require__(0);

exports.default = function (prop) {
  return (0, _common.withParams)({ type: 'requiredUnless', prop: prop }, function (value, parentVm) {
    return !(0, _common.ref)(prop, this, parentVm) ? (0, _common.req)(value) : true;
  });
};

/***/ }),
/* 73 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _common = __webpack_require__(0);

exports.default = function (equalTo) {
  return (0, _common.withParams)({ type: 'sameAs', eq: equalTo }, function (value, parentVm) {
    return value === (0, _common.ref)(equalTo, this, parentVm);
  });
};

/***/ }),
/* 74 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _common = __webpack_require__(0);

var urlRegex = /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/;

exports.default = (0, _common.regex)('url', urlRegex);

/***/ }),
/* 75 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.patchChildren = patchChildren;
exports.h = h;
// a minimial single-layer implementation
// of virtual-validation patching,
// based on Vue's snabbdom clone

function isUndef(v) {
  return v === null || v === undefined;
}

function isDef(v) {
  return v !== null && v !== undefined;
}

function sameVval(oldVval, vval) {
  return vval.tag === oldVval.tag && vval.key === oldVval.key;
}

function createVm(vval) {
  var Vm = vval.tag;
  vval.vm = new Vm({ data: vval.args });
}

function updateVval(vval) {
  var keys = Object.keys(vval.args);
  for (var i = 0; i < keys.length; i++) {
    keys.forEach(function (k) {
      vval.vm[k] = vval.args[k];
    });
  }
}

function createKeyToOldIdx(children, beginIdx, endIdx) {
  var i = void 0,
      key = void 0;
  var map = {};
  for (i = beginIdx; i <= endIdx; ++i) {
    key = children[i].key;
    if (isDef(key)) map[key] = i;
  }
  return map;
}

function updateChildren(oldCh, newCh) {
  var oldStartIdx = 0;
  var newStartIdx = 0;
  var oldEndIdx = oldCh.length - 1;
  var oldStartVval = oldCh[0];
  var oldEndVval = oldCh[oldEndIdx];
  var newEndIdx = newCh.length - 1;
  var newStartVval = newCh[0];
  var newEndVval = newCh[newEndIdx];
  var oldKeyToIdx = void 0,
      idxInOld = void 0,
      elmToMove = void 0;

  while (oldStartIdx <= oldEndIdx && newStartIdx <= newEndIdx) {
    if (isUndef(oldStartVval)) {
      oldStartVval = oldCh[++oldStartIdx]; // Vval has been moved left
    } else if (isUndef(oldEndVval)) {
      oldEndVval = oldCh[--oldEndIdx];
    } else if (sameVval(oldStartVval, newStartVval)) {
      patchVval(oldStartVval, newStartVval);
      oldStartVval = oldCh[++oldStartIdx];
      newStartVval = newCh[++newStartIdx];
    } else if (sameVval(oldEndVval, newEndVval)) {
      patchVval(oldEndVval, newEndVval);
      oldEndVval = oldCh[--oldEndIdx];
      newEndVval = newCh[--newEndIdx];
    } else if (sameVval(oldStartVval, newEndVval)) {
      // Vval moved right
      patchVval(oldStartVval, newEndVval);
      oldStartVval = oldCh[++oldStartIdx];
      newEndVval = newCh[--newEndIdx];
    } else if (sameVval(oldEndVval, newStartVval)) {
      // Vval moved left
      patchVval(oldEndVval, newStartVval);
      oldEndVval = oldCh[--oldEndIdx];
      newStartVval = newCh[++newStartIdx];
    } else {
      if (isUndef(oldKeyToIdx)) oldKeyToIdx = createKeyToOldIdx(oldCh, oldStartIdx, oldEndIdx);
      idxInOld = isDef(newStartVval.key) ? oldKeyToIdx[newStartVval.key] : null;
      if (isUndef(idxInOld)) {
        // New element
        createVm(newStartVval);
        newStartVval = newCh[++newStartIdx];
      } else {
        elmToMove = oldCh[idxInOld];
        if (sameVval(elmToMove, newStartVval)) {
          patchVval(elmToMove, newStartVval);
          oldCh[idxInOld] = undefined;
          newStartVval = newCh[++newStartIdx];
        } else {
          // same key but different element. treat as new element
          createVm(newStartVval);
          newStartVval = newCh[++newStartIdx];
        }
      }
    }
  }
  if (oldStartIdx > oldEndIdx) {
    addVvals(newCh, newStartIdx, newEndIdx);
  } else if (newStartIdx > newEndIdx) {
    removeVvals(oldCh, oldStartIdx, oldEndIdx);
  }
}

function addVvals(vvals, startIdx, endIdx) {
  for (; startIdx <= endIdx; ++startIdx) {
    createVm(vvals[startIdx]);
  }
}

function removeVvals(vvals, startIdx, endIdx) {
  for (; startIdx <= endIdx; ++startIdx) {
    var ch = vvals[startIdx];
    if (isDef(ch)) {
      ch.vm.$destroy();
      ch.vm = null;
    }
  }
}

function patchVval(oldVval, vval) {
  if (oldVval === vval) {
    return;
  }
  vval.vm = oldVval.vm;
  updateVval(vval);
}

function patchChildren(oldCh, ch) {
  if (isDef(oldCh) && isDef(ch)) {
    if (oldCh !== ch) updateChildren(oldCh, ch);
  } else if (isDef(ch)) {
    addVvals(ch, 0, ch.length - 1);
  } else if (isDef(oldCh)) {
    removeVvals(oldCh, 0, oldCh.length - 1);
  }
}

function h(tag, key, args) {
  return { tag: tag, key: key, args: args };
}

/***/ }),
/* 76 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
/* istanbul ignore next */
var withParams =  false ? require('./withParamsBrowser').withParams : __webpack_require__(14).withParams;

exports.default = withParams;

/***/ }),
/* 77 */,
/* 78 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(15);
module.exports = __webpack_require__(16);


/***/ })
],[78]);