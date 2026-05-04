1. First install the laravel libraries and dependencies using composer install
2. change the DB_DATABASE location file path of exact of your file full_path 
(example: 
DB_CONNECTION=sqlite
DB_DATABASE=/Users/surajkumar/Downloads/Work/url-shortener/database/database.sqlite )
env example file is there in .env.example file if missing app key genrate key using
cp .env.example .env
php artisan key:generate
4. run the migrations using php artisan migrate
5. then need to run the super admin seeder using php artisan db:seed RoleSeeder
6. then the project will be ready use after running the php artisan serve
7. visit the route from console the project will be visible and in action 
// the fontend is mostly used by AI for time taking factor and since clearly mentioned the fronted should not be strictly monitered
Login using "superadmin@test.com" as email and "password" as password for super admin login then you can craete url and invite admin
