## Backend Setup

Run the following command inside the project directory:

composer install

```bash
php artisan migrate
php artisan db:seed
```

for the .env file copy the content of the .env.example then change the db accordingly and then run

```bash
php artisan key:generate
```
