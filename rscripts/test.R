url = 'https://capmyrisk.com/oauth/token'
client_id = 4
client_secret = '7TjmuPRaaCm5EqeV6mYlM8tB3bGvc99rpY1Z3EfA'

request <- POST(url, encode = "form",
    body = list(
        grant_type = 'client_credentials',
        client_id = 3,
        client_secret = '7TjmuPRaaCm5EqeV6mYlM8tB3bGvc99rpY1Z3EfA',
        scope = ''
    )
)

show(request)