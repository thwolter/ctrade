library(R6)

parameter <- function(id, args) {
    prefix <- paste0('--', id, '=')
    return(sub(prefix, "", args[grep(prefix, args)]))
}

args <- commandArgs()
base <- dirname(parameter('file', args))

history <- jsonlite::fromJSON(parameter('history', args))
conf <- parameter('conf', args)

require(methods) #for PerformanceAnalytics

jsonlite::toJSON(result)

output950 <- PerformanceAnalytics::VaR(
    R = quantmod::dailyReturn(history), p = conf, weights = pf$delta(), portfolio_method = 'component')