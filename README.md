# Blog code challenge

To start we need to install `php` and `node.js` with `npm` and also a `MySQL` RDBMS, then run following commands:

```shell
# clone project
$ git clone https://github.com/osamehf/blog.git
$ cd blog

# install package dependencies
$ composer install

# make laravel key
$ php artisan key:generate

# install and seed DB after changing the DB config
$ php artisan migrate
$ php artisan db:seed

# install node packages and compile css and js
$ npm install
$ npm run dev

# serve the application
$ php artisan serve --port=8088
```

to see the website please open the `http://localhost:8088/`
