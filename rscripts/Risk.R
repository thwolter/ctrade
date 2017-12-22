library(R6)

parameter <- function(id, args) {
    prefix <- paste0('--', id, '=')
    return(sub(prefix, "", args[grep(prefix, args)]))
}

args <- commandArgs()
base <- dirname(parameter('file', args))

url <- parameter('url', args)
id <- parameter('id', args)
conf <- as.numeric(parameter('conf', args))
date <- parameter('date', args)
count <- parameter('count', args)


source(paste(base, 'Class/Instrument.R', sep='/'))
source(paste(base, 'Class/Stock.R', sep='/'))
source(paste(base, 'Class/Portfolio.R', sep='/'))
source(paste(base, 'Helper/fetchData.R', sep='/'))


url.hist <- sprintf(paste(url, 'api/histories?id=%s&date=%s&count=%s', sep='/'), id, date, count)
url.pf <- sprintf(paste(url, 'api/portfolio?id=%s&date=%s', sep='/'), id, date)

# Get the token from server
source(paste(base, '.env.R', sep='/'))
token <- fetchAccessToken(uri_token, client_id, client_secret)

# fetch portfolio data an history from server
pfdata <- fetchPortfolio(url.pf, token)
histories <- fetchHistories(url.hist, token)

pf <- Portfolio$new(pfdata, histories)


if (length(pfdata$items) && sum(as.numeric(pfdata$items$amount))) {

    require(methods) #for PerformanceAnalytics
    output950 <- PerformanceAnalytics::VaR(
        R = pf$returns(), p = 0.95, weights = pf$delta(), portfolio_method = 'component')

    output975 <- PerformanceAnalytics::VaR(
        R = pf$returns(), p = 0.975, weights = pf$delta(), portfolio_method = 'component')
    
    output990 <- PerformanceAnalytics::VaR(
        R = pf$returns(), p = 0.99, weights = pf$delta(), portfolio_method = 'component')


    result <- list(
        data = list(
            contribution.95 = as.list(output950$contribution),
            contribution.975 = as.list(output975$contribution),
            contribution.99 = as.list(output990$contribution),
            risk.95 = as.numeric(output950$MVaR),
            risk.975 = as.numeric(output975$MVaR),
            risk.99 = as.numeric(output990$MVaR)
        ),
        meta = list(
            date = toString(index(tail(histories[[1]],1)))
        )
    )
    
} else {
    result <- list(
        data = list(
            contribution.95 = 0,
            contribution.975 = 0,
            contribution.99 = 0,
            risk.95 = 0,
            risk.975 = 0,
            risk.99 = 0
        ),
        meta = list(
            date = toString(index(tail(histories[[1]],1)))
        )
    )
}

jsonlite::toJSON(result)