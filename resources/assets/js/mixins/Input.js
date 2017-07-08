var Input = {

    methods: {

        /**
         * test if a string value corresponds the float Value
         *
         * @param floatVal
         * @param stringVal
         * @returns {boolean}
         */
        floatMatchesString(floatVal, stringVal) {
            let a = floatVal;
            let b = stringVal;

            let rounded = Math.round(a * 100) / 100;
            a = rounded.toString().replace('.', ',').replace(/,\s*$/, '');

            if (b.includes(',')) b = b.replace(/((,0*)|,?0*)$/, '');

            console.log('floatVal = ' + a);
            console.log('stringVal = ' + b);
            return (a === b);
        },

        /**
         * Format provided value to number type.
         * @param {String} value
         * @return {Number}
         */
        formatToNumber (value, decimal = ',') {
            let number = 0;
            if (decimal === ',') {
                number = Number(String(value).replace(/[^0-9-,]+/g, '').replace(',', '.'))
            } else {
                number = Number(String(value).replace(/[^0-9-.]+/g, ''))
            }
            return number
        },

        /**
         * Returns a string format as a price.
         *
         * @param {float} value
         * @param {string} currency
         *
         * @returns {string}
         */
        formatMoney(value, currency = '', decimal = ',') {
            
            if (value !== null) {
            
                let amount = value.toFixed(2);
                if (currency != '') { amount = amount + ' ' + currency}
    
                if (decimal = ',') {
                    amount = amount.replace('.', ',')
                }
                return amount;
            }
        }
    }
};

export default Input;