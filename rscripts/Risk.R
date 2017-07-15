library(R6)
library(httr)

parameter <- function(id, args) {
    prefix <- paste0('--', id, '=')
    return(sub(prefix, "", args[grep(prefix, args)]))
}

args <- commandArgs()
base <- dirname(parameter('file', args))

conf <- as.numeric(parameter('conf', args))


source(paste(base, 'Class/Instrument.R', sep='/'))
source(paste(base, 'Class/Stock.R', sep='/'))
source(paste(base, 'Class/Portfolio.R', sep='/'))


url.hist <- 'http://ctrade.dev/api/histories?id=1&from=2017-06-30&to=2017-07-10'
url.pf <- 'http://ctrade.dev/api/portfolio?id=1'

fetchHistories <- function(url) {
    dat <- content(GET(url))
    len <- length(dat)
    dimnames = list(names(dat[[1]]), names(dat))
    m <- matrix(unlist(dat), ncol=len, dimnames=dimnames)
    
    m <- cbind(m, rep(1, len))
    colnames(m)[len+1] <- 'Unity'
    
    hist = c()
    for (i in 1:(len+1)) {
        
        dat <- xts::xts(m[,i], do.call("as.Date", list(x = rownames(m))))
        names(dat)<-colnames(m)[i]
        hist <- c(hist, list(dat))
    }
    names(hist)<-colnames(m)
    return(hist)
}

fetchPortfolio <- function(url) {
    data <- content(GET(url))
    
    items <- as.data.frame(t(matrix(unlist(data$items), ncol=length(data$items))), stringsAsFactors = FALSE)
    names(items) <- names(data$items[[1]])
    
    return(list(meta = data$meta, items = items))
}


pfdata <- fetchPortfolio(url.pf)
histories <- fetchHistories(url.hist)

pf <- Portfolio$new(pfdata, histories)


require(methods) #for PerformanceAnalytics
output <- PerformanceAnalytics::VaR(
    R = pf$returns(),
    p = conf,
    weights = pf$delta(),
    portfolio_method = 'component'
)


result <- c(as.list(output$contribution), total = as.numeric(output$MVaR))

jsonlite::toJSON(result)