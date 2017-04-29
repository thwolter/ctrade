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

