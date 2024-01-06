<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo"></a></p>

## About
Backend service for supporting APP Archive PLN (OJT Step)

## Tech Stack
- Php Laravel ✅
- ORM Eloquent ✅
- Laravel Passport ✅
- Psql ✅

## Features
- DB Migration ✅
- Authorization using bearer token ✅
- Autodeploy on vercel ✅

## How to run
- `clone` this repository
- prepare database using mysql. adjust db name, user, password in file `.env`
- run script `composer run-script startup-project` to create db migration, default seeder and client key
- run script `php artisan serve`