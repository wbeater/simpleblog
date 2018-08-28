This project uses Yii 2 framework [Yii 2](http://www.yiiframework.com/).

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      documents/          contains guide to install & configure this project.
      migrations/         contains auto-generate table schemas and dummy data.
      models/             contains model classes
      runtime/            contains files generated during runtime
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.2.0.


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install asset plugins using the following command:

~~~
composer global require "fxp/composer-asset-plugin:~1.3"
~~~

After that, run composer install to setup required plugins

~~~
composer install
~~~


### Install MariaDB from [mariadb.org](http://mariadb.org)

Execute following command to create new database and its admin account;
~~~
# mysql -uroot -p
> create database 20ci charset utf8;
> create user 20ci_admin;
> grant all on 20ci.* to '20ci_admin'@'localhost' identified by '20ci8888';
> exit
~~~

Ensure that the DB config in /path/to/project/config/db.php are correct


### Create localhost domain for test:

Open file: 
    Window: C:\Windows\System32\drivers\etc\hosts
    Linux: /etc/hosts

Add following line into hosts file (You could change IP to the correct one)
~~~
127.0.0.1 20ci.blog
~~~


### Install & config Nginx:

Install nginx from [nginx.org](http://nginx.org)

Copy the file: /path/to/project/documents/env/nginx/twentyci.conf --> /etc/nginx/config.d


### Install php 7.2 and all dependency plugins

After that, Start nginx & php7.2-fpm

~~~
service nginx restart
service php7.2-fpm restart
service mysqld restart
~~~

### Run migrations to create tables and dummy data

The following command will create admin, demo account and hundreds of posts
Admin account: admin/admin
User account:  demo/demo

~~~
cd /path/to/project
./yii migrate/fresh
~~~

You can then access the application through the following URL:

~~~
http://20ci.blog
~~~
