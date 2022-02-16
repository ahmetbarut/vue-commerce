# Laravel + Vue.js + TailwindCSS Simple E-Commerce

A simple e-commerce project by separating Laravel and vue.js

## What to do to use

- Database for Laravel
- composer
- npm

## Install

```shell
    git clone https://github.com/ahmetbarut/vue-commerce.git
```

## Laravel

Configure database

```shell
    cd backend
    composer install
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
```

## Vue.js

```shell
    cd frontend
    npm install
    yarn serve
```

## Test User

| Email   | Password |
|---------|----------|
| user@user.test | 1234|
