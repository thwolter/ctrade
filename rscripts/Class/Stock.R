library(R6)


Stock <- R6Class('Stock',

    inherit = Instrument,
                 
    public = list(
        
        delta = function(price, fxrate)
        {
            res <- list(price * self$amount, fxrate * price * self$amount)
            names(res) <- c(self$symbol, paste('___', self$currency, sep='.'))
            return(res)
        },
        
        value = function(price, fxrate)
        {
            return(as.numeric(price) * as.numeric(fxrate) * self$amount)
        }
            
    )
)
