
#

## Prerequisite

- Make sure you have [docker](https://docs.docker.com/engine/install/) & [docker-compose](https://docs.docker.com/compose/install/) installed on your machine
- Make sure you have the latest [NodeJS](https://github.com/nvm-sh/nvm#installing-and-updating) installed on your machine

## Installation

Go to the laravel folder first

    cd laravel

Install & run application using laravel sail

    sail up -d

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    sail artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    sail artisan migrate:fresh --seed

Install passport

    sail artisan passport:install

Symlink storage folder

    sail artisan storage:link

You can now access the server at <http://localhost>

Switch to the nuxt folder next

    cd ../nuxt/

Install all the dependencies using npm

    yarn

Copy the example env file and populate it with values from laravel

    cp .env.example .env

You can get `PASSPORT_PASSWORD_GRANT_ID` and `PASSPORT_PASSWORD_GRANT_SECRET` with `sail artisan passport:client --password`.

serve with hot reload at localhost:3000

    yarn dev
