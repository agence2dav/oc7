# Oc7 - project for openclassroom

## Mission

Create an Api using Symfony 7.0. <img src="https://img.shields.io/badge/symfony-7-0" alt="symfony 7.0">
The project will let :

    consult the list of BileMo products (name of the factice provider of service, certainly a joke);
    consult the details of a BileMo product;
    consult the list of registered users linked to a customer on the website;
    view the details of a registered user linked to a customer;
    add a new user linked to a customer;
    delete a user added by a customer.

## Requirements

Based on the last Php-8.3 <img src="https://img.shields.io/badge/php-8.3-%23777BB4?logo=php" alt="php banner">, the architecture of the software respect of the segregation of the functions, recommended by the <a href="https://fr.wikipedia.org/wiki/SOLID_(informatique)">SOLID principle</a>.

## Uml Graphics

The UML for this project are in the directory `/_docs/uml`.
You can see :
- the diagram of use
- the diagram of sequence
- the classes diagram
- the model of datas, with all the relations between the tables

## Components

We use <a href="https://www.dotenv.org/docs/languages/php.html">Dotenv</a> to store the access for the Odbc. Use Composer to install it :

We use the templater <a href="https://twig.symfony.com/doc/3.x/props/extends.html">Twig</a> to dissociate the front-end from the back-end.

We use <a href="https://github.com/squizlabs/PHP_CodeSniffer">PhpCs</a> as a linter in the <a href="https://fr.wikipedia.org/wiki/Environnement_de_d%C3%A9veloppement">EDI</a> <a href="https://code.visualstudio.com/">VsCode</a> for the respect of the standard <a href="https://www.php-fig.org/psr/psr-12/">Psr-12</a>.

Le list of the components used in this project is :
    "php": ">=8.2",
    "ext-ctype": "*",
    "ext-iconv": "*",
    "fakerphp/faker": "*",
    "symfony/console": "7.0.*",
    "symfony/debug-bundle": "7.0.*",
    "symfony/dotenv": "7.0.*",
    "symfony/filesystem": "7.0.*",
    "symfony/flex": "^2",
    "symfony/framework-bundle": "7.0.*",
    "symfony/runtime": "7.0.*",
    "symfony/security-bundle": "7.0.*",
    "symfony/string": "7.0.*",
    "symfony/validator": "7.0.*",
    "symfony/webapp-pack": "*",
    "symfony/yaml": "7.0.*",
    "symfonycasts/reset-password-bundle": "*",
    "symfonycasts/verify-email-bundle": "*",

The css used for this project is from <a href="https://bootswatch.com/5/darkly/bootstrap.min.css/startbootstrap-freelancer/">Bootstrap</a>. And the FontFaces are from https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css.

## Installation

You will need a Webserver Apache2 using Php-8+ (we use Php-8.3), and an <a href="https://fr.wikipedia.org/wiki/Open_Database_Connectivity">ODBC</a> like Mysql. We prefer MariaDb which is open source and built in opposition of the buyback of Mysql by Oracle.

### On you local server

Supposing you have <a href="https://git-scm.com/">GIT</a> installed, clone this repository :

    git clone https://github.com/agence2dav/oc7

Then, let <a href="https://getcomposer.org/">Composer</a> install the components from the `composer.json`:

Security Audit

    composer audit

Now it's time to :

    composer install

Create your own .env.local, that will replace the default datas from .env.
Especially the database:

    DATABASE_URL="mysql://{dbname-root}:{password}@127.0.0.1:3306/oc6"

And secondly the mailer: 

    MAILER_DSN=mailgun+smtp://USERNAME:PASSWORD@default?region=eu

Once the database is set, it's time to install it:

    php bin/console doctrine:database:create

Migrate the schema of the databases for Symfony:

    php bin/console make:migration

Now persist this schema on the database (that create the tables) :

    php bin/console doctrine:migration:migrate

Your site is now ready. To perform tests we can write a set of false datas:

    php bin/console doctrine:fixtures:load

If you need to redo all that, you can kill the database:

    php bin/console doctrine:database:drop --force

In localhosting only, you can using the server of Symfony:

    symfony server:start -d

From there, your site will totally be operationnal.

### On a webserver

Use the root folder /public to perform the git clone. That will create the directory `oc6`.
You can now do a `adduser oc7`, and obtain it's ftp codes.

Set your virtualhost, following the instructions from: <a href="https://symfony.com/doc/current/setup/web_server_configuration.html">Symfony Docs</a>. You don't need the options of `SetHandler proxy:unix` as it is said.

A very good tutorial for clone a repository on a webserver, tested and it works, is : <a href="http://david-robert.fr/articles/view/deployer-symfony-vps"></a>. You can follow it step by step.

