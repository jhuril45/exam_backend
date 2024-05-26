## Backend Setup

Run the following command inside the project directory:

composer install
php artisan migrate
php artisan db:seed

for the .env file copy the content of the .env.example then change the db accordingly and then run
php artisan key:generate
