source_file('../functions.R')

source_file('../classes/RCcash-class.R')
source_file('../classes/RCstock-class.R')
source_file('../classes/RCportfolio-class.R')


context("examplePortfolio")
load("Symbols.RData")

context("Class RCportfolio")

test_that("correct classes for assignemnt of an portfolio", {
    pfolio <- rcportfolio('New Portfolio')
    expect_s4_class(pfolio, "RCportfolio")
    expect_is(id(pfolio), 'numeric')
    expect_is(name(pfolio), 'character')
    expect_is(currrency(pfolio), 'character')
})

test_that("check for correct '<-' assignments", {
    pfolio <- rcportfolio('New Portfolio')
    id(pfolio) <- 40
    name(pfolio) <- "New Name"
    currrency(pfolio) <- 'EUR'
    
    expect_true(id(pfolio) == 40)
    expect_true(name(pfolio) == "New Name")
    expect_true(currency(pfolio)) == 'EUR'
}) 

test_that("add and delete portfolio items", {
    pfolio <- rcportfolio('New Portfolio')
    expect_true(length(pfolio) == 0)
    
    item_1 <- stock(shares = 10, symbol = 'ALV.DE', 'EUR', NULL)
    item_2 <- stock(shares = 20, symbol = 'BAS.DE', 'EUR', NULL)
    item_3 <- cash(1000, 'EUR')
    item_4 <- cash(1000, 'USD')
    
    addItem(pfolio) <- item_1
    expect_true(length(pfolio@stocks) == 1)
    expect_false(is.complete(pfolio))
    
    addItem(pfolio) <- item_2
    addItem(pfolio) <- item_3
    expect_equal(slots(pfolio, "RCstock")$id, c(1,2))
    expect_true(slots(pfolio, "RCcash")$id == 3)
    expect_true(length(pfolio) == 3)
    
    pfolio <- deleteStock(pfolio, 1)
    expect_true(slots(pfolio, "RCstock")$id == 2)
    expect_true(slots(pfolio, "RCcash")$id == 3)
    
    addItem(pfolio) <- item_1
    addItem(pfolio) <- item_4
    
    expect_equal(slots(pfolio, "RCstock")$id,c(2,4))
    expect_equal(slots(pfolio, "RCcash")$id, c(3,5))
})   

test_that("get and replace items", {
    pfolio <- rcportfolio('New Portfolio')
    addItem(pfolio) <- stock(shares = 10, symbol = 'ALV.DE', 'EUR', NULL)
    addItem(pfolio)  <- stock(shares = 20, symbol = 'BAS.DE', 'EUR', NULL)
    addItem(pfolio)  <- stock(shares = 20, symbol = 'BAS.DE', 'EUR', NULL)
    addItem(pfolio)  <- cash(1000, 'EUR')
    addItem(pfolio)  <- cash(1000, 'USD')
    
    expect_equal(slots(pfolio, "RCcash")$id, c(4,5))
    expect_equal(slots(pfolio, "RCstock")$id, c(1,2,3))
    expect_false(is.complete(pfolio))
    
    expect_error(update(pfolio, item_1))
    expect_error(update(pfolio) <-  item_1)
    
    item <- itemWithId(pfolio, 1)
    tsdata(item) <- get(symbol(item))
    update(pfolio) <- item
    expect_true(price(itemWithId(pfolio, 1)) == 165.65)
})  


test_that("Error massages", {
    pfolio <- rcportfolio('New Portfolio')
    addItem(pfolio) <- stock(shares = 10, symbol = 'ALV.DE', 'EUR', NULL)
    addItem(pfolio)  <- stock(shares = 20, symbol = 'BAS.DE', 'EUR', NULL)
    addItem(pfolio)  <- stock(shares = 20, symbol = 'BAS.DE', 'EUR', NULL)
    addItem(pfolio)  <- cash(1000, 'EUR')
    addItem(pfolio)  <- cash(1000, 'USD')
    
    expect_error(cashItem(pfolio, 0))
    expect_error(cashItem(pfolio, 3))
    expect_equal(id(cashItem(pfolio, 2)), 5)
    
    expect_error(stockItem(pfolio, 0))
    expect_error(stockItem(pfolio, 4))
    expect_equal(id(stockItem(pfolio, 2)), 2)
})    
    
    
test_that("Risk and Return calculations", {
    pfolio <- rcportfolio('New Portfolio')
    addItem(pfolio) <- stock(shares = 10, symbol = 'ALV.DE', 'EUR', NULL)
    addItem(pfolio)  <- stock(shares = 20, symbol = 'BAS.DE', 'EUR', NULL)
    addItem(pfolio)  <- stock(shares = 20, symbol = 'BAS.DE', 'EUR', NULL)
    addItem(pfolio)  <- cash(1000, 'EUR')
    addItem(pfolio)  <- cash(1000, 'USD')
    pfolio <- loadHistory(pfolio, progress = FALSE)
})
   
