source('../functions.R')

source('../classes/RCportfolio-class.R')
source('../classes/RCcash-class.R')
source('../classes/RCstock-class.R')


context("examplePortfolio")

test_that("examplePortfolio() is S4 class RCportfolio", {
    expect_s4_class(examplePortfolio(), "RCportfolio")

    
})

#test_dir("tests")