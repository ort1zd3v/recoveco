call composer install
call npm install
call php artisan migrate:fresh --seed
call php artisan key:generate
call php artisan config:cache
call php artisan config:clear
call php artisan cache:clear
call php artisan view:clear
call php artisan lang:make
call php artisan passport:install
call npm run dev