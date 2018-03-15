

###run
```bash
docker-compose up
docker-compose exec workspace php artisan migrate --seed
```

###tests
```bash
docker-compose exec workspace phpunit
```