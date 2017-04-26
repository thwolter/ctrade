library(R6)
## https://cran.r-project.org/web/packages/R6/vignettes/Introduction.html


Portfolio <- R6Class('Portfolio',
    
    public = list(
        items = NULL,
        currency = NULL,
        cash = NULL,
        hist = NULL,
        
        
        initialize = function(filename)
        {
            if (!requireNamespace("jsonlite", quietly = TRUE)) 
                stop("package:", dQuote("jsonlite"), "cannot be loaded.")
            
            if (!requireNamespace("xts", quietly = TRUE)) 
                stop("package:", dQuote("xts"), "cannot be loaded.")
            
            private$load(filename)
            private$loadHistories()
        },
        
        
        add = function(item)
        {
            self$items = c(self$items, item)
        },

        
        deltas = function()
        {
            return(list(currency =))
        },
        
        
        
        risk.factors = function()
        {
            rfs = c()
            for (i in 1:length(self$items))
            {
                item = self$items[[i]]
                
                symbol <- item$symbol
                if (! symbol %in% rfs) rfs <- c(rfs, item$symbol)
                
                currency <- paste0(self$currency, item$currency)
                pfpair <- paste0(self$currency, self$currency)
                if (! currency %in% rfs && currency != pfpair) rfs = c(rfs, currency)
            }
            return(rfs)
            
        }
    ),
    
    
    private = list(
        
        
        load = function(filename) 
        {
            self$items <- NULL;
            json <- jsonlite::fromJSON(filename)
            
            self$currency <- json$meta$currency
            self$cash <- json$cash$amount
            
            items <- as.data.frame(json$item)
            
            for (i in 1:dim(items)[1]) {
                
                item <- items[i,]
                self$add(Stock$new(item$symbol, item$amount, item$currency))
            }
        },
        
        loadHistories = function() 
        {
            col.names = c("Open", "High", "Low", "Close", "Volume", "Adjusted")
            
            rfs <- self$risk.factors()
            for (rf in rfs) {
                
                jsonfile = paste0(rf, ".json")
                
                if (! file.exists(jsonfile))
                    stop(paste0("Missing JSON file for symbol '", rf, "'."))
                
                dat <- try(jsonlite::fromJSON(jsonfile)[,-1], silent = TRUE)
                
                if (is(dat, 'try-error'))
                    stop(paste0("JSON file for symbol '", rf, "' with inappropriate format."))
                
                if (! is(dat[,2], "numeric")) {
                    df <- as.data.frame(dat)
                    df[,-1] <- sapply(dat[,-1], type.convert)
                    dat <- df
                }
                
                asDateArgs <- list(x = as.character(dat[, 1]))
                
                dat <- xts::xts(dat[, -1], do.call("as.Date", asDateArgs), src = "json", 
                           updated = Sys.time())
                
                if (dim(dat)[2] == 6) {
                    colnames(dat) <- paste(toupper(rf), col.names, sep = ".")
                } else {
                    colnames(dat)[1] <- paste(toupper(rf), col.names[4], sep = ".")
                    
                }
                self$hist <- c(self$hist, list(dat))
            }
            
            names(self$hist) = rfs
        }
            
    )
)
