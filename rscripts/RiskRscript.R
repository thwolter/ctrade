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
# test for simple in/out operation
#
RapiClass$set("private", "test-in-out", function()
{
    json <- jsonlite::read_json(opt$entity)
    private$write(json)
})
