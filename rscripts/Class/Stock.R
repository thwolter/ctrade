library(R6)


Stock <- R6Class('Stock',

    inherit = Instrument,
                 
    public = list(
        
        delta = function(price, fxrate)
        {
            res <- list(price * self$amount, fxrate * price * self$amount)
            names(res) <- c(self$symbol, paste0('___',self$currency))
            return(res)
        }
        
      
            
    )
)
