# addItem -----------------------------------------------------------------

if(!isGeneric("addItem"))
    setGeneric("addItem", function(object, item) standardGeneric("addItem"))

if(!isGeneric("addItem<-"))
    setGeneric("addItem<-", function(object, value) standardGeneric("addItem<-"))



# amount ------------------------------------------------------------------

if(!isGeneric("amount"))
    setGeneric("amount", function(object) standardGeneric("amount"))

if(!isGeneric("amount<-"))
    setGeneric("amount<-", function(object, value) standardGeneric("amount<-"))



# cash --------------------------------------------------------------------

if(!isGeneric("cash"))
    setGeneric("cash", function(amount, currency) standardGeneric("cash"))



# currency ----------------------------------------------------------------

if(!isGeneric("currency"))
    setGeneric("currency", function(object) standardGeneric("currency"))

if(!isGeneric("currency<-"))
    setGeneric("currency<-", function(object, value) standardGeneric("currency<-"))



# format.df ---------------------------------------------------------------


if(!isGeneric("format.df"))
    setGeneric("format.df", function(object, fvalue='%.2f', fperc='%.2f') standardGeneric("format.df"))


# id ----------------------------------------------------------------------

if(!isGeneric("id"))
    setGeneric("id", function(object) standardGeneric("id"))

if(!isGeneric("id<-"))
    setGeneric("id<-", function(object, value) standardGeneric("id<-"))



# item --------------------------------------------------------------------

if(!isGeneric("item"))
    setGeneric("item", function(object, i) standardGeneric("item"))



# itemById ----------------------------------------------------------------

if(!isGeneric("itemById"))
    setGeneric("itemById", function(object, id) standardGeneric("itemById"))



# itemBySymbol ------------------------------------------------------------

if(!isGeneric("itemBySymbol"))
    setGeneric("itemBySymbol", function(object, symbol) standardGeneric("itemBySymbol"))



# is.complete -------------------------------------------------------------

if(!isGeneric("is.complete"))
    setGeneric("is.complete", function(object) standardGeneric("is.complete"))



# lastDate ----------------------------------------------------------------

if(!isGeneric("lastDate"))
    setGeneric("lastDate", function(object) standardGeneric("lastDate"))



# historyLength -----------------------------------------------------------

if(!isGeneric("historyLength"))
    setGeneric("historyLength", function(object) standardGeneric("historyLength"))



# name --------------------------------------------------------------------

if(!isGeneric("name"))
    setGeneric("name", function(object) standardGeneric("name"))

if(!isGeneric("name<-"))
    setGeneric("name<-", function(object, value) standardGeneric("name<-"))



# price -------------------------------------------------------------------

if(!isGeneric("price"))
    setGeneric("price", function(object, symbol) standardGeneric("price"))

if(!isGeneric("price<-"))
    setGeneric("price<-", function(object, symbol, value) standardGeneric("price<-"))



# shares ------------------------------------------------------------------

if(!isGeneric("shares"))
    setGeneric("shares", function(object) standardGeneric("shares"))

if(!isGeneric("shares<-"))
    setGeneric("shares<-", function(object, value) standardGeneric("shares<-"))



# sides -------------------------------------------------------------------

if(!isGeneric("sides"))
    setGeneric("sides", function(object) standardGeneric("sides"))

if(!isGeneric("sides<-"))
    setGeneric("sides<-", function(object, value) standardGeneric("sides<-"))



# stock -------------------------------------------------------------------

if(!isGeneric("stock"))
    setGeneric("stock", function(shares, symbol, currency) standardGeneric("stock"))



# symbol ------------------------------------------------------------------

if(!isGeneric("symbol"))
    setGeneric("symbol", function(object) standardGeneric("symbol"))


if(!isGeneric("symbol<-"))
    setGeneric("symbol<-", function(object, value) standardGeneric("symbol<-"))



# type --------------------------------------------------------------------


if(!isGeneric("type"))
    setGeneric("type", function(object) standardGeneric("type"))



# value -------------------------------------------------------------------

if(!isGeneric("value"))
    setGeneric("value", function(object, cls = NULL) standardGeneric("value"))



# risk.weigths ------------------------------------------------------------

if(!isGeneric("risk.weigths"))
    setGeneric("risk.weigths", function(object, item = NULL) standardGeneric("risk.weigths"))



# rcportfolio -------------------------------------------------------------

if(!isGeneric("rcportfolio"))
    setGeneric("rcportfolio", function(name, currency) standardGeneric("rcportfolio"))



# showProgress ------------------------------------------------------------

if(!isGeneric("showProgress"))
    setGeneric("showProgress", function(object) standardGeneric("showProgress"))

if(!isGeneric("showProgress<-"))
    setGeneric("showProgress<-", function(object, value) standardGeneric("showProgress<-"))



# table.cash --------------------------------------------------------------


if(!isGeneric("table.cash"))
    setGeneric("table.cash", function(object, fvalue='%.2f', fperc='%.2f', compress = TRUE) standardGeneric("table.cash"))



# table.stocks --------------------------------------------------------------


if(!isGeneric("table.stocks"))
    setGeneric("table.stocks", function(object, fvalue='%.2f', fperc='%.2f',compress = TRUE) standardGeneric("table.stocks"))


# tsdata ------------------------------------------------------------------

if(!isGeneric("tsdata"))
    setGeneric("tsdata", function(object, symbol) standardGeneric("tsdata"))

if(!isGeneric("tsdata<-"))
    setGeneric("tsdata<-", function(object, symbol, value) standardGeneric("tsdata<-"))



# update ------------------------------------------------------------------

if(!isGeneric("update"))
    setGeneric("update", function(object, item) standardGeneric("update"))

if(!isGeneric("update<-"))
    setGeneric("update<-", function(object, value) standardGeneric("update<-"))



# removeItem --------------------------------------------------------------

if(!isGeneric("removeItem"))
    setGeneric("removeItem", function(object, pos) standardGeneric("removeItem"))



# removeItemWithId --------------------------------------------------------

if(!isGeneric("removeItemWithId"))
    setGeneric("removeItemWithId", function(object, id) standardGeneric("removeItemWithId"))



# returns -----------------------------------------------------------------

if(!isGeneric("returns"))
    setGeneric("returns", function(object, period = 'daily', ...) standardGeneric("returns"))



# risk --------------------------------------------------------------------

if(!isGeneric("risk"))
    setGeneric("risk", function(object, period = 'daily', p = 0.95, t = 250, ...) standardGeneric("risk"))



# risk.factors ------------------------------------------------------------

if(!isGeneric("risk.factors"))
    setGeneric("risk.factors", function(object) standardGeneric("risk.factors"))



# loadData ----------------------------------------------------------------

if(!isGeneric("loadData"))
    setGeneric("loadData", function(object, force=FALSE) standardGeneric("loadData"))



# pushPrices --------------------------------------------------------------

if(!isGeneric("pushPrices"))
    setGeneric("pushPrices", function(object) standardGeneric("pushPrices"))



# userPortfolios ----------------------------------------------------------

if(!isGeneric("userPortfolios"))
    setGeneric("userPortfolios", function(userObject) standardGeneric("userPortfolios"))



# addPortfolio ------------------------------------------------------------

if(!isGeneric("addPortfolio"))
    setGeneric("addPortfolio", function(userObject, portfolio) standardGeneric("addPortfolio"))



# updatePortfolio ---------------------------------------------------------

if(!isGeneric("updatePortfolio"))
    setGeneric("updatePortfolio", function(userObject, portfolio) standardGeneric("updatePortfolio"))



# getPortfolioByName ------------------------------------------------------

if(!isGeneric("getPortfolioByName"))
    setGeneric("getPortfolioByName", function(userObject, name) standardGeneric("getPortfolioByName"))



# getPortfolioById --------------------------------------------------------

if(!isGeneric("getPortfolioById"))
    setGeneric("getPortfolioById", function(userObject, id) standardGeneric("getPortfolioById"))



# deletePortfolio ---------------------------------------------------------

if(!isGeneric("deletePortfolio"))
    setGeneric("deletePortfolio", function(userObject, id) standardGeneric("deletePortfolio"))



# existPortfolioWithName --------------------------------------------------

if(!isGeneric("existPortfolioWithName"))
    setGeneric("existPortfolioWithName", function(userObject, name) standardGeneric("existPortfolioWithName"))



# existPortfolioWithId ----------------------------------------------------

if(!isGeneric("existPortfolioWithId"))
    setGeneric("existPortfolioWithId", function(userObject, id) standardGeneric("existPortfolioWithId"))



# createUser --------------------------------------------------------------

if(!isGeneric("createUser"))
    setGeneric("createUser", function(email, password) standardGeneric("createUser"))



# updateUser --------------------------------------------------------------


if(!isGeneric("updateUser"))
    setGeneric("updateUser", function(object) standardGeneric("updateUser"))


# loginUser ---------------------------------------------------------------

if(!isGeneric("loginUser"))
    setGeneric("loginUser", function(email, password) standardGeneric("loginUser"))



# sqlQuery ----------------------------------------------------------------

if(!isGeneric("sqlQuery"))
    setGeneric("sqlQuery", function(query) standardGeneric("sqlQuery"))



# deleteUser --------------------------------------------------------------

if(!isGeneric("deleteUser"))
    setGeneric("deleteUser", function(userObject) standardGeneric("deleteUser"))



# email -------------------------------------------------------------------

if(!isGeneric("email"))
    setGeneric("email", function(object) standardGeneric("email"))



# act_code ----------------------------------------------------------------

if(!isGeneric("act_code"))
    setGeneric("act_code", function(object) standardGeneric("act_code"))



# pwdreset_code -----------------------------------------------------------


if(!isGeneric("pwdreset_code"))
    setGeneric("pwdreset_code", function(email) standardGeneric("pwdreset_code"))


# sendmail ----------------------------------------------------------------

if(!isGeneric("sendmail"))
    setGeneric("sendmail", function(object, subject, body) standardGeneric("sendmail"))


# status ------------------------------------------------------------------


if(!isGeneric("status"))
    setGeneric("status", function(object) standardGeneric("status"))

if(!isGeneric("status<-"))
    setGeneric("status<-", function(object, value) standardGeneric("status<-"))
