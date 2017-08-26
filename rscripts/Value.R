library(R6)
library(httr)

parameter <- function(id, args) {
    prefix <- paste0('--', id, '=')
    return(sub(prefix, "", args[grep(prefix, args)]))
}

args <- commandArgs()
base <- dirname(parameter('file', args))

url <- parameter('url', args)
id <- parameter('id', args)
date <- parameter('date', args)

source(paste(base, 'Class/Instrument.R', sep='/'))
source(paste(base, 'Class/Stock.R', sep='/'))
source(paste(base, 'Class/Portfolio.R', sep='/'))
source(paste(base, 'Helper/fetchData.R', sep='/'))


url.hist <- sprintf(paste(url, 'api/histories?id=%s&date=%s&count=%s', sep='/'), id, date, 1)
url.pf <- sprintf(paste(url, 'api/portfolio?id=%s&date=%s', sep='/'), id, date)


pfdata <- fetchPortfolio(url.pf)
histories <- fetchHistories(url.hist)

pf <- Portfolio$new(pfdata, histories)

result <- list(
    value = ifelse(length(pfdata$items), pf$value(), pf$cash),
    date = toString(index(tail(histories[[1]],1)))
)

jsonlite::toJSON(result)