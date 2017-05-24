library(R6)


Instrument <- R6Class('Instrument',
    
    public = list(
        symbol = NULL,
        currency = NULL,
        amount = NULL,
        
        
        initialize = function(symbol, amount, currency)
        {
            self$symbol <- symbol
            self$amount <- amount
            self$currency <- currency
        },
        
        
        trade = function(x)
        {
            self$amount <- self$amount + x
        },
        
        
        
        amountHistory = function(dates)
        {
            amount <- xts::as.xts(rep(self$amount, times=length(dates)), dates)
            colnames(amount) <- 'Amount'
            
            return(amount)
        }
        
    )
)
