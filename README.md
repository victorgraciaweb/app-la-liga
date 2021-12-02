# app-la-liga

Project with Symfony 3.4 Framework using 7.4 PHP version.

How to run?
--

1. Install dependencies 
    
    `composer install`

2. Edit parameters file (/app/config/parameters.dist.yml) and rename file (/app/config/parameters.yml)
    
3. Open in browser (Port 80 by default)

    http://127.0.0.1/app_la_liga/web/app.php (App production)
    http://127.0.0.1/app_la_liga/web/app_dev.php (App develop)

    OR

    Yu can create a Virtual Host for access to project by browser

4. On production servers, Symfony applications use web servers such as Apache or nginx (see configuring a web server to run Symfony). However, on your local development machine you can also use the web server provided by Symfony, which in turn uses the built-in web server provided by PHP. First, install the Symfony Web Server and then, execute this command:

    `php bin/console server:run`

5. Open your browser if you have installed server symfony:

    http://localhost:8000/

How to test?
--

1. Execute this command

    `./vendor/bin/simple-phpunit`