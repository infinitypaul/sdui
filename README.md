<p align="center">NEWS CRUD</p>
<p align="center"><a href="https://infinitypaul.medium.com">Creator</a></p>

## Tech Stack

* Laravel
* SQLLite
* PHP

## Download Instruction

1. Clone the project.

```
git clone https://github.com/infinitypaul/sdui.git projectname
```


2. Install dependencies via composer.

```
composer install 
```

2. SQLite Configuration

```
touch database/database.sqlite

//Add to your env

DB_CONNECTION=sqlite
DB_FOREIGN_KEYS=true

```

3. Migrate and seed the Database.

```
php artisan migrate --seed
```

4. Run Test.

```
php artisan test
```

5. Run php server.

```
php artisan serve
```

6. Available Command.

```
php artisan clean:news 
```


Enjoy!!
