# show --------------------------------------------------------------------


setMethod('show', signature(object = 'rc-cash'),
    function(object) {
        callNextMethod()
        cat(paste('\nAmount      ', amount(object)))
        cat(paste('\nValue       ', value(object)))
    }
)



# cash --------------------------------------------------------------------


setMethod('cash', 
        signature(amount = 'numeric', currency = 'character'),
        function(amount, currency) {
            object <- new('rc-cash')
            amount(object) <- amount
            currency(object) <- currency
            return(object)
        }
)



# type --------------------------------------------------------------------


setMethod('type', 
          signature(object = 'rc-cash'),
          function(object) return('Cash')
)

# amount ------------------------------------------------------------------


setMethod('amount', 
         signature(object = 'rc-cash'),
         function(object) return(object@amount)
)

setMethod('amount<-', 
          signature(object = 'rc-cash', value = 'numeric'),
          function(object, value) {
              object@amount <- value
              return(object)
          }
)

setMethod('amount<-',
          signature(object = 'rc-cash', value = 'NULL'),
          function(object, value)
              return(object))


# as.data.frame -----------------------------------------------------------


setMethod('as.data.frame',
          signature(x = 'rc-cash'),
          function(x) {
              data.frame(amount = x@amount, currency = x@currency)
          }
)


# value -------------------------------------------------------------------


setMethod('value', 
          signature(object = 'rc-cash'),
          function(object) {
              fxrate <- price(object, paste('CURRENCY', currency(object), sep='/'))
              max(-Inf, round(amount(object) * fxrate, 2))
          })


# risk.weigths ------------------------------------------------------------


setMethod('risk.weigths', signature(object = 'rc-cash', item = 'missing'),
          function(object, item) {
              x <- list(value(object))
              names(x) <- paste0('CURRENCY/', currency(object))
              return(x)
          }
)



# Op '==' -----------------------------------------------------------------


setMethod('==', 
          signature(e1 = 'rc-cash', e2 = 'rc-cash'),
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
