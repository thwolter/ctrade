library(R6)
require(xts)
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


            private$load(paste(directory, filename, sep="/"))

            private$loadHistories(directory)
        },
        
        
        add = function(item)
        {
            self$items = c(self$items, item)
        },
        
        
        delta = function(current = TRUE)
        {
            delta = c()
            for (i in 1:length(self$items))
            {
                item <- self$items[[i]]
                
                ccy <- private$currencyPair(item$currency)
                dates <- zoo::index(self$hist[[1]])
                
                quote <- self$hist[[item$symbol]]
                fxrate <- self$hist[[ccy]]
                amount <- item$amountHistory(dates)
                
                dat <- private$merge(list(quote, fxrate, amount))
                
                delta <- c(delta, item$delta(quote, fxrate, amount))
                
            }
            names(delta) <- gsub('___', self$currency, names(delta))
                               
            nm <- unique(names(delta))
            nm <- nm[nm != private$currencyPair(self$currency)]
            
            nms <- sapply(nm, function(x) which(names(delta) == x))
            
            xtssum <- function(nm)
            {
                join <- private$merge(lapply(unlist(nm), function(x) delta[[x]]))
                sums <- rowSums(join)
                xtsjoin <- xts::as.xts(sums, zoo::index(delta[[nm[1]]]))
                names(xtsjoin) <- names(delta[nm[1]])
                return(xtsjoin)
            }
           
            res <- private$merge(lapply(nms, xtssum))
            res <- res[!apply(res[] == 0, 1, any),]
            
            n <- ifelse(current, 1, Inf)
            return (tail(res, n))
            
        },
        
        
        weights = function(current = TRUE)
        {
            delta = self$delta(current)
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
            
            returns <- do.call("merge.xts", c(args, fill = 0))
            colnames(returns) <- nms
                
            return(returns)
        },
        
        
        
        value = function(n = 1)
        {
            val <- 0
            for (i in 1:length(self$items))
            {
                item <- self$items[[i]]
                
                symbol <- item$symbol
                ccy <- private$currencyPair(item$currency)
                
                dates <- zoo::index(self$hist[[1]])
                
                quote <- self$hist[[symbol]]
                fxrate <- self$hist[[ccy]]
                amount <- item$amountHistory(dates)
                
                dat <- private$merge(list(quote, fxrate, amount))
                
                val <- val + item$value(quote, fxrate, amount)
            }
            
            colnames(val) <- "Value"
            
            return(tail(val, n))
        }
        
        
    ),
    
    
    private = list(

        load = function(filename) 
        {
            if (! file.exists(filename))
            stop(paste0("Missing Portfolio JSON file '", filename, "'."))

            self$items <- NULL;
            json <- jsonlite::fromJSON(filename)
            
            self$currency <- json$currency
            self$cash <- json$cash
           
            items <- as.data.frame(json$item)
            
            if (dim(items)[1]) {
                for (i in 1:dim(items)[1]) {
                    
                    item <- items[i,]
                    self$add(Stock$new(item$symbol, item$amount, item$currency))
                }
            } else {
                stop(paste("Task cannot be performed for empty portfolio ", json$name))
            }
        },
        
        loadHistories = function(directory)
        {
            rfs <- self$risk.factors()
            for (rf in rfs) {
                
                jsonfile = paste0(directory, '/', rf, ".json")
                
                if (! file.exists(jsonfile))
                    stop(paste0("Missing JSON file '", jsonfile, "'."))
                
                dat <- try(jsonlite::fromJSON(jsonfile), silent = TRUE)

                if (class(dat) == 'try-error')
                    stop(paste0("JSON file for symbol '", rf, "' with inappropriate format."))

                df <- data.frame(value = unlist(dat))
                colnames(df) <- rf

                dat <- xts::xts(df[,1], do.call("as.Date", list(x = rownames(df))),
                    src = "json", updated = Sys.time())

                self$hist <- c(self$hist, list(dat))
            }
            
            self$hist <- c(self$hist, list(private$fakeHist()))
            names(self$hist) = c(rfs, private$currencyPair(self$currency))
        },
        
        
        
        currencyPair = function(currency)
        {
            return(paste0(self$currency, currency))
        },
        
        
        
        quote = function(symbol, current = TRUE)
        {
            quotes <- as.numeric(self$hist[[symbol]])
            if (current) return(tail(quotes,1)) else quotes
        },
        
        
        
        fakeHist = function()
        {
            ccy <- private$currencyPair(self$currency)
            ref <- self$hist[[1]]
            res <- xts::as.xts(rep(1, times=dim(ref)[1]), zoo::index(ref))
            
            colnames(res) <- toupper(ccy)
            return(res)
        },
        
        
        
        merge = function(histories)
        {
            res <- do.call("merge.xts", c(histories, fill = 0))
            return(res)
        }
        
    )
)
