library(optparse)

option_list = list(
    make_option(c("-b", "--base"), type="character", default=NULL, 
                help="route path of r-scripts", metavar="character"),
    
    make_option(c("-f", "--file"), type="character", default=NULL, 
              help="portfolio file as json", metavar="character"),
    
    make_option(c("-o", "--out"), type="character", default=NULL, 
              help="output file name [default= %default]", metavar="character"),
    
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
                help="portfolio method [default= %default]", metavar="character"),
    
    make_option(c("-t", "--task"), type="character", default="test-in-out", 
              help="task to be performed [default=%default]", metavar="character")
); 

opt_parser = OptionParser(option_list=option_list);
opt = parse_args(opt_parser);


if (is.null(opt$file) | (is.null(opt$out))){
    print_help(opt_parser)
    stop("parameter -f (input file) and -o (output file) have to be specified", call.=FALSE)
}

setwd(opt$base) 
source('sources.R');

if (opt$task == "test-in-out") {
    json <- jsonlite::read_json(opt$file)
    jsonlite::write_json(json, opt$out, auto_unbox = TRUE)
}


save(file="opt.RData", opt)

if (opt$task == 'risk') 
{
    pfolio <- loadData(readJSON(opt$file))
    
    result_risk <- risk(pfolio, 
                 period = opt$period, 
                 p = opt$conf, 
                 t = opt$horizon, 
                 subset = opt$subset,
                 method = opt$risk_method,
                 portfolio_method = opt$portfolio_method
    )
    
    write(RJSONIO::toJSON(result_risk), file = opt$out)
}

