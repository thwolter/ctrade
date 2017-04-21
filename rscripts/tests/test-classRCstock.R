#test_dir("tests")

source_file('../classes/RCstock-class.R')
load("Symbols.RData")

context("Class RCstock")

test_that("correct classes for assignemnt of an stock item", {
    item <- stock(shares = 10, symbol = 'ALV.DE', 'EUR', NULL)
    expect_s4_class(item, "RCstock")
    expect_is(id(item), 'numeric')
    expect_is(name(item), 'character')
    expect_is(shares(item), 'numeric')
    expect_is(currency(item), 'character')
    expect_is(sides(item), 'character')
    expect_is(tsdata(item), 'NULL')
})

test_that("correct assignment of variables by '<-' operator", {
    item <- stock(shares = 10, symbol = 'ALV.DE', 'EUR', NULL)
    id(item) <- 4
    shares(item) <- 20
    symbol(item) <- "DAI.DE"
    currency(item) <- "USD"
    name(item) <- "New Name"
    sides(item) <- "short"
    tsdata(item) <- DAI.DE
    expect_true(id(item) == 4)
    expect_true(name(item) == "New Name")
    expect_true(shares(item) == 20)
    expect_true(currency(item) == 'USD')
    expect_true(sides(item) == 'short')
    expect_true(length(tsdata(item)) == 15738)
}) 

test_that("correct values for initial assignemnt of an stock item", {
    item <- stock(shares = 10, symbol = 'ALV.DE', 'EUR', NULL)
    expect_true(id(item) == 0)
    expect_true(name(item) == '')
    expect_true(shares(item) == 10)
    expect_true(currency(item) == 'EUR')
    expect_true(sides(item) == 'long')
    expect_true(is.null(tsdata(item)))
})   
    
test_that("NULL values if no 'xts' for slot 'data' provided", {
    item <- stock(shares = 10, symbol = 'ALV.DE', 'EUR', NULL)    
    expect_true(is.null(price(item)))
    expect_true(is.null(total(item)))
})  
    
test_that("Error if no 'xts' for slot 'data' provided", {
    item <- stock(shares = 10, symbol = 'ALV.DE', 'EUR', NULL)     
    expect_error(returns(item))
    expect_error(risk(item))
    expect_error(lastDate(item))
    expect_error(historyLength(item))
})

test_that("Results if 'xts' for slot 'data' provided", {
    item <- stock(shares = 10, symbol = 'ALV.DE', 'EUR', ALV.DE)    
    expect_true(price(item) == 165.65)
    expect_true(total(item) == 1656.5)
    expect_true(lastDate(item) == "2017-02-23")
    expect_true(historyLength(item) == 2623)
})  

test_that("'risk' and 'returns' with different parameters", {
    item <- stock(shares = 10, symbol = 'ALV.DE', 'EUR', ALV.DE)   
    expect_true(round(risk(item), 2) == -551.36)
    expect_true(round(risk(item, t = 1), 2) == -34.87)
    expect_true(round(risk(item, t = 1, method = "historical", period = "monthly"), 2) == -212.57)
    expect_true(round(mean(returns(item, period = "weekly")), 8) == 0.00127256)
    expect_true(round(mean(returns(item, subset = '2007::')), 8) == 0.00025954)
})
