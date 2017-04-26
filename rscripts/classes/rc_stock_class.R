# show --------------------------------------------------------------------


setMethod('show', signature(object = 'rc-stock'),
    function(object) {
        callNextMethod()
        cat(paste('\nSymbol      ', symbol(object)))
        cat(paste('\nShares      ', shares(object)))
        cat(paste('\nValue       ', value(object)))
    }
)



# stock -------------------------------------------------------------------


setMethod('stock', 
        signature(shares = 'numeric', symbol = 'character', currency = 'character'),
        function(shares, symbol, currency) {
            object <- new('rc-stock')
            shares(object) <- shares
            symbol(object) <- symbol
            currency(object) <- currency
            return(object)
        }
)

setMethod('stock', 
          signature(shares = 'numeric', symbol = 'character', currency = 'character'),
          function(shares, symbol, currency) {
              object <- new('rc-stock')
              shares(object) <- shares
              symbol(object) <- symbol
              currency(object) <- currency
              return(object)
          }
)



# shares ------------------------------------------------------------------


setMethod('shares', 
         signature(object = 'rc-stock'),
         function(object) return(object@shares)
)

setMethod('shares<-', 
          signature(object = 'rc-stock', value = 'numeric'),
          function(object, value) {
              object@shares <- value
              return(object)
          }
)

setMethod('shares<-',
          signature(object = 'rc-stock', value = 'NULL'),
          function(object, value)
              return(object))



# symbol ------------------------------------------------------------------


setMethod('symbol', 
          signature(object = 'rc-stock'),
          function(object) return(object@symbol)
)

setMethod('symbol<-', 
          signature(object = 'rc-stock', value = 'character'),
          function(object, value) {
              object@symbol <- value
              return(object)
          }
)





# type --------------------------------------------------------------------


setMethod('type', 
          signature(object = 'rc-stock'),
          function(object) return('Stock')
)


# value -------------------------------------------------------------------


setMethod('value', 
          signature(object = 'rc-stock'),
          function(object) {
              fxrate <- price(object, paste('CURRENCY', currency(object), sep=''))
              quote <- price(object, symbol(object)) 
              max(-Inf, round(shares(object) * quote * fxrate, 2))
          }
)


# risk.weigth -------------------------------------------------------------


setMethod('risk.weigths', signature(object = 'rc-stock', item = 'missing'),
          function(object, item) {
              x <- list(value(object), value(object))
              names(x) <- c(paste0('CURRENCY', currency(object)), symbol(object))
              return(x)
          }
)



# Op '==' -----------------------------------------------------------------


setMethod('==', 
          signature(e1 = 'rc-stock', e2 = 'rc-stock'),
          function(e1, e2) {
              all(
                  callNextMethod(),
                  e1@shares == e2@shares,
                  length(e1@shares) == length(e2@shares),
                  e1@symbol == e2@symbol,
                  length(e1@symbol) == length(e2@symbol)
              )
          }
)
