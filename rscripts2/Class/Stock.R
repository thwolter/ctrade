library(R6)


Stock <- R6Class('Stock',

    inherit = Instrument,
                 
    public = list(
        
        delta = function(price, fxrate, amount)
        {
            res <- list(price * amount, fxrate * price * amount)
            names(res) <- c(self$symbol, paste0('___',self$currency))
            return(res)
        },
        
        value = function(price, fxrate, amount = NULL)
        {
            if (is.null(amount)) amount <- self$amount
            return(price * fxrate * amount)
        }
            
    )
)
