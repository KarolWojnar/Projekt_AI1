%systemDrive%\xampp\mysql\bin\mysql -uroot -e "CREATE DATABASE IF NOT EXISTS ai1_lab6;"

php -r "copy('.env.example', '.env');"

call composer install

call php artisan key:generate

call php artisan storage:link

code .
