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
    stop("parameter --base, -- directory, --entity, and --result have to be specified", call.=FALSE)
}




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
        'conf' = NULL,
        'period' = NULL,
        
        write = function(data) {
            if (!(is.data.frame(data) | is.list(data)))
                stop("Argument must be a data.frame; is class '", class(data), "'")
            
            jsonlite::write_json(data, private$result)
        },
        
        xts2df = function(data)
        {
            df <- cbind(zoo::index(data), as.data.frame(data))
            row.names(df) <- index(df)
            colnames(df)[1] <- "Date"
            return(df)
        },
        
        
        vec2df = function(data)
        {
            data.frame(Name = names(data), Value = as.vector(data))
        }
        
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
            private$conf <- array$conf
            private$period <- array$period
           
            setwd(private$base)
            
            source('Class/Instrument.R')
            source('Class/Stock.R')
            source('Class/Portfolio.R')
            
            self$do()
        },
        
        do = function() {
            foo <- self[[private$task]]
            
            if (is.null(foo))
                stop("no function for task '", private$task, 
                     "' defined (must be public with name '", private$task, "')")
            
            nms <- names(formals(foo))
            args <- lapply(nms, function(nm) {private[[nm]]})
            names(args) <- nms
            do.call(foo, args)
        },
        
        
        df = function(data)
        {
            if (any(class(data) == 'xts')) 
                return(private$xts2df(data))
            
            if (is.vector(data))
                return(private$vec2df(data))
            
            if (is.atomic(data))
                return(data.frame(Value = data))
            
            stop("Don't know how to convert class '", class(data), "' into a data.frame")
            
        }
        
    )
)




#
# Register scripts to be loaded for execution
#
source(paste(opt$base, "RiskRscript.R", sep = "/"))



#
# Run Api and perform requested task
#
RapiClass$new(opt)


