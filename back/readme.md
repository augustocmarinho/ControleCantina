# Cantina
Projeto requer PHP > 7.2, composer e banco de dados Postgres.  
Instalar e seguir os seguintes comandos

```
cp .env.example .env
```
Edit .env

## Project setup
```
composer install
```

```
php artisan migrate
```

```
php artisan db:seed
```

```
php artisan key:generate

```
php artisan passport:install
```

### Server for development
```
php artisan serve
```

Acessar via http://127.0.0.1:8000