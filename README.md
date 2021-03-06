# C-Contacts

Simple contact manager responsive web app with RESTful API.

- Try it out: http://mb.fullbusiness.com/cc/public/index.htm
- Swagger REST API documentation: http://mb.fullbusiness.com/cc/public/api-docs/contact

## Libraries used:

- [Backbone.js](http://backbonejs.org/)
- [Bootstrap 3](http://getbootstrap.com/)
- [Zend Framework 2](http://framework.zend.com/)
- [Doctrine ORM](http://www.doctrine-project.org/)
- [Swagger](https://developers.helloreverb.com/swagger/)
- [Composer](http://getcomposer.org/)

This repo also includes a Vagrant chef cookbook to get your development
environment up and runing in no time.

## Local Setup

  1. Clone the repo: `git clone git@github.com:mbman/ccontacts.git`
  2. Initialize git submodules: `git submodule update --init --recursive`
  4. Install Composer: http://getcomposer.org/download/ (skip if using provided Vagrant server)
  5. Install dependencies (ZF2, Doctrine & PHPunit): `sudo composer install --dev` or `sudo php composer,phar install --dev`
  6. Set ZF2 application environment by adding `SetEnv APPLICATION_ENV development` to Apache's `httpd.conf` (skip if using the provided Vagrant server)

### Database setup

Setup DoctrineORM with MySQL adapter, from project root directory:

  1. Validate database schema: `./vendor/bin/doctrine-module orm:validate-schema`
  2.  Create database: `./vendor/bin/doctrine-module orm:schema-tool:create`

Update database: `./vendor/bin/doctrine-module orm:schema-tool:update --force`

### Vagrant server setup:

If you don't have a local LAMP server running PHP 5.4 or higher,
you can use the provider Vagrant development server cookbook.

  1. Modify the `Vagrantfile` or leave the defaults
  2. Run `vagrant up` from the project root directory
  3. SSH into your server: `vagrant ssh`
  4. Go to web root: `cd /var/www/`
  5. Remove Apache's default html: `sudo rm index.html`
  6. Install dependencies (ZF2, Doctrine & PHPunit): `sudo composer install --dev`

The app is now running on: `192.168.56.101` using `ccontacts.dev` wildcard alias with ssl support

[More info on LAMPapp Vagrant cookbook](https://github.com/mbman/lampapp-vagrant)

## Unit Testing

PHPunit is included using Composer.

Run `../../../vendor/bin/phpunit` from "module/[Module name]/test/" directory.