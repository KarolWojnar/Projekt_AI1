%systemDrive%\xampp\mysql\bin\mysql -uroot -e

php -r "copy('.env.example', '.env');"

call composer install

call composer require stripe/stripe-php

call code --install-extension m4ns0ur.base64

call php artisan key:generate

call php artisan storage:link

call php artisan migrate

call php artisan db:seed

call php artisan serve

code .
