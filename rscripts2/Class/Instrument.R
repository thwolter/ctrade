library(R6)


Instrument <- R6Class('Instrument',
    
    public = list(
        symbol = NULL,
        currency = NULL,
        amount = NULL,
        
        
        initialize = function(symbol, amount, currency)
        {
            self$symbol <- symbol
            self$amount <- as.numeric(amount)
            self$currency <- currency
        }
    )
)
