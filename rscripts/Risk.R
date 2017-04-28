if (opt$task == 'risk')
{
    pf <- Portfolio$new(opt$entity, opt$directory)

    require(methods) #for PerformanceAnalytics
    output <- PerformanceAnalytics::VaR(
    R = pf$returns(),
    p = opt$conf,
    weights = pf$delta(),
    portfolio_method = 'component'
    )

    result = c(output$contribution, Portfolio = output$MVaR)

    write(RJSONIO::toJSON(result), file = opt$result)
    #output$write(result)
}