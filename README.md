<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Local Development

### Web Server

- Mac : use [Valet](https://laravel.com/docs/8.x/valet)
- Windows : use [Laragon](https://laragon.org/)

### Code Base

- Git clone from the [repo](https://github.com/andhiy01/Simple-Rest-API-Laravel-With-Passport).
- Follow the instruction from your Web Server on how to run this code base in your environment.
- Set up your virtual host if possible, so you can just open the project at your browser with _api.test_ for example.

### Back-end Config

0. Install Laravel version 9^ and PHP version 8.1^
1. Create new .env file, just copy and paste it from .env.example and rename to .env.
2. Create new database and update database variable on your .env file.
3. Import master db location (ask your Lead Dev or PM for this sql file).
4. Run `composer install` from your terminal.
5. Meanwhile, update your APP_URL on .env file to your virtual host, e.g. https://api.test
6. Run `php artisan key:generate` from your terminal.
7. Run `php artisan migrate:fresh --seed` if this is first time you start the project or just run `php artisan migrate` if you already have this repo before.
8. Run `php artisan clear-compiled` from your terminal.
9. Run `php artisan optimize:clear` from your terminal.
10. Run `php artisan passport:install` from your terminal and copy key to .env.
11. Now you can open the project from your browser using your own virtual host url (etc. api.test) or first, run `php artisan serve` and open it at http://localhost:8000 .
12. Start from here, you are ready to code.

For MAIL_HOST in .env file you can use Mailtrap.io and login with your own Google Account

### Github Collaboration
1. Create **new git branch** with your task or feature name, then **git checkout** to make sure you are now at your own branch.
2. Please do `git commit` on each task or feature, not a single commit for all tasks or features.
3. After you finished on your work, **git push** your commit to your own branch then **create new pull request (PR)** to Dev branch.

#### Please pay attention on this:
- You are not allowed to do `git push` to Dev branch.
- You are not allowed to run `composer update` from your terminal.
- You are not allowed to compile any assets from npm.
- You are allowed to install new Laravel package, but please discuss first before you do this :)

If you have any trouble just chat on our Slack Channel.

_This document is last updated at Monday, 06 Aug 2022_
