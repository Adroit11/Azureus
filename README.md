# About

This school project is basically the deviantart clone with less more features. Our goal was to get nice grade. Now we're focusing on finishing this thing.

We're using Symfony 2.6 for backend and we have plan of using AngularJS as frontend framework in the future.

## Installation

### Requirements
1. LAMP, XAMPP or other server + database.
2. [Composer](https://getcomposer.org/doc/00-intro.md#using-the-installer)
3. Git

### Process
1. ```git clone https://github.com/karlosos/Azureus``` in your ```htdocs```, ```/var/www/```
2. Go to ```Azureus/web/azureus``` and do ```composer install```
3. Create database with ```php app/console doctrine:database:create```
4. Update database schema with php app/console doctrine:schema:update --force
5. [localhost/Azureus/web/azureus/web/app_dev.php](localhost/Azureus/web/azureus/web/app_dev.php)