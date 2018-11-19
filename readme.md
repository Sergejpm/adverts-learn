### Simple setup guide

See Makefile for frequently used commands.

1. Build docker images:

    ```
    make docker-build
    ```

2. Run composer install via docker:

    ```
    docker-compose run composer install
    ```

3. Set permission on storage folder:

    ```
    make permission
    ```

4. Make .env and then generate app key:
    
    ```
    docker-compose exec php-cli php artisan key:generate
    ```
5. Compile assets:

    ```
    make assets-install
    make assets-dev
    ```
    If error exists exec before make assets-dev
    ```
    make assets-rebuild
    ```

6. Insert mailtrap username and password to .env . ([Sign up](https://mailtrap.io/) if you don't have account) 
    
    ```
    docker-compose exec php-cli php artisan key:generate
    ```
7. Set SMS_DRIVER=array for dev. 


Also optionally you can seed your database with:
```
docker-compose exec php-cli php artisan db:seed
```

To grant user rights use:
```
docker-compose exec php-cli php artisan user:role <email> <role>
```