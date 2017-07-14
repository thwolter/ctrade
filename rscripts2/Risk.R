#setwd('/Code/ctrade/rscripts2')

library(R6)
library(httr)

source('Class/Instrument.R')
source('Class/Stock.R')
source('Class/Portfolio.R')

url <- 'http://ctrade.dev/api/histories?id=1&from=2017-06-30&to=2017-07-10'

loadHistories = function(url)
{
    dat <- content(GET(url))
    len <- length(dat)
    dimnames = list(names(dat[[1]]), names(dat))
    m <- matrix(unlist(dat), ncol=len, dimnames=dimnames)
    
    m <- cbind(m, rep(1, len))
    colnames(m)[len+1] <- 'Fake'
    
    hist = c()
    for (i in 1:(len+1)) {
        
        dat <- xts::xts(m[,i], do.call("as.Date", list(x = rownames(m))))
        hist <- c(hist, list(dat))
    }
    
    names(hist)<-colnames(m)
    
    return(hist)
}

# load portfolio
dat <- content(GET('http://ctrade.dev/api/portfolio?id=1'))
dat.pf <- as.data.frame(matrix(unlist(dat['item']), ncol=5))

# load histories
hist <- loadHistories(url)


#pf <- Portfolio$new(private$entity, private$directory)

# 
# require(methods) #for PerformanceAnalytics
# output <- PerformanceAnalytics::VaR(
#     R = pf$returns(),
#     p = opt$conf,
#     weights = pf$delta(),
#     portfolio_method = 'component'
# )
# 
# result = list(
#     Risks = self$df(output$contribution), 
#     Total = self$df(output$MVaR)
# )