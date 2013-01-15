
Clone the project in your disk
------------------------------
git clone git@bitbucket.org:jlaso/my-simple-web.git

Prepare correct permissions
---------------------------
mkdir app/cache and app/logs
permissions +w on app/cache and app/logs

Create db
---------
introduce access to db in app/config/dbconfig.php, for that you can copy dbconfig_sample.php in
the same folder.
Next execute the script that creates the DB and fixtures for tables,

php regenerateDBwithoutConfirmation.php

Customization
-------------
customize logo and images on web/custom/frontend/img

