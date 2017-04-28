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
              help="confidence level for risk calculation [default= %default]", metavar="numeric")

); 

#
# parsing options and checking for existence of basic parameters
#
opt_parser = OptionParser(option_list=option_list);
opt = parse_args(opt_parser);


if (is.null(opt$base) | is.null(opt$directory) | is.null(opt$entity) | is.null(opt$result)) {
    print_help(opt_parser)
    stop("parameter --base, -- directory, --entity, and --result have to be specified", call.=FALSE)
}



#load("M:/00 Workings/shiny/rscripts/opt.RData")

#opt$base <-  "M:/00 Workings/shiny/rscripts"
#opt$entity <- "M:/00 Workings/shiny/rscripts/tests/1.json"
#opt$result <- "M:/00 Workings/shiny/rscripts/result.json"
#opt$directory <- "M:/00 Workings/shiny/rscripts/tests"


#
# Rapi Class definition
#
RapiClass <- R6Class('Rapi',
    
    privat = list(
        'base' = NULL,
        'result' = NULL,
        'directory' = NULL,
        'task' = NULL,
        'entity' = NULL,
        
        write = function(array) {write(RJSONIO::toJSON(array), file = private$result)}
    ),
    
    public = list(
        
        initialize = function(array) {
            
            if (!file.info(array$base)$isdir)
                stop(paste("base dirctory doesn't exist: ", array$base))
            
            if (!file.info(array$directory)$isdir)
                stop(paste("dirctory doesn't exist: ", array$directory))
            
            if (!file.exists(array$entity))
                stop(paste("entity file dosn't exist: ", array$entity))
            
            private$base <- array$base
            private$result <- array$result
            private$directory <- array$directory
            private$task <- array$task
            private$entity <- array$entity
           
            setwd(private$base)
            
            source('Class/Instrument.R')
            source('Class/Stock.R')
            source('Class/Portfolio.R')
            
            self$do()
        },
        
        do = function() {do.call(private[[private$task]], list())}
        
    )
)


##
# Register scripts to be loaded for execution
#
source(paste(opt$base, "RiskRscript.R", sep = "/"))



RapiClass$new(opt)


