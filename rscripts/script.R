source('sources.R')
pfolio <- loadData(readJSON('1.json'))
risk <- risk(pfolio, period = 'daily', p = 0.95, t = 250)
