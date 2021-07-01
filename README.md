# Laravel Blog

This is the companion repository for a 7-part series walking through using Laravel to set up barebones blog.

- Part 1: [Walk-through installing and configuring Laravel](https://www.levijackson.xyz/posts/create-a-laravel-8-blog-part-1-setup/)
- Part 2: [Create the core models/tables, controllers, and views](https://www.levijackson.xyz/posts/create-a-laravel-8-blog-part-2-scaffolding/)
- Part 3: [Authorization/Login](https://www.levijackson.xyz/posts/create-a-laravel-8-blog-part-3-authentication/)
- Part 4: [Post CRUD](https://www.levijackson.xyz/posts/create-a-laravel-8-blog-part-4-post-crud/)
- Part 5: [Comment CRUD](https://www.levijackson.xyz/posts/create-a-laravel-8-blog-part-5-comment-crud/)
- Part 6: [Validation ](https://www.levijackson.xyz/posts/create-a-laravel-8-blog-part-6-validation/)
- Part 7: [Testing](https://www.levijackson.xyz/posts/create-a-laravel-8-blog-part-7-testing/)


## Setup
1) Start up Laravel
### Option 1
If port 80 and 3306 are open on your local machine
```
./vendor/bin/sail up
```

### Option 2
If port 80 (web) or 3306 (mysql) is in use

```
APP_PORT=6001 FORWARD_DB_PORT=6002 ./vendor/bin/sail up
```

2) Copy the default `.env` file
```
cp .env.example .env
```

3) Generate application key
```
./vendor/bin/sail artisan key:generate
```


## Testing
```
./vendor/bin/sail test
```