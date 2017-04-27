returns <- pf$returns()
deltas <- pf$delta(FALSE)

nr <- dim(returns)[1]

backtest = function(i)
{
    date <- zoo::index(returns)[nr-i]
    
    j <- tail(which(zoo::index(deltas) <= date), 1)
  
    risk <- PerformanceAnalytics::VaR(
        R = head(returns, nr-i), 
        p = 0.95, 
        weights = deltas[j,], 
        portfolio_method = 'component'
    )
    
    return (as.numeric(risk$MVaR))
}


start <- dim(returns)[1]-100
end <- 0

risk <- sapply(start:end, backtest)

# risk one day before
risk <- xts::as.xts(risk, zoo::index(returns)[(nr-start-1):(nr-end-1)])

ts <- xts::merge.xts(pf$value(FALSE), -res, join="inner")
sums <- xts::as.xts(rowSums(ts), zoo::index(ts))

final <- xts::merge.xts(pf$value(FALSE), sums)


