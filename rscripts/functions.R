
# Define an example portfolio ---------------------------------------------

examplePortfolio <- function() {
    pfolio <- rcportfolio('Example Portfolio', 'USD')
    addItem(pfolio) <- cash(1000, 'EUR')
    addItem(pfolio) <- stock(shares = 10, symbol = 'ALV.DE', 'EUR')
    addItem(pfolio) <- stock(shares = 20, symbol = 'BAS.DE', 'EUR')                 
    addItem(pfolio) <- stock(shares = 30, symbol = 'DAI.DE', 'EUR')
    return(pfolio)
}



# Calculate key figures ---------------------------------------------------


keyFigures <- function(portfolio) {
    
    n <- lengthStocks(portfolio)
    amounts <- sapply(1:n, function(i) amount(stockItem(portfolio,i)))
    risk.sa <- sapply(1:n, function(i) risk(stockItem(portfolio,i), t=1))
    
    dayPerYear <- getParameter(setting, 'daysPerYear')
    daysShort <- getParameter(setting, 'periodShort')
    daysLong <- getParameter(setting, 'periodLong')
    
    scalFactorShort <- sqrt(daysShort/dayPerYear)
    scalFactorLong <- sqrt(daysLong/dayPerYear)
    
    VaR <- VaR(returns) * position
    ePL <- mean(returns) * position
    PfVaR <- VaR
    
    if (sum(position) & n > 1) {
        weights <- position/sum(position)
        PfVaR <- VaR(returns, 
                     p = getParameter(setting, 'confLevel'), 
                     portfolio_method = getParameter(setting, 'portfolioMethod'), 
                     weights = weights)
        PfVaR <- PfVaR$PortfolioVaR * sum(position)
    }
    
    list(
        VaRShort = VaR * scalFactorShort, 
        VaRLong = VaR * scalFactorLong,
        ePLShort = ePL * daysShort,
        ePLLong = ePL * daysLong,
        PfVaRShort = PfVaR * scalFactorShort, 
        PfVaRLong = PfVaR * scalFactorLong,
        PfePLShort = sum (ePL * daysShort),
        PfePLLong = sum (ePL * daysLong),
        prices = prices, 
        shares = shares, 
        position = position)
}