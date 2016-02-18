# sfapi

A symfony test bundle for restfull api with oauth

## Usefull documentation

### Restfull api

http://blog.octo.com/designer-une-api-rest/

### Basic RESTful API with Symfony 2

https://gist.github.com/tjamps/11d617a4b318d65ca583

### Restful OAuth

https://gist.github.com/lologhi/7b6e475a2c03df48bcdd

### FOSRestBundle

http://obtao.com/blog/2013/12/creer-une-api-rest-dans-une-application-symfony/

http://welcometothebundle.com/web-api-rest-with-symfony2-the-best-way-the-post-method/

http://npmasters.com/2012/11/25/Symfony2-Rest-FOSRestBundle.html

## Usage

Try to get unauthenticated data

```
$ curl -D - -X GET http://api.local/trucs/1

HTTP/1.1 401 Unauthorized
Date: Thu, 18 Feb 2016 16:50:10 GMT
Server: Apache/2.4.16 (Unix) PHP/5.6.18
X-Powered-By: PHP/5.6.18
WWW-Authenticate: Bearer realm="Service", error="access_denied", error_description="OAuth2 authentication required"
Cache-Control: no-store, private
Pragma: no-cache
Content-Length: 78
Content-Type: application/json

{
    "error":"access_denied",
    "error_description":"OAuth2 authentication required"
}
```

Request token 

```
# POST
$ curl -X POST -D - \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"grant_type":"passowrd", "username":"admin", "password":"admin", "client_id":"1_3bcbxd9e24g0gk4swg0kwgcwg4o8k8g4g888kwc44gcc0gwwk4", "client_secret":"4ok2x70rlfokc8g0wws8c8kwcokw80k44sg48goc0ok4w0so0k"}' \
  http://api.local/oauth/v2/token

# GET
$ curl -X GET -D - \
  "http://api.local/oauth/v2/token?grant_type=password&username=admin&password=admin&client_id=1_3bcbxd9e24g0gk4swg0kwgcwg4o8k8g4g888kwc44gcc0gwwk4&client_secret=4ok2x70rlfokc8g0wws8c8kwcokw80k44sg48goc0ok4w0so0k"

HTTP/1.1 200 OK
Date: Thu, 18 Feb 2016 16:56:01 GMT
Server: Apache/2.4.16 (Unix) PHP/5.6.18
X-Powered-By: PHP/5.6.18
Cache-Control: no-store, private
Pragma: no-cache
Content-Length: 263
Content-Type: application/json

{
    "access_token":"M2QwNTc0MTkwYWNlZjI4YzdhOGI2Y2U0ZTkyZDM4MDBlMjc1YTUxMWY5YjE1OWNlMzAwODc4ZTVjZGI4ZGY3Yg",
    "expires_in":3600,
    "token_type":"bearer",
    "scope":null,
    "refresh_token":"MmU4NjVmODVkNzg3ZTRiNWJhNGQ2YTVmNWU0MjA0ZjZiNzUyMDBkYWI4ZjdmM2Y5YTI5MTE0YzUyZGM4NWM0Zg"
}
```

Retry to get data with token

```
curl -X GET -D - \
  -H "Authorization:Bearer M2QwNTc0MTkwYWNlZjI4YzdhOGI2Y2U0ZTkyZDM4MDBlMjc1YTUxMWY5YjE1OWNlMzAwODc4ZTVjZGI4ZGY3Yg" \
  http://api.local/trucs/42

HTTP/1.1 200 OK
Date: Thu, 18 Feb 2016 16:57:58 GMT
Server: Apache/2.4.16 (Unix) PHP/5.6.18
Vary: Authorization
X-Powered-By: PHP/5.6.18
Cache-Control: no-cache
Content-Length: 21
Content-Type: application/json

{
    "id":42,
    "nom":"toto"
}
```

Create new item

```
$ curl -X POST -D - \
  -H "Content-Type: application/json" \
  -H "Authorization:Bearer M2QwNTc0MTkwYWNlZjI4YzdhOGI2Y2U0ZTkyZDM4MDBlMjc1YTUxMWY5YjE1OWNlMzAwODc4ZTVjZGI4ZGY3Yg" \
  -d '{"nom":"tata"}' \
  http://api.local/trucs

HTTP/1.1 201 Created
Date: Thu, 18 Feb 2016 16:59:14 GMT
Server: Apache/2.4.16 (Unix) PHP/5.6.18
Vary: Authorization
X-Powered-By: PHP/5.6.18
Cache-Control: no-cache
Location: http://api.local/trucs/43
Content-Length: 0
Content-Type: application/json
```

Update item

```
$ curl -X PUT -D - \
  -H "Content-Type: application/json" \
  -H "Authorization:Bearer M2QwNTc0MTkwYWNlZjI4YzdhOGI2Y2U0ZTkyZDM4MDBlMjc1YTUxMWY5YjE1OWNlMzAwODc4ZTVjZGI4ZGY3Yg" \
  -d '{"nom":"toto42"}' \
  http://api.local/trucs/42

HTTP/1.1 204 No Content             <==== TODO : should be HTTP 200
Date: Thu, 18 Feb 2016 17:00:43 GMT
Server: Apache/2.4.16 (Unix) PHP/5.6.18
Vary: Authorization
X-Powered-By: PHP/5.6.18
Cache-Control: no-cache
Location: http://api.local/trucs/42
Content-Length: 0
Content-Type: text/html; charset=UTF-8
```

Patch item

```
$ curl -X PATCH -D - \
  -H "Content-Type: application/json" \
  -H "Authorization:Bearer M2QwNTc0MTkwYWNlZjI4YzdhOGI2Y2U0ZTkyZDM4MDBlMjc1YTUxMWY5YjE1OWNlMzAwODc4ZTVjZGI4ZGY3Yg" \
  -d '{"nom":"toto10"}' \
  http://api.local/trucs/42

HTTP/1.1 204 No Content             <==== TODO : should be HTTP 200
Date: Thu, 18 Feb 2016 17:00:43 GMT
Server: Apache/2.4.16 (Unix) PHP/5.6.18
Vary: Authorization
X-Powered-By: PHP/5.6.18
Cache-Control: no-cache
Location: http://api.local/trucs/42
Content-Length: 0
Content-Type: text/html; charset=UTF-8
```

Delete item

```
curl -X DELETE -D - \
  -H "Authorization:Bearer M2QwNTc0MTkwYWNlZjI4YzdhOGI2Y2U0ZTkyZDM4MDBlMjc1YTUxMWY5YjE1OWNlMzAwODc4ZTVjZGI4ZGY3Yg" \
  http://api.local/trucs/17

HTTP/1.1 204 No Content             <==== TODO : should be HTTP 200
Date: Thu, 18 Feb 2016 17:03:54 GMT
Server: Apache/2.4.16 (Unix) PHP/5.6.18
Vary: Authorization
X-Powered-By: PHP/5.6.18
Cache-Control: no-cache
Content-Length: 0
Content-Type: text/html; charset=UTF-8
```

Search items

```
curl -X GET -D - \
  -H "Authorization:Bearer M2QwNTc0MTkwYWNlZjI4YzdhOGI2Y2U0ZTkyZDM4MDBlMjc1YTUxMWY5YjE1OWNlMzAwODc4ZTVjZGI4ZGY3Yg" \
  http://api.local/trucs/search?nom=tata2

HTTP/1.1 200 OK
Date: Thu, 18 Feb 2016 17:10:07 GMT
Server: Apache/2.4.16 (Unix) PHP/5.6.18
Vary: Authorization
X-Powered-By: PHP/5.6.18
Cache-Control: no-cache
Content-Length: 164
Content-Type: application/json

[
    {"id":5,"nom":"tata2"},
    {"id":6,"nom":"tata2"},
    {"id":7,"nom":"tata2"},
]
```
