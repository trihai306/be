# import requests
#
# url = "https://graph.facebook.com/1575795309135150/feed"
# params = {
#     "access_token": "EAAGNO4a7r2wBAKp9055f7mr1MLWaJwbsrC3asThLZBpLaGAbb0plqJZClSMOD7LTRqbXXoa72zIznlFpR3uEl8HEd44kGoYAoUDmtchdGkTC5Ib5tS1sverReKDkxWKgST9TNzWxlyf8E6Y4ehoE3h0qlCsYsqCeHJq7mGhAyBAn4ZC92J0"
# }
#
# headers = {
#     "accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
#     "accept-language": "en-US,en;q=0.9",
#     "cache-control": "max-age=0",
#     "sec-ch-ua": "\"Not.A/Brand\";v=\"8\", \"Chromium\";v=\"114\", \"Microsoft Edge\";v=\"114\"",
#     "sec-ch-ua-mobile": "?0",
#     "sec-ch-ua-platform": "\"Windows\"",
#     "sec-fetch-dest": "document",
#     "sec-fetch-mode": "navigate",
#     "sec-fetch-site": "none",
#     "sec-fetch-user": "?1",
#     "upgrade-insecure-requests": "1"
# }
#
# cookies = {
#     "datr": "klN9ZNqzHYGqmjROcL8GZ4Is",
#     "sb": "vlN9ZIvcwjGp2abcnr4vAzvz",
#     "c_user": "100057815212669",
#     "m_page_voice": "100057815212669",
#     "wd": "1865x929",
#     "xs": "12%3ASn0z_ZAKdXJ85w%3A2%3A1686530376%3A-1%3A6315%3A%3AAcXju97MwsSZCKj4T3c8VcwSFVHdbM5bc_JiA9QLB8E",
#     "presence": "C%7B%22lm3%22%3A%22u.100089831266162%22%2C%22t3%22%3A%5B%7B%22i%22%3A%22u.100011619888472%22%7D%2C%7B%22i%22%3A%22u.100083326174240%22%7D%2C%7B%22i%22%3A%22u.100078985068883%22%7D%2C%7B%22i%22%3A%22u.100024461437551%22%7D%5D%2C%22utc3%22%3A1687233056402%2C%22v%22%3A1%7D",
#     "fr": "0z2YBktVDFHC62r00.AWWVJxaCcrsS5USiYyd2v7OImT4.BkkSFn.N5.AAA.0.0.BkkSYY.AWXS3KQHDtM",
#     "usida": "eyJ2ZXIiOjEsImlkIjoiQXJ3ajl1bXVndDQ2dyIsInRpbWUiOjE2ODcyMzQ0MDF9"
# }
#
# response = requests.get(url, params=params, headers=headers, cookies=cookies)
# data = response.json()
#
# for post in data.get("data", []):
#     if 'description' in post:
#         print(post['description'])
