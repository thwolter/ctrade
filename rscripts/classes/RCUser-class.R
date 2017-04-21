


# show --------------------------------------------------------------------


setMethod('show', signature(object = 'rc-user'),
          function(object) {
              cat('\nUser Object')
              cat(paste0("\nname:      ", object@name))
              cat(paste0("\nemail:     ", object@email))
              cat(paste0("\nlogged in: ", object@loggedin)) 
              cat(paste0("\nuser id:   ", object@userid))  
              cat(paste0("\nstatus:    ", object@status)) 
              cat(paste0("\nconfirmed: ", object@confirmed))
              cat(paste0("\nact_code:  ", object@act_code))
          }
)



# email -------------------------------------------------------------------


setMethod('email', 
          signature(object = 'rc-user'),
          function(object) return(object@email)
)



# name --------------------------------------------------------------------


setMethod('name', 
          signature(object = 'rc-user'),
          function(object) return(object@name)
)

setMethod('name<-',
          signature(object = 'rc-user', value = 'character'),
          function(object, value) {
              object@name <- value
              return(object)
})



# act_code ----------------------------------------------------------------


setMethod('act_code', 
          signature(object = 'rc-user'),
          function(object) return(object@act_code)
)


# id ----------------------------------------------------------------------


setMethod('id', 
          signature(object = 'rc-user'),
          function(object) return(object@userid)
)



# status ------------------------------------------------------------------


setMethod('status', 
          signature(object = 'rc-user'),
          function(object) return(object@status)
)

setMethod('status<-',
          signature(object = 'rc-user', value = 'numeric'),
          function(object, value) {
              object@status <- value
              return(object)
          })


# createUser --------------------------------------------------------------


setMethod('createUser', 
          signature(email = 'character', password = 'character'),
          function(email, password) {
              hash <- hashPassword(password)
              
              query_id <- paste0(
                  "SELECT user.id FROM user WHERE email = '",
                  email, "';")
              res <- sqlQuery(query_id)
              
              if (length(res$id)) 
                  return('user-exist') 
              
              act_code <- UUIDgenerate(TRUE)
              query_new <- sprintf(
                    "INSERT INTO user (email, password, act_code, confirmed) VALUES ('%s', '%s', '%s', '%s')",
                    email, hash, act_code, 0)
              sqlQuery(query_new)
              
              res <- sqlQuery(query_id)
              
              object <- new('rc-user')
              object@loggedin <- TRUE
              object@userid <- res$id
              object@email <- email
              object@hash <- hash
              object@confirmed <- FALSE
              object@status <- 0
              object@act_code <- act_code
              
              return(object)
          }
)




# updateUser --------------------------------------------------------------

setMethod('updateUser', 
          signature(object = 'rc-user'),
          function(object) {
              query <- sprintf(
                  "UPDATE user SET name='%s', email='%s', password='%s', status='%s'",
                  object@name, object@email, object@hash, object@status)
          }
)



# loginUser ---------------------------------------------------------------


setMethod('loginUser', signature(email = 'character', password = 'character'),
          function(email, password) {
            
              query <- sprintf("SELECT id, password, status, confirmed FROM user WHERE email = '%s'", email)
              res <- sqlQuery(query)
             
              if (!dim(res)[1]) 
                  return(NULL)
              
              hash <- as.character(res$password)
              if (!verifyPassword(hash, password)) 
                  return(NULL) 
              
              object <- new('rc-user')
              object@loggedin <- TRUE
              object@userid <- res$id
              object@email <- email
              object@hash <- hash
              object@status <- as.numeric(res$status)
              object@confirmed <- as.logical(res$confirmed)
            
              return(object)
          }
)



# deleteUser --------------------------------------------------------------


setMethod('deleteUser', signature(userObject = 'rc-user'),
          function(userObject) {
              
              ids <- userPortfolios(userObject)$id
              
              for (i in ids) {
                  deletePortfolio(userObject, i)
              }
              
              query <- paste0(
                  "DELETE FROM user WHERE id='", userObject@userid, "';")
              sqlQuery(query)
              
              return(NULL)
          }
)



# pwdreset_code -----------------------------------------------------------


setMethod('pwdreset_code', signature(email = 'character'),
          function(email) {
              act_code <- UUIDgenerate(TRUE)
              query_new <- sprintf(
                  "UPDATE user SET act_code='%s' WHERE email='%s'", act_code, email)
              sqlQuery(query_new)
             
              return(act_code)
          })
              
              
             

# deletePortfolio ---------------------------------------------------------


setMethod('deletePortfolio', signature(userObject = 'rc-user', id = 'numeric'),
          function(userObject, id) {
              
              if (!existPortfolioWithId(userObject, id))
                  stop(paste0('Portfolio with id=', id, ' does not exist'))
              
              query <- paste0(
                  "DELETE FROM stock WHERE portfolio_id='", id, "';")
              sqlQuery(query)
              
              query <- paste0(
                  "DELETE FROM cash WHERE portfolio_id='", id, "';")
              sqlQuery(query)
              
              query <- paste0(
                  "DELETE FROM portfolio WHERE id='", id, "';")
              sqlQuery(query)
          }
)



# userPortfolios ----------------------------------------------------------


setMethod('userPortfolios', signature(userObject = 'rc-user'),
        function(userObject) {
            query <- paste0(
                "SELECT id AS id, portfolioname AS name FROM portfolio WHERE user_id = '", 
                userObject@userid, "'")
            
            res <- sqlQuery(query)
            
            if (!dim(res)[1]) return(NULL) else return(res)
        }
)



# addPortfolio ------------------------------------------------------------


setMethod('addPortfolio', signature(userObject = 'rc-user', portfolio = 'rc-portfolio'),
          function(userObject, portfolio) {
   
              if (existPortfolioWithName(userObject, portfolio@name))
                  stop(paste('portfolio name', name(portfolio), 'already exist'))
              
              if (!length(portfolio))
                  stop(paste('portfolio has length 0'))
      
              query <- sprintf(
                  "INSERT INTO portfolio (user_id, portfolioname, currency) VALUES ('%s', '%s', '%s')",
                  userObject@userid, name(portfolio), currency(portfolio))
              
              sqlQuery(query)
              
              query <- sprintf("SELECT id FROM portfolio WHERE user_id = '%s' AND portfolioname = '%s'",
                    userObject@userid , name(portfolio))
     
              res <- sqlQuery(query)
              pid <- res$id
               
              for (i in 1:lengthStocks(portfolio)) {
                    item <- stockItem(portfolio, i)
                    query <- sprintf(
                        "INSERT INTO stock (portfolio_id, stockname, shares, symbol, currency, sides) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
                        pid, name(item), shares(item), symbol(item), currency(item), sides(item))
                    
                    sqlQuery(query)
              }
              
              for (i in 1:lengthCashs(portfolio)) {
                  item <- cashItem(portfolio, i)
                  query <- sprintf(
                      "INSERT INTO cash (portfolio_id, cashname, amount, currency, sides) VALUES ('%s', '%s', '%s', '%s', '%s')",
                      pid, name(item), amount(item), currency(item), sides(item))
                  
                  sqlQuery(query)
              }
              
             return(list(id = pid))
          }
)




# updatePortfolio ---------------------------------------------------------


setMethod('updatePortfolio', signature(userObject = 'rc-user', portfolio = 'rc-portfolio'),
          function(userObject, portfolio) {
              
              if (!existPortfolioWithId(userObject, id(portfolio))) {
                  stop(sprintf("Portfolio with id=%s dosn't exist", id(portfolio)))
              }
              
              query <- sprintf("UPDATE portfolio SET portfolioname='%s'",
                               name(portfolio))
              sqlQuery(query)
              
              if (lengthStocks(portfolio)) {
                  for (i in 1:lengthStocks(portfolio)) {
                      item <- stockItem(portfolio, i)
                      query <- sprintf("SELECT id FROM stock WHERE portfolio_id='%s' AND symbol='%s'",
                                       id(portfolio), symbol(item))
                      itemid <- sqlQuery(query)
                      
                      if (!length(itemid) == 1)
                          stop("symbols are not unique for portfolio id='%s'", id(portfolio))
                      
                      query <- sprintf(
                          "UPDATE stock SET stockname='%s', shares='%s', currency='%s', sides='%s' WHERE id='%s'",
                          name(item), shares(item), currency(item), sides(item), itemid)
                      
                      sqlQuery(query)
                  }
              }
              
              if (lengthCashs(portfolio)) {
                  for (i in 1:lengthCashs(portfolio)) {
                      item <- cashItem(portfolio, i)
                      query <- sprintf("SELECT id FROM cash WHERE portfolio_id= '%s' AND currency= '%s'",
                                      id(portfolio), currency(item))
                      itemid <- sqlQuery(query)
                      
                      if (!length(itemid) == 1)
                          stop("currency is not unique for portfolio id='%s'", id(portfolio))
                      
                      query <- sprintf(
                          "UPDATE cash SET cashname='%s', amount='%s', sides='%s' WHERE id='%s'",
                          name(item), amount(item), sides(item), itemid)
                      
                      sqlQuery(query)
                  }
              }
              
              return()
          }
)



# getPortfolioById --------------------------------------------------------


setMethod('getPortfolioById', signature(userObject = 'rc-user', id = 'numeric'),
    function(userObject, id) {
        
        query <- sprintf("SELECT portfolioname, currency FROM portfolio WHERE id = '%s'", id)
        res <- sqlQuery(query)
        
        pfolio <- rcportfolio(res$portfolioname, res$currency)
        id(pfolio) <- id
        currency(pfolio) <- res$currency
        
        query <- sprintf("SELECT * FROM cash WHERE portfolio_id = '%s'", id)
        res <- sqlQuery(query)
        
        for (i in 1:dim(res)[1]) {
            item <- cash(amount = res$amount[i], currency = res$currency[i])
            name(item) <- res$cashname[i]
            sides(item) <- res$sides[i]
            pfolio <- addItem(pfolio, item)
        }
        
        query <- sprintf("SELECT * FROM stock WHERE portfolio_id = '%s'", id)
        res <- sqlQuery(query)
        
        for (i in 1:dim(res)[1]) {
            item <- stock(shares = res$shares[i], symbol = res$symbol[i], currency = res$currency[i])
            name(item) <- res$stockname[i]
            sides(item) <- res$sides[i]
            pfolio <- addItem(pfolio, item)
        }
        
        return(pfolio)
    }
)

setMethod('getPortfolioByName', signature(userObject = 'rc-user', name = 'character'),
          function(userObject, name) {
             
              res <- userPortfolios(userObject)
              pid <- res$id[which(res$name == name)]
              
              if (!length(pid))
                  stop(paste('no items found for portfolio', name))
              
              getPortfolioById(userObject, pid)
          }
)

setMethod('existPortfolioWithName', signature(userObject = 'rc-user', name = 'character'),
          function(userObject, name) {
              any(match(name, userPortfolios(userObject)$name, nomatch = 0))
          }
)

setMethod('existPortfolioWithId', signature(userObject = 'rc-user', id = 'numeric'),
          function(userObject, id) {
              any(match(id, userPortfolios(userObject)$id, nomatch = 0))
          }
)



# sqlQuery ----------------------------------------------------------------


setMethod('sqlQuery', signature(query = 'character'),
          function(query) {
              
              if (length(grep('apple', Sys.getenv('R_PLATFORM')))) {
                  conn <- try(dbConnect(
                          drv = RMySQL::MySQL(),
                          dbname = getOption('dbname'),
                          host = getOption('dbhost'),
                          username = getOption('dbusername'),
                          password = getOption('dbpassword')
                      ))
    
                  if (class(conn) == 'try-error') {
                     return('conn-error')
                  }
    
                  res <- dbGetQuery(conn, query)
                  dbDisconnect(conn)
              } else {
                  if (!dbIsValid(conn)) source('offline_db.R')
                  res <- dbGetQuery(conn, query)
              }
              
              return(res)
          }
)



# sendmail ----------------------------------------------------------------


setMethod('sendmail', signature(object = 'rc-user', subject = 'character', body = 'character'),
          function(object, subject, body) {
              sendmail(user@email, subject, body)
})

setMethod('sendmail', signature(object = 'character', subject = 'character', body = 'character'),
          function(object, subject, body) {
              send.mail(from = getOption('mail_from'),
                        to = object,
                        subject = subject,
                        body = body,
                        html = TRUE,
                        smtp = getOption('mail_smtp'),
                        authenticate = TRUE,
                        send = TRUE)
          })
              
