load("~/Code/ctrade/rscripts/opt.RData")

opt$task <- "valueHistory"
opt$base <- "~/Code/ctrade/rscripts/"
opt$directory <- "~/Code/ctrade/rscripts/tests"
opt$entity <- "~/Code/ctrade/rscripts/tests/Portfolio.json"
opt$result <- "~/Code/ctrade/rscripts/tests/result.json"

setwd("~/Code/ctrade/rscripts/")
source("tests/testRapiClass.R")
rapi <- RapiClass$new(opt, TRUE)


pf <- Portfolio$new(opt$entity, opt$directory)