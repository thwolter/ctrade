library(optparse)

option_list = list(
    
    #
    # parameters required for basic reading, writing and error-logging
    #
    make_option(c("-t", "--task"), type="character", default="test-in-out", 
                help="task to be performed [default=%default]", metavar="character"),
    
    make_option(c("--base"), type="character", default=NULL, 
                help="route path of r-scripts", metavar="character"),
    
    make_option(c("--entity"), type="character", default=NULL, 
              help="portfolio file as json", metavar="character"),
    
    make_option(c("--result"), type="character", default=NULL, 
              help="result output file name [default= %default]", metavar="character"),
    
    
    #
    # parameters for risk calculation
    #
    make_option(c("--hist"), type="numeric", default=250, 
              help="number of historical days for parameter estimation [default= %default]", metavar="numeric"),
    
    make_option(c("--subset"), type="character", default="", 
                help="an xts/ISO8601 style subset string for return calculation [default= %default]", metavar="character"),
    
    make_option(c("--conf"), type="numeric", default=0.95, 
              help="confidence level for risk calculation [default= %default]", metavar="numeric"),
    
    make_option(c("--period"), type="character", default="daily", 
              help="period for risk calculation [default= %default]", metavar="numeric"),
    
    make_option(c("--horizon"), type="numeric", default=1, 
                help="horizon for risk calculation [default= %default]", metavar="numeric"),
    
    make_option(c("--risk_method"), type="character", default="modified", 
                help="portfolio method [default= %default]", metavar="character"),
    
    make_option(c("--portfolio_method"), type="character", default="component", 
                help="portfolio method [default= %default]", metavar="character")
    
    
); 

#
# parsing options and checking for existence of basic parameters
#
opt_parser = OptionParser(option_list=option_list);
opt = parse_args(opt_parser);


if (is.null(opt$base) | is.null(opt$entity) | is.null(opt$entity)) {
    print_help(opt_parser)
    stop("parameter --base, --entity, --result have to be specified", call.=FALSE)
}


#
# setting working directory, load required classes and packages
#
setwd(opt$base) 
source('sources.R');


#
# test for simple in/out operation
#
if (opt$task == "test-in-out") {
    json <- jsonlite::read_json(opt$entity)
    jsonlite::write_json(json, opt$result, auto_unbox = TRUE)
}



if (opt$task == 'risk') 
{
    pfolio <- readData(readJSON(opt$entity))
    
    result_risk <- risk(pfolio, 
                 period = opt$period, 
                 p = opt$conf, 
                 t = opt$horizon, 
                 subset = opt$subset,
                 method = opt$risk_method,
                 portfolio_method = opt$portfolio_method
    )
    
    write(RJSONIO::toJSON(result_risk), file = opt$result)
}

