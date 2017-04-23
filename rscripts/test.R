library(DataCache)

loadData <- function(symbol, src) {
    result <- quantmod::getSymbols(Symbols=symbol, env=NULL, src=src)
    names(result) <- paste('data', symbol, sep=".")
    return(result)
}