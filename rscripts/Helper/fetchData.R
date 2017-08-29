# Title     : Fetch data
# Objective : Fetching data from api
# Created by: Thomas
# Created on: 26.08.17

library(httr)

fetchHistories <- function(url) {
    request <- GET(url, add_headers(
        form_params = list(
            grant_type = 'client_credentials',
            client_id = client_id,
            client_secret = client_secret,
            scope = ''
    )))
    stop_for_status(request, url)

    dat <- content(request)
    len <- length(dat)
    dimnames = list(names(dat[[1]]), names(dat))
    m <- matrix(unlist(dat), ncol=len, dimnames=dimnames)

    m <- cbind(m, rep(1, len))
    colnames(m)[len+1] <- 'Unity'

    hist = c()
    for (i in 1:(len+1)) {

        dat <- xts::xts(m[,i], do.call("as.Date", list(x = rownames(m))))
        names(dat)<-colnames(m)[i]
        hist <- c(hist, list(dat))
    }
    names(hist)<-colnames(m)
    return(hist)
}

fetchPortfolio <- function(url) {
    request <- GET(url)
    stop_for_status(request, url)

    data <- content(request)

    if (length(data$items)) {
        items <- as.data.frame(t(matrix(unlist(data$items), ncol=length(data$items))), stringsAsFactors = FALSE)
        names(items) <- names(data$items[[1]])
    } else {
        items <- as.data.frame(NULL)
    }

    return(list(meta = data$meta, items = items))
}


