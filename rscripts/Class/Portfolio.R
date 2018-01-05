library(R6)
library(xts)


Portfolio <- R6Class('Portfolio',
    
    public = list(
        items = NULL,
        currency = NULL,
        cash = NULL,
        hist = NULL,
        
        
        initialize = function(portfolio, histories)
        {
           self$currency <- portfolio$meta$currency
           self$cash <- portfolio$meta$cash
           self$items <- portfolio$items
           
           self$hist <- histories
        },
        
        
        ##
        # Returns the absolute deltas of the portfolio positions
        # 
        # @return vector
        ##
        delta = function()
        {
            delta = c()
            for (i in 1:dim(self$items)[1])
            {
                item <- self$items[i,]
                position <- Stock$new(item$symbol, item$amount, item$currency)
                
                quote <- private$quote(item$symbol)
                fxrate <- private$fxrate(item$currency)

                delta <- c(delta, position$delta(quote, fxrate))
            }
            
            names(delta) <- gsub('___', self$currency, names(delta))
                               
            nm <- unique(names(delta))
            nm <- nm[nm != private$domestic()]
            
            nms <- names(sapply(nm, function(x) which(names(delta) == x)))
            
            total <- function(nm)
            {
                return(sum(unlist(delta[names(delta) == nm])))
            }
            
            res <- unlist(lapply(nms, total))
            names(res) <- nms
            
            return(res)
        },
        
        ##
        # Returns the positions weights as a percentage to total delta.
        #
        # @return vector
        ##
        weights = function()
        {
            delta = self$delta()
            return(delta/sum(delta))
        },
        
        
        risk.factors = function()
        {
            rfs = c()
            for (i in 1:dim(self$items)[1])
            {
                item = self$items[i,]
                
                symbol <- item$symbol
                if (! symbol %in% rfs) rfs <- c(rfs, item$symbol)
                
                currency <- paste0(self$currency, item$currency)
                pfpair <- paste0(self$currency, self$currency)
                
                if (! currency %in% rfs && currency != pfpair) rfs = c(rfs, currency)
            }
            return(rfs)
        },
        
        
        ##
        # Returns the daily returns of the historicy values based on model implemented
        # in package 'quantmode'.
        #
        # @return xts
        ##
        returns = function()
        {
            nms <- names(self$delta())
               
            args <- lapply(nms, 
                function(nm) {
                    x <- quantmod::dailyReturn(self$hist[[nm]], type='log')
                    x[is.infinite(x)] <- 0
                    x[is.nan(x)] <- 0
                    x
                    })
            
            returns <- do.call("merge.xts", c(args, fill = 0))
            colnames(returns) <- nms
                
            return(returns)
        },
        
        
        
        value = function(n = 1)
        {
            val <- 0
            for (i in 1:dim(self$items)[1])
            {
                item <- self$items[i,]
                position <- Stock$new(item$symbol, item$amount, item$currency)
                
                quote <- private$quote(item$symbol)
                fxrate <- private$fxrate(item$currency)
             
                val <- val + position$value(quote, fxrate)
            }

            val <- val + self$cash
            
            names(val) <- "Value"
            
            return(val)
        }
        
        
    ),
    
    
    private = list(
        
        ##
        # Return the fxrate for a given currency in relation to portfolio currency.
        # 
        # @param string currency
        # @return int   
        ##
        fxrate = function(currency)
        {
            fxrate <- 1
            
            if (self$currency != currency)
            {
                ccy <- paste0(self$currency, currency)
                fxrate <- self$hist[[ccy]]
            } 
            return (fxrate)
        },
        
        
        quote = function(symbol)
        {
            return(as.numeric(tail(self$hist[[symbol]], 1)))
        },
        
        
        ##
        # Returns a currency symbol with portfolio currency only.
        ##
        domestic = function()
        {
            return(paste(self$currency, self$currency, sep='.'))
        }
        
    )
)
