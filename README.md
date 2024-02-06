## Laravel Project Template

Put this in .env:

```bash
SESSION_DRIVER=cookie
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true  
```

Run command in termianl
```bash
php artisan key:generate
composer dump-autoload
php artisan optimize
php artisan migrate
php artisan db:seed
php artisan trail:generate
php artisan serve
```