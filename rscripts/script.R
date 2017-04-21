library(jsonlite)

symbolFromFilename <- function(filename) {
    unlist(strsplit(filename, "_"))[1]
}


args <- unlist(strsplit(commandArgs(TRUE), " "))
symbols <- sapply(args, symbolFromFilename)


getData <- function(filename) {
    
    stopifnot(exists(filename)) 
    dat <- fromJSON(filename)$query$results$quote
    res <- xts(as.matrix(as.numeric(dat$Close)), as.Date(dat$Date), src = "ALV.DE_20.json", updated = Sys.time())
    colnames(res) <- symbol
    return(res)
}


getReturns <- function(filenames, ...) {
    rfs <- risk.factors((object))
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
                  portfolio_method = "component", 
                  weights = risk.weigths(object))
              
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
              return(nm)
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
              
              if (showProgress(object)) {
                  progress <- shiny::Progress$new()
                  on.exit(progress$close())
                  progress$set(message = "loading ...", value = 0)
              }
              
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
                  if (showProgress(object))
                      progress$inc(1 / length(rfs), detail = rf)
              }
              object <- pushPrices(object)
              return(object)
          }
)