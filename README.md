Clone the project in your disk
------------------------------
git clone https://github.com/jlaso/my-simple-web.git

Prepare correct permissions
---------------------------
mkdir app/cache and app/logs
permissions +w on app/cache and app/logs

Create db
---------
introduce access to db in app/config/dbconfig.php, for that you can copy dbconfig_sample.php in
the same folder.
Then execute the script that creates the DB and fixtures for tables (you need almost PHP >= 5.3.7),

php regenerateDBwithoutConfirmation.php

Customization
-------------
customize logo and images on web/custom/frontend/img
 - web/custom/frontend/img/favicon.gif
 - web/custom/frontend/img/logo.png
 - web/custom/frontend/img/subcontent.png

* In backend (enter at /admin, user and pass admin), you can change trivial info of webpage,
like at the moment: web.title, web.description and web.keywords


See the issues if you want help to development.
And see the wiki for last minute info.

