* #* the commands line | Book Reviews App #* *

+ model:
- php artisan  make:model Book

+ views:
- php artisan make:view account\register
- php artisan make:view account\login
- php artisan make:view account\profile
- php artisan make:view layouts\app
- php artisan make:view layouts\sidebar
- php artisan make:view books\list
- php artisan make:view books\create
- php artisan make:view books\edit
- php artisan make:view home
- php artisan make:view detail

+ controllers:
- php artisan make:controller AccountController
- php artisan make:controller BookController
- php artisan make:controller HomeController

+ database:
- update users table: php artisan make:migration alter_users_table
- php artisan make:migration create_books_table

+ library: 
- composer require nesbot/carbon
- composer require intervention/image