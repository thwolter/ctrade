library(R6)
library(httr)

parameter <- function(id, args) {
    prefix <- paste0('--', id, '=')
    return(sub(prefix, "", args[grep(prefix, args)]))
}

args <- commandArgs()
base <- dirname(parameter('file', args))

id <- parameter('id', args)
conf <- as.numeric(parameter('conf', args))
date <- parameter('date', args)
count <- parameter('count', args)


source(paste(base, 'Class/Instrument.R', sep='/'))
source(paste(base, 'Class/Stock.R', sep='/'))
source(paste(base, 'Class/Portfolio.R', sep='/'))


url.hist <- sprintf('http://ctrade.dev/api/histories?id=%s&date=%s&count=%s', id, date, count)
url.pf <- sprintf('http://ctrade.dev/api/portfolio?id=%s', id)

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
output950 <- PerformanceAnalytics::VaR(
    R = pf$returns(), p = 0.95, weights = pf$delta(), portfolio_method = 'component')

output975 <- PerformanceAnalytics::VaR(
    R = pf$returns(), p = 0.975, weights = pf$delta(), portfolio_method = 'component')

output990 <- PerformanceAnalytics::VaR(
    R = pf$returns(), p = 0.99, weights = pf$delta(), portfolio_method = 'component')


result <- list(
    contrib95 = as.list(output950$contribution),
    contrib97 = as.list(output975$contribution),
    contrib99 = as.list(output990$contribution),
    total95 = as.numeric(output950$MVaR),
    total97 = as.numeric(output975$MVaR),
    total99 = as.numeric(output990$MVaR),
    date = toString(index(tail(histories[[1]],1)))
)

jsonlite::toJSON(result)