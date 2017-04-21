setClass('RCSettings',
         representation = representation(
             id = 'character',
             confLevel = 'numeric',
             usedHistory = 'character',
             periodShort = 'numeric',
             periodLong = 'numeric',
             sfValue = 'character',
             sfPercent2d = 'character',
             portfolioMethod = 'character',
             daysPerYear = 'numeric',
             googleClientId = 'character',
             GoogleClientKey = 'character'
         ),
         prototype = prototype(
             id = NULL,
             confLevel = 0.95,
             usedHistory = '260 days',
             periodShort = 30,
             periodLong = 260,
             sfValue = '%.2f',
             sfPercent2d = '%1.2f%%',
             portfolioMethod = 'marginal',
             daysPerYear = 260,
             googleClientId = "168818159414-amddpm9vrtn1cmt29s2fsainae0rg93i.apps.googleusercontent.com",
             GoogleClientKey = "nL2SOnei0piy91KMf3sps-Zu"
         )
)

if(!isGeneric("newSetttings"))
    setGeneric("newSetttings", function(id) standardGeneric("newSetttings"))

if(!isGeneric("setParameter"))
    setGeneric("setParameter", function(object, parameter, value) standardGeneric("setParameter"))

if(!isGeneric("getParameter"))
    setGeneric("getParameter", function(object, parameter) standardGeneric("getParameter"))


setMethod('newSetttings', signature(id = 'character'),
          function(id) {
              settings <- new('RCSettings')
              settings@id <- id
              return(settings)
          }
)


setMethod('show', signature(object = 'RCSettings'),
          function(object) {
              cat('\nSetting Object')
              cat(paste0("\nObject ID: '", object@id, "'\n"))
              
              sn <- names(getSlots('RCSettings'))[-1]
              vs <- unlist(lapply(sn, function(s) slot(object, s)))
              show(data.frame(Parameter = vs, row.names = sn))
          }
)

setMethod('setParameter', 
          signature(object = 'RCSettings', parameter = 'character', value = 'character'),
          function(object, parameter, value) {
              slot(object, parameter) <- value
              return(object)
          }
)

setMethod('getParameter', 
          signature(object = 'RCSettings', parameter = 'character'),
          function(object, parameter) {
              return(slot(object, parameter))
          }
)