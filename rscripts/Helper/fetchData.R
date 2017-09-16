# Title     : Fetch data
# Objective : Fetching data from api
# Created by: Thomas
# Created on: 26.08.17

library(httr)


#
# Fetch the access token from the server.
# A token can be produced with command 'php partisan passwort:client'
#
fetchAccessToken <- function(uri, client_id, client_secret)
{
    request <- POST(url, encode = "form", 
        body = list(
            grant_type = 'client_credentials',
            client_id = client_id,
            client_secret = client_secret,
            scope = '*'
        )
    )
    
    return(content(request)$access_token)
}


fetchHistories <- function(url, token = NULL) {
    request <- GET(url, add_headers(
        'Accept' = 'application/json',
        'Authorization' = paste('Bearer', token)
    ))
    stop_for_status(request, url)

    dat <- content(request)$data
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


fetchPortfolio <- function(url, token = NULL) {
    request <- GET(url, add_headers(
        'Accept' = 'application/json',
        'Authorization' = paste('Bearer', token)
    ))
    stop_for_status(request, url)

    data <- content(request)$data

    if (length(data$assets)) {
        items <- as.data.frame(t(matrix(unlist(data$assets), ncol=length(data$assets))), stringsAsFactors = FALSE)
        names(items) <- names(data$assets[[1]])
    } else {
        items <- as.data.frame(NULL)
    }

    return(list(meta = data$portfolio, items = items))
}


