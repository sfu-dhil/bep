Books in English Parishes has migrated from Symfony to Django and this repo should not be used anymore. Please see [bep-django](https://github.com/sfu-dhil/bep-django) for the most up to date version of the bep project's codebase.

# Books in English Parishes

[Books in English Parishes][https://dhil.lib.sfu.ca/bep] (affectionately known as BEP) is a PHP application written using the
[Symfony Framework][https://symfony.com]. It is a digital tool for collecting data and metadata
about books used in English parishes.

## Requirements

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- A copy of the `bep.sql` database sql file. If you are not sure what these are or where to get them, you should contact the [Digital Humanities Innovation Lab](mailto:dhil@sfu.ca) for access. This file should be placed in the root folder.

## Initialize the Application

First you must setup the database for the first time

    docker compose up -d db
    # wait 30 after the command has fully completed
    docker exec -it bep_db bash -c "mysql -u bep -ppassword bep < /bep.sql"

Next you must start the whole application

    docker compose up -d --build

BEP will now be available at `http://localhost:8080/`

### Create your admin user credentials

    docker exec -it bep_app ./bin/console nines:user:create <your@email.address> '<your full name>' '<affiliation>'
    docker exec -it bep_app ./bin/console nines:user:password <your@email.address> <password>
    docker exec -it bep_app ./bin/console nines:user:promote <your@email.address> ROLE_ADMIN
    docker exec -it bep_app ./bin/console nines:user:activate <your@email.address>

example:

    docker exec -it bep_app ./bin/console nines:user:create test@test.com 'Test User' 'DHIL'
    docker exec -it bep_app ./bin/console nines:user:password test@test.com test_password
    docker exec -it bep_app ./bin/console nines:user:promote test@test.com ROLE_ADMIN
    docker exec -it bep_app ./bin/console nines:user:activate test@test.com

## General Usage

### Starting the Application

    docker compose up -d

### Stopping the Application

    docker compose down

### Rebuilding the Application (after upstream or js/php package changes)

    docker compose up -d --build

### Viewing logs (each container)

    docker logs -f bep_app
    docker logs -f bep_db
    docker logs -f bep_mail

### Accessing the Application

    http://localhost:8080/

### Accessing the Database

Command line:

    docker exec -it bep_db mysql -u bep -ppassword bep

Through a database management tool:
- Host:`127.0.0.1`
- Port: `13306`
- Username: `bep`
- Password: `password`

### Accessing Mailhog (catches emails sent by the app)

    http://localhost:8025/

### Database Migrations

Migrate up to latest

    docker exec -it bep_app make migrate

## Updating Application Dependencies

### Yarn (javascript)

First setup an image to build the yarn deps in

    docker build -t bep_yarn_helper --target bep-prod-assets .

Then run the following as needed

    # add new package
    docker run -it --rm -v $(pwd)/public:/app bep_yarn_helper yarn add [package]

    # update a package
    docker run -it --rm -v $(pwd)/public:/app bep_yarn_helper yarn upgrade [package]

    # update all packages
    docker run -it --rm -v $(pwd)/public:/app bep_yarn_helper yarn upgrade

Note: If you are having problems starting/building the application due to javascript dependencies issues you can also run a standalone node container to help resolve them

    docker run -it --rm -v $(pwd)/public:/app -w /app node:19.5 bash

    [check Dockerfile for the 'apt-get update' code piece of bep-prod-assets]

    yarn ...

After you update a dependency make sure to rebuild the images

    docker compose down
    docker compose up -d

### Composer (php)

    # add new package
    docker exec -it bep_app composer require [vendor/package]

    # add new dev package
    docker exec -it bep_app composer require --dev [vendor/package]

    # update a package
    docker exec -it bep_app composer update [vendor/package]

    # update all packages
    docker exec -it bep_app composer update

Note: If you are having problems starting/building the application due to php dependencies issues you can also run a standalone php container to help resolve them

    docker run -it -v $(pwd):/var/www/html -w /var/www/html dhilsfu/symfony-base:php-8.2-apache bash

    [check Dockerfile for the 'apt-get update' code piece of bep]

    composer ...

After you update a dependency make sure to rebuild the images

    docker compose down
    docker compose up -d

## Tests

First make sure the application and database are started with `docker compose up -d`

### Unit Tests

    docker exec -it bep_app make test

### Generate Code Coverage

    docker exec -it bep_app make test.cover
    make test.cover.view

If the coverage file doesn't open automatically you can manually open it `coverage/index.html`

## Misc

### PHP Code standards

See standards errors

    docker exec -it bep_app make lint-all
    docker exec -it bep_app make symlint

    # or
    docker exec -it bep_app make stan
    docker exec -it bep_app make twiglint
    docker exec -it bep_app make twigcs
    docker exec -it bep_app make yamllint
    docker exec -it bep_app make symlint


Automatically fix some standards errors

    docker exec -it bep_app make fix.all

### Debug helpers

    docker exec -it bep_app make dump.autowire
    docker exec -it bep_app make dump.container
    docker exec -it bep_app make dump.env
    docker exec -it bep_app make dump.params
    docker exec -it bep_app make dump.router
    docker exec -it bep_app make dump.twig
