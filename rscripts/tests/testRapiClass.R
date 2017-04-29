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
                             if (any(class(data) == 'xts')) {
                                 df <- cbind(zoo::index(data), as.data.frame(data))
                                 row.names(df) <- index(df)
                                 colnames(df)[1] <- "Date"
                                 jsonlite::write_json(df, private$result)
                                 return()
                    
                             write(RJSONIO::toJSON(data), file = private$result)}
                             }
                        ),
                     
                     public = list(
                         
                         initialize = function(array, do = TRUE) {
                             
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
                             
                             if (do) self$do()
                         },
                         
                         do = function() {
                             foo <- self[[private$task]]
                             nms <- names(formals(foo))
                             args <- lapply(nms, function(nm) {private[[nm]]})
                             names(args) <- nms
                             do.call(foo, args)
                        }
                         
                     )
)




#
# Register scripts to be loaded for execution
#
source(paste(opt$base, "RiskRscript.R", sep = "/"))

