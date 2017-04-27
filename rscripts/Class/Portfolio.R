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
        
        
        delta = function(current = TRUE)
        {
            delta = c()
            for (i in 1:length(self$items))
            {
                item <- self$items[[i]]
                
                ccy <- private$currencyPair(item$currency)
                dates <- zoo::index(self$hist[[1]])
                
                quote <- quantmod::Cl(self$hist[[item$symbol]])
                fxrate <- quantmod::Cl(self$hist[[ccy]])
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
        
        
        
        value = function(current = TRUE)
        {
            val <- 0
            for (i in 1:length(self$items))
            {
                item <- self$items[[i]]
                
                symbol <- item$symbol
                ccy <- private$currencyPair(item$currency)
                
                dates <- zoo::index(self$hist[[1]])
                
                quote <- quantmod::Cl(self$hist[[symbol]])
                fxrate <- quantmod::Cl(self$hist[[ccy]])
                amount <- item$amountHistory(dates)
                
                dat <- private$merge(list(quote, fxrate, amount))
                
                val <- val + item$value(quote, fxrate, amount)
            }
            
            colnames(val) <- "Value"
            
            n <- ifelse(current, 1, Inf)
            return(tail(val, n))
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
            
            self$hist <- c(self$hist, list(private$fakeHist()))
            names(self$hist) = c(rfs, private$currencyPair(self$currency))
        },
        
        
        
        currencyPair = function(currency)
        {
            return(paste0(self$currency, currency))
        },
        
        
        
        quote = function(symbol, current = TRUE)
        {
            quotes <- as.numeric(quantmod::Cl(self$hist[[symbol]]))
            if (current) return(tail(quotes,1)) else quotes
        },
        
        
        
        fakeHist = function()
        {
            ccy <- private$currencyPair(self$currency)
            ref <- self$hist[[1]]
            res <- as.xts(rep(1, times=dim(ref)[1]), zoo::index(ref))
            
            colnames(res) <- paste(toupper(ccy), "Close", sep = ".")
            return(res)
        },
        
        
        
        merge = function(histories)
        {
            res <- do.call("merge.xts", c(histories, fill = 0))
            return(res)
        }
        
    )
)
