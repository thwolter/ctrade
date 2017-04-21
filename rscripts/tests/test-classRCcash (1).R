#test_dir("tests")

source_file('../classes/RCcash-class.R')

context("Class RCcash")

test_that("correct classes for assignemnt of an cash item", {
    item <- cash(1000, 'EUR')
    expect_s4_class(item, "RCcash")
    expect_is(id(item), 'numeric')
    expect_is(name(item), 'character')
    expect_is(amount(item), 'numeric')
    expect_is(currency(item), 'character')
    expect_is(sides(item), 'character')
})

test_that("correct assignment of variables by '<-' operator", {
    item <- cash(1000, 'EUR')
    id(item) <- 5
    amount(item) <- 2000 
    currency(item) <- "USD"
    name(item) <- "New Name"
    sides(item) <- "short"
    expect_true(id(item) == 5)
    expect_true(name(item) == "New Name")
    expect_true(amount(item) == 2000)
    expect_true(currency(item) == 'USD')
    expect_true(sides(item) == 'short')
}) 

test_that("correct values for initial assignemnt of an cash item", {
    item <- cash(1000, 'EUR')
    expect_true(id(item) == 0)
    expect_true(name(item) == '')
    expect_true(amount(item) == 1000)
    expect_true(currency(item) == 'EUR')
    expect_true(sides(item) == 'long')
})   
    