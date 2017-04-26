library(R6)
## https://cran.r-project.org/web/packages/R6/vignettes/Introduction.html


Portfolio <- R6Class('Portfolio',
    
    public = list(
        items = NULL,
        currency = NULL,
        cash = NULL,
        hist = NULL,
        
        
        initialize = function(filename, directory)
        {
            if (!requireNamespace("jsonlite", quietly = TRUE)) 
                stop("package:", dQuote("jsonlite"), "cannot be loaded.")
            
            if (!requireNamespace("xts", quietly = TRUE)) 
                stop("package:", dQuote("xts"), "cannot be loaded.")
            
            if (!requireNamespace("quantmod", quietly = TRUE)) 
                stop("package:", dQuote("quantmod"), "cannot be loaded.")

            private$load(filename)
            private$loadHistories(directory)
        },
        
        
        add = function(item)
        {
            self$items = c(self$items, item)
        },
        
        
        delta = function()
        {
            delta = c()
            for (i in 1:length(self$items))
            {
                item <- self$items[[i]]
                
                price <- as.numeric(quantmod::Cl(tail(self$hist[[item$symbol]], 1)))
                
                fxrate <- NULL
                if (self$currency != item$currency)
                    fxrate <- as.numeric(quantmod::Cl(tail(self$hist[[paste0(self$currency, item$currency)]], 1)))
                
                delta <- c(delta, item$delta(price, fxrate))
            }
             
            names(delta) <- gsub('___', self$currency, names(delta))
                                
            nm <- unique(names(delta))
            nm <- nm[nm != paste0(self$currency, self$currency)]
            
            w <- NULL
            for (i in 1:length(nm)) {
                w<- c(w, sum(unlist(delta[names(delta) == nm[i]])))
            }
            names(w) <- nm
            return(w)
        },
        
        
        weights = function()
        {
            delta = self$delta()
            return(delta/sum(delta))
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
        },
        
        
        returns = function()
        {
            nms <- names(self$delta())
               
            args <- lapply(nms, 
                function(nm) quantmod::dailyReturn(self$hist[[nm]]))
            
            returns <- do.call("merge", c(args, fill = 0))
            colnames(returns) <- nms
                
            return(returns)
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
        
        loadHistories = function(directory)
        {
            col.names = c("Open", "High", "Low", "Close", "Volume", "Adjusted")
            
            rfs <- self$risk.factors()
            for (rf in rfs) {
                
                jsonfile = paste0(directory, '/', rf, ".json")
                
                if (! file.exists(jsonfile))
                    stop(paste0("Missing JSON file '", jsonfile, "'."))
                
                dat <- try(jsonlite::fromJSON(jsonfile)[,-1], silent = TRUE)
                
                if (class(dat) == 'try-error')
                    stop(paste0("JSON file for symbol '", rf, "' with inappropriate format."))
                
                if (class(dat[,2]) != "numeric") {
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
