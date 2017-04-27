library(optparse)

option_list = list(
    
    #
    # parameters required for basic reading, writing and error-logging
    #
    make_option(c("--base"), type="character", default=NULL, 
                help="route path of r-scripts", metavar="character"),
    
    make_option(c("--directory"), type="character", default=NULL,
                help="directory with history data", metavar="character"),
    
    make_option(c("-t", "--task"), type="character", default="test-in-out", 
        help="task to be performed [default=%default]", metavar="character"),
    
    make_option(c("--entity"), type="character", default=NULL, 
        help="portfolio file as json", metavar="character"),
    
    make_option(c("--result"), type="character", default=NULL, 
        help="result output file name [default= %default]", metavar="character"),
    
    
    #
    # parameters for risk calculation
    #
    make_option(c("--conf"), type="numeric", default=0.95, 
              help="confidence level for risk calculation [default= %default]", metavar="numeric")

); 

#
# parsing options and checking for existence of basic parameters
#
opt_parser = OptionParser(option_list=option_list);
opt = parse_args(opt_parser);

#save(opt, file='/home/vagrant/Code/ctrade/rscripts/opt.RData')
if (is.null(opt$base) | is.null(opt$directory) | is.null(opt$entity) | is.null(opt$result)) {
    print_help(opt_parser)
    stop("parameter --base, -- directory, --entity, and --result have to be specified", call.=FALSE)
}


#
# setting working directory, load required classes and packages
#
setwd(opt$base) 
require(R6)
source('Class/Instrument.R')
source('Class/Stock.R')
source('Class/Portfolio.R')


#
# test for simple in/out operation
#
if (opt$task == "test-in-out") {
    
    json <- jsonlite::read_json(opt$entity)
    jsonlite::write_json(json, opt$result, auto_unbox = TRUE)
}



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
}
