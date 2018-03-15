

###run

```bash
docker-compose up
docker-compose exec workspace composer update
docker-compose exec workspace php artisan migrate --seed
```

###tests

```bash
docker-compose exec workspace phpunit
```


###call

a,x - user id (int)  
b,y - amount in cents (int)
```bash
curl "http://127.0.0.1:8085/test1?a=2&b=2&md5=7c103ddc7fa98bc2687b3902ad4f2710"
curl "http://127.0.0.1:8085/asdgOasds?x=2&y=2&md5=7c103ddc7fa98bc2687b3902ad4f2710"
```

OR  
you can use api via Paw (money.paw)  
See https://paw.cloud