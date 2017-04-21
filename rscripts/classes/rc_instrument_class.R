# show --------------------------------------------------------------------


setMethod('show', signature(object = 'rc-instrument'),
    function(object) {
        cat(paste0("\nObject of class '", class(object), "'"))
        cat(paste('\nId          ', id(object)))
        cat(paste('\nName        ', name(object)))
        cat(paste('\nCurrency    ', currency(object)))
        cat(paste('\nSides       ', sides(object)))
    }
)



# id ----------------------------------------------------------------------


setMethod('id', 
          signature(object = 'rc-instrument'),
          function(object) return(object@id)
)

setMethod('id<-', 
          signature(object = 'rc-instrument', value = 'numeric'),
          function(object, value) {
              object@id <- value
              return(object)
          }
)



# name --------------------------------------------------------------------


setMethod('name', 
          signature(object = 'rc-instrument'),
          function(object) return(object@name)
)

setMethod('name<-', 
          signature(object = 'rc-instrument', value = 'character'),
          function(object, value) {
              object@name <- value
              return(object)
          }
)

setMethod('name<-',
          signature(object = 'rc-instrument', value = 'NULL'),
          function(object, value)
              return(object))



# currency ----------------------------------------------------------------


setMethod('currency', 
          signature(object = 'rc-instrument'),
          function(object) return(object@currency)
)

setMethod('currency<-', 
          signature(object = 'rc-instrument', value = 'character'),
          function(object, value) {
              object@currency <- value
              return(object)
          }
)

setMethod('currency<-',
          signature(object = 'rc-instrument', value = 'NULL'),
          function(object, value) return(object))



# sides -------------------------------------------------------------------


setMethod('sides', 
          signature(object = 'rc-instrument'),
          function(object) return(object@sides)
)

setMethod('sides<-', 
          signature(object = 'rc-instrument', value = 'character'),
          function(object, value) {
              object@sides <- value
              return(object)
          }
)

setMethod('sides<-',
          signature(object = 'rc-instrument', value = 'NULL'),
          function(object, value) return(object))



# price ------------------------------------------------------------------


setMethod('price', 
          signature(object = 'rc-instrument', symbol = 'character'),
          function(object, symbol) return(object@price[[symbol]])
)

setMethod('price<-', 
          signature(object = 'rc-instrument', symbol = 'character', value = 'numeric'),
          function(object, symbol, value) {
              object@price[[symbol]] <- value
              return(object)
          }
)



# Op '==' -----------------------------------------------------------------


setMethod('==', 
          signature(e1 = 'rc-instrument', e2 = 'rc-instrument'),
          function(e1, e2) {
            all(
                e1@id == e2@id,
                length(e1@id) == length(e2@id),
                e1@name == e2@name,
                length(e1@name) == length(e2@name),
                e1@currency == e2@currency,
                length(e1@currency) == length(e2@currency),
                e1@sides == e2@sides,
                length(e1@sides) == length(e2@sides)
            )
          }
)
