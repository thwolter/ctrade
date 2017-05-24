library(optparse)
library(R6)

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
              help="confidence level for risk calculation [default= %default]", metavar="numeric"),
              
    make_option(c("--period"), type="numeric", default=1, 
              help="time period [default= %default]", metavar="numeric")

); 

#
# parsing options and checking for existence of basic parameters
#
opt_parser = OptionParser(option_list=option_list);
opt = parse_args(opt_parser);


if (is.null(opt$base) | is.null(opt$directory) | is.null(opt$entity) | is.null(opt$result)) {
    print_help(opt_parser)
    stop("parameter --base, --directory, --entity, and --result have to be specified", call.=FALSE)
}


#
# dump environment for subsequent debugging in case of an error
# for debugging call load("errordump.rda"); debugger(errordump)
options(error = quote(dump.frames("errordump", TRUE)))


#
# modify opt and save it for testing purposes in lacal RStudio
#
opt.tmp <- opt
opt$base <- gsub('/home/vagrant', '/Users/Thomas', opt$base)
opt$directory <- gsub('/home/vagrant', '/Users/Thomas', opt$directory)
save(opt, file = paste(opt.tmp$base, 'opt.RData', sep="/"));
opt <- opt.tmp


#
# load the Rapi class
#
source(paste(opt$base, "Class/Rapi.R", sep = "/"))



#
# Register scripts to be loaded for execution
#
source(paste(opt$base, "RiskRscript.R", sep = "/"))



#
# Run Api and perform requested task
#
RapiClass$new(opt)


