# show --------------------------------------------------------------------


setMethod('show', signature(object = 'rc-portfolio'),
          function(object) {
              
              foo <- function(nm) {
                  x <- tsdata(object, nm)
                  ifelse(is(x, 'xts'), as.character(index(last(x))), '')
              }

              callNextMethod()
              cat('\n\nItems\n')
              show(as.data.frame(object))
              
          }
)


# portfolio ---------------------------------------------------------------


setMethod('rcportfolio', 
          signature(name = 'character', currency = 'character'),
          function(name, currency) {
              object <- new('rc-portfolio')
              name(object) <- name
              currency(object) <- currency
              return(object)
          }
)


# addItem ---------------------------------------------------------------------


setMethod('addItem', 
          signature(object = 'rc-portfolio', item = "rc-stock"),
          function(object, item) { 
              id <- 1 + length(object)
              id(item) <- id              
              object@instruments <- c(object@instruments, list(item))
              return(object)
          }
)

setMethod('addItem', 
          signature(object = 'rc-portfolio', item = "rc-cash"),
          function(object, item) { 
              id <- 1 + length(object)
              id(item) <- id              
              object@instruments <- c(object@instruments, list(item))
              return(object)
          }
)


setMethod('addItem<-', 
          signature(object = 'rc-portfolio', value = "rc-cash"),
          function(object, value) return(addItem(object, value))
)

setMethod('addItem<-', 
          signature(object = 'rc-portfolio', value = "rc-stock"),
          function(object, value) return(addItem(object, value))
)


# length ------------------------------------------------------------------

setMethod('length',
          signature(x = 'rc-portfolio'),
          function(x) length(x@instruments))






# tsdata ------------------------------------------------------------------

setMethod('tsdata', 
          signature(object = 'rc-portfolio', symbol = 'character'),
          function(object, symbol) return(object@tsdata[[symbol]])
)

setMethod('tsdata<-', 
          signature(object = 'rc-portfolio', symbol = 'character', value = 'xts'),
          function(object, symbol, value) {
              object@tsdata[[symbol]] <- value
              return(object)
          }
)

# update ------------------------------------------------------------------


setMethod('update', 
          signature(object = 'rc-portfolio', item = 'ANY'),
          function(object, item) {
              
              if (!is(item, 'rc-cash') & !is(item, 'rc-stock'))
                  stop("'item' must be an 'rc-cash' or 'rc-stock' object")
              
              if (id(item) == 0)
                  stop("cannot replace item with id=0")
              
              ids <- sapply(1:length(object), function(i) id(item(object, i)))
              pos <- which(ids == id(item))
              
              if (length(pos))
                  object@instruments[[pos]] <- item
              else
                  stop(paste("item with id =", id, "doesn't exist"))
              
              return(object)
          }
)


setMethod('update<-', 
          signature(object = 'rc-portfolio', value = 'ANY'),
          function(object, value) update(object, value)
)



# removeItem --------------------------------------------------------------


setMethod('removeItem', 
          signature(object = 'rc-portfolio', pos = 'numeric'),
          function(object, pos) {
              
              if (pos < 1 | pos > length(object))
                  stop(paste("pos =", pos, "out of range"))
           
              object@instruments[[pos]] <- NULL
              return(object)
          }
)



# removeItemWithId --------------------------------------------------------


setMethod('removeItemWithId', 
          signature(object = 'rc-portfolio', id = 'numeric'),
          function(object, id) {
              
              i <- sapply(1:length(object), function(i) id(item(object, i)) == id)
              return(removeItem(object, which(i)))
          }
)



# item --------------------------------------------------------------------


setMethod('item', 
          signature(object = 'rc-portfolio', i = 'numeric'),
          function(object, i) object@instruments[[i]]
)


# itemById ----------------------------------------------------------------


setMethod('itemById',
          signature(object = 'rc-portfolio', id = 'character'),
          function(object, id) {
              for (i in 1:length(object)) {
                  item <- item(object, i)
                  if (id(item) == id)
                      return(item)
              }
              
              stop(paste0("item with id=", id, " doesn't exist"))
          })


setMethod('itemById',
          signature(object = 'rc-portfolio', id = 'numeric'),
          function(object, id) {
              itemById(object, as.character(id))
          })

# itemBySymbol ------------------------------------------------------------

setMethod('itemBySymbol',
          signature(object = 'rc-portfolio', symbol = 'character'),
          function(object, symbol) {
              for (i in 1:length(object)) {
                  item <- item(object, i)
                  if (is(item, 'rc-stock'))
                      if (symbol(item) == symbol)
                          return(item)
              }
          })




# as.data.frame -----------------------------------------------------------


setMethod('as.data.frame',
          signature(x = 'rc-portfolio'),
          function(x) {
              if (!length(x)) return(NULL)
              df <- NULL
              for (i in 1:length(x)) {
                  d <- list()
                  item <- x@instruments[[i]]
                  d['id'] <- id(item)
                  d['name'] <- name(item)
                  d['currency'] <- currency(item)
                  d['value'] <- value(item)
                  
                  if (is(item, "rc-stock")) {
                      d['type'] <- 'Stock'
                      d['symbol'] <- symbol(item)
                      d['shares'] <- shares(item)
                  }
                  
                  if (is(item, "rc-cash")) {
                      d['type'] <- 'Cash Account'
                      d['amount'] <- amount(item)
                  }

                  df <- rbind(
                      df,
                      data.frame(
                          stringsAsFactors = FALSE,
                          id = d$id,
                          type = d$type,
                          name = d$name,
                          symbol = ifelse(is.null(d$symbol), "", d$symbol),
                          shares = ifelse(is.null(d$shares), "", d$shares),
                          amount = ifelse(is.null(d$amount), "", d$amount),
                          value = ifelse(is.null(d$value), "", d$value),
                          currency = ifelse(is.null(d$currency), "", d$currency)
                      )
                  )

              }
              return(df)
          }
)



# format.df ---------------------------------------------------------------

setMethod('format.df',
          signature(object = 'rc-portfolio', fvalue = 'missing', fperc = 'missing'),
          function(object, fvalue, fperc) {
              if (!length(object)) return(NULL)
              df <- NULL
              
              for (i in 1:length(object)) {
                  item <- object@instruments[[i]]
                  df <- rbind(df,
                      data.frame(
                          stringsAsFactors = FALSE,
                          Instrument = type(item),
                          Symbol = ifelse(is(item, 'rc-cash'), "", symbol(item)),
                          Name = name(item),
                          Amount = ifelse(is(item, 'rc-stock'), paste(shares(item), 'shares'),
                                          paste(sprintf(fvalue, amount(item)), currency(item))),
                          #Value = sprintf(fvalue, value(item))
                          Value = value(item)
                      )
                  )
              }
              colnames(df) <- gsub('Value', sprintf('Value (%s)', currency(object)), colnames(df))
              return(df)
          })



# is.complete -------------------------------------------------------------


setMethod('is.complete', 
          signature(object = 'rc-portfolio'),
          function(object) {
              if (!lengthStocks(object)) return(FALSE)
              all(sapply(1:lengthStocks(object), function(i) !is.null(tsdata(stockItem(object, i)))))
          }
)

# lastDate ----------------------------------------------------------------


setMethod('lastDate', 
          signature(object = 'rc-portfolio'),
          function(object) {
              rfs <- risk.factors(object)
              as.Date(max(sapply(rfs, function(rf) index(last(tsdata(object, rf))))))
          }
)



# historyLength -----------------------------------------------------------


setMethod('historyLength', 
          signature(object = 'rc-portfolio'),
          function(object) {
              max(sapply(1:lengthStocks(object), function(i) historyLength(stockItem(object, i))))
          }
)


# returns -----------------------------------------------------------------


setMethod('returns',
          signature(object = 'rc-portfolio'),
          function(object, period, ...) {
              rfs <- risk.factors((object))
            
              el <- paste(currency(object), currency(object), sep='/')
              rfs <- rfs[rfs != el]
              
              args <- lapply(rfs, 
                    function(rf) periodReturn(tsdata(object, rf), period = period, ...))
              returns <- do.call("merge", c(args, fill = 0))
              colnames(returns) <- rfs
              
              return(returns)
          })



# risk --------------------------------------------------------------------

setMethod('risk', 
          signature(object = 'rc-portfolio'),
          function(object, period, p, t, ...) {
              
              res <- PerformanceAnalytics::VaR(
                  R = returns(object, period, ...),
                  weights = risk.weigths(object), ...)
              
              list(
                  MVaR = res$MVaR * sqrt(t),
                  contribution = res$contribution * sqrt(t)
              )
          }
)



# risk.factors ------------------------------------------------------------


setMethod('risk.factors', signature(object = 'rc-portfolio'),
          function(object) {
              w <- list()
              for (i in 1:length(object)) {
                  w <- c(w, names(risk.weigths(item(object, i))))
              }
            
              nm <- unique(w)
              nm <- gsub('CURRENCY', currency(object), nm)
              
              el <- paste(currency(object), currency(object), sep="/")
              
              return(nm[nm != el])
          }
)



# risk.weigths ------------------------------------------------------------

setMethod('risk.weigths', signature(object = 'rc-portfolio', item = 'missing'),
          function(object, item) {
              w <- list()
              for (i in 1:length(object)) {
                  itm <- item(object, i)
                  
                  w <- c(w, risk.weigths(itm))
              }
             
              nm <- unique(names(w))
              weights <- NULL
              for (i in 1:length(nm)) {
                    weights <- c(weights, sum(unlist(w[names(w) == nm[i]])))
              }
              nm <- gsub('CURRENCY', currency(object), nm)
              names(weights) <- nm
              return(weights[names(weights) != paste(currency(object), currency(object), sep='/')])
        }
)


setMethod('risk.weigths', signature(object = 'rc-portfolio', item = 'ANY'),
          function(object, item) {
              rfs <- risk.factors(object)
              w <- risk.weigths(item)
              names(w) <- gsub('CURRENCY', currency(object), names(w))
              res <- sapply(rfs, function(rf) ifelse(rf %in% names(w), w[rf], 0))
              unlist(res)
          })


# loadData ----------------------------------------------------------------


setMethod('loadData', signature(object = 'rc-portfolio', force = 'logical'),
          function(object, force) {
             
              rfs <- risk.factors(object)
              for (rf in rfs) {
              
                  if (force | is.null(tsdata(object, rf))) {
                      src <- if (length(grep('/', rf))) "oanda" else "yahoo"
                      symbol <- try(getSymbols(rf, env = NULL, src = src))
                      
                      if (is(symbol, 'try-error'))
                          stop(paste0("Symbol '", symbol, "' not loaded"))
                      else
                          tsdata(object, rf) <- symbol
                  }
            
              }
              object <- pushPrices(object)
              return(object)
          }
)


setMethod('loadData', signature(object = 'rc-portfolio', force = 'missing'),
          function(object, force) loadData(object, FALSE))
              


# readData ----------------------------------------------------------------


setMethod('readData', signature(object = 'rc-portfolio'),
    function(object) {
              
        col.names = c("Open", "High", "Low", "Close", "Volume", "Adjusted")
        
        rfs <- risk.factors(object)
        for (rf in rfs) {
            
            jsonfile = paste0(rf, ".json")
            
            if (!file.exists(jsonfile))
                stop(paste0("Missing JSON file for symbol '", rf, "'."))
                  
            dat <- try(fromJSON(jsonfile)[,-1], silent = TRUE)
            
            if (is(dat, 'try-error'))
                stop(paste0("JSON file for symbol '", rf, "' with inappropriate format."))
            
            asDateArgs <- list(x = as.character(dat[, 1]))
            
            dat <- xts(dat[, -1], do.call("as.Date", asDateArgs), src = "json", 
                      updated = Sys.time())
            
            colnames(dat) <- paste(toupper(rf), col.names, sep = ".")
            
            tsdata(object, rf) <- dat
        }
                  
        object <- pushPrices(object)
        return(object)
        
    }
)

# pushPrices --------------------------------------------------------------


setMethod('pushPrices', signature(object = 'rc-portfolio'),
          function(object) {
            
              for (i in 1:length(object)) {
                  itm <- item(object, i)
                  rfs <- names(risk.weigths(itm))
                  for (rf in rfs) {
                      nm <- gsub('CURRENCY', currency(object), rf)
                      if (length(grep("CURRENCY", rf)))
                          x <- last(tsdata(object, nm))
                      else
                          x <- Cl(last(tsdata(object, nm)))
                      
                      if (is.null(x)) x <- 1
                      
                      price(itm, rf) <- as.numeric(x)
                      update(object) <- itm
                  }
              }
              
              return(object)
          })


# value -------------------------------------------------------------------


setMethod('value', 
          signature(object = 'rc-portfolio', cls = 'missing'),
          function(object) {
              sum(sapply(1:length(object), function(i) value(item(object, i))))
          })


setMethod('value', 
          signature(object = 'rc-portfolio', cls = 'character'),
          function(object, cls) {
              cls <- match.arg(cls, c('rc-cash', 'rc-stock'))
              sum(sapply(1:length(object), function(i) {
                  itm <- item(object, i)
                  ifelse(is(itm, cls), value(itm), 0)
              }))
          })



# readJSON ----------------------------------------------------------------


setMethod('readJSON', 
          signature(filename = 'character'),
          function(filename) {
            
            json <- jsonlite::fromJSON(filename)
            
            object = new('rc-portfolio')
            name(object) <- json$meta$name
            currency(object) <- json$meta$currency
            
            addItem(object) <- cash(json$cash$amount, json$cash$currency)
            
            items <- as.data.frame(json$item)
            for (i in 1:dim(items)[1]) {
              
              item <- items[i,]
              
              switch(item$type,
                "Stock" = addItem(object) <- stock(item$amount, item$symbol, item$currency),
                "Index" = stop("Index not yet implemented")
              )
            }
            
            return(object)
          })



# cachetime ---------------------------------------------------------------


setMethod('cachetime', 
          signature(object = 'rc-portfolio'),
          function(object) {
              return(object@cachetime)
          })

setMethod('cachetime<-', 
          signature(object = 'rc-portfolio', value = "numeric"),
          function(object, value) {
              object@cachetime <- value
          })



# cachedir ----------------------------------------------------------------


setMethod('cachedir', 
          signature(object = 'rc-portfolio'),
          function(object) {
              return(object@cachedir)
          })

setMethod('cachedir<-', 
          signature(object = 'rc-portfolio', value = "character"),
          function(object, value) {
              object@cachedir <- value
          })      
