**Technical Assessment - Backend systems for Flight Booking**
Written in the PHP programming language, implemented the code for a flight booking. Include core features such as user account creation/login, flight booking management, 
 admin dashboard, and system reporting.

**Description**
Written in the PHP Symfony Framework programming language, implemented the code for a flight booking. Include core features such as user account creation/login, flight booking management, 
 admin dashboard, and system reporting.

**Getting Started**
Dependencies
Apache Server (PHP version 8.2)
MySQL Server
Installing
Download code clone
Executing program

**Run below given command in root dir. as given in sequence:**

composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load

optional
[
Open the .env file in root dir.
Replaces APP_ENV=dev with APP_ENV=prod
Then save file.
php bin/console clear:cache --env=prod
]


symfony server:start --port:8081

Now Open this link in your browser
http://localhost:8081/
