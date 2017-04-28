#
# test for simple in/out operation
#
RapiClass$set("private", "test-in-out", function()
{
    json <- jsonlite::read_json(opt$entity)
    private$write(json)
})



#
# Calculate the riks on portfolio and position level
# @result array with 1-day risks
#
RapiClass$set("private", "risk", function()
{
    pf <- Portfolio$new(private$entity, private$directory)
 
    require(methods) #for PerformanceAnalytics
    output <- PerformanceAnalytics::VaR(
        R = pf$returns(),
        p = opt$conf,
        weights = pf$delta(),
        portfolio_method = 'component'
    )
    
    result = c(output$contribution, Portfolio = output$MVaR)
    
    private$write(result)
    
})



#
# receive historic values of the portfolio
#
RapiClass$set("private", "valueHistory", function()
{
    pf <- Portfolio$new(private$entity, private$directory)
    
    private$write(as.data.frame(pf$value(60)))
})