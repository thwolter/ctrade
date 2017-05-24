#
# test for simple in/out operation
#
RapiClass$set("public", "test-in-out", function()
{
    json <- jsonlite::read_json(paste(opt$directory, opt$entity, sep = "/"))
    private$write(json)
})



#
# Calculate the riks on portfolio and position level
# @result array with 1-day risks
#
RapiClass$set("public", "risk", function()
{
    pf <- Portfolio$new(private$entity, private$directory)

    require(methods) #for PerformanceAnalytics
    output <- PerformanceAnalytics::VaR(
        R = pf$returns(),
        p = opt$conf,
        weights = pf$delta(),
        portfolio_method = 'component'
    )
    
    result = list(
        Risks = self$df(output$contribution), 
        Total = self$df(output$MVaR)
    )
    
    private$write(result)
    
})



#
# receive historic values of the portfolio
#
RapiClass$set("public", "valueHistory", function(period)
{
    pf <- Portfolio$new(private$entity, private$directory)
    
    result = list(
        History = self$df(pf$value(period))
    )
    
    private$write(result)
})


RapiClass$set("public", "summary", function(period, conf)
{
    pf <- Portfolio$new(private$entity, private$directory)

    valueHist = pf$value(period)

    require(methods) #for PerformanceAnalytics
    Risk <- PerformanceAnalytics::VaR(
        R = pf$returns(),
        p = conf,
        weights = pf$delta(),
        portfolio_method = 'component'
    )
    
    Returns = colMeans(pf$returns()) * pf$delta()
    
    result = list(
        Risks = self$df(Risk$contribution), 
        Total = self$df(Risk$MVaR),
        Returns = self$df(Returns),
        Value = self$df(pf$value()),
        History = self$df(valueHist)
    )
    
    private$write(result)
    
})