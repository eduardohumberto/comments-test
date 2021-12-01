# Project Comment System
This is a project for study purpose, that allows creating and list nested comments.

##Getting started

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x)

Alternative installation is possible without local dependencies relying on [Docker](#docker).

Clone the repository

    git clone git@github.com:eduardohumberto/comments-test.git

Switch to the repo folder

    cd comments-test

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Install node dependencies and compile

    npm install && npm run dev

Start the local development server

    php artisan serve

###Test

To run all unit tests just execute the follow command

    ./vendor/bin/phpunit
