
# rc-instrument class -----------------------------------------------------

setClass('rc-instrument',
         representation = representation(
             id = 'numeric',
             name = 'character',
             currency = 'character',
             sides = 'character',
             price = 'list'
         ),
         prototype = prototype(
             id = 0,
             name = "",
             currency = NULL,
             sides = 'long',
             price = list()
         )
)


# rc-cash class -----------------------------------------------------------

setClass('rc-cash',
         representation = representation(
             amount = 'numeric'
         ),
         prototype = prototype(
             amount = 0
         ),
         contains = 'rc-instrument'
)


# rc-stock class ----------------------------------------------------------

setClass('rc-stock',
         representation = representation(
             shares = 'numeric',
             symbol = 'character'
         ),
         prototype = prototype(
             shares = 0,
             symbol = NULL
         ),
         contains = 'rc-instrument'
)



# rc-portfolio class ------------------------------------------------------

setClass("rc-portfolio",
         representation = representation(
             instruments = "list",
             tsdata = 'list',
             showProgress = 'logical'
         ),
         
         prototype = prototype(
             instruments = list(),
             tsdata = list(),
             showProgress = FALSE
         ),
         
         contains = 'rc-instrument'
)




# rc-user class -----------------------------------------------------------


setClass('rc-user',
         representation = representation(
             name = 'character',
             email = 'character',
             hash = 'character',
             loggedin = 'logical',
             userid = 'numeric',
             confirmed = 'logical',
             status = 'numeric',
             act_code = 'character',
             portfolios = 'list'
         ),
         prototype = prototype(
             name = NULL,
             email = NULL,
             hash = NULL,
             loggedin = FALSE,
             userid = NULL,
             confirmed = FALSE,
             status = NULL,
             act_code = NULL,
             portfolios = NULL
         )
)
