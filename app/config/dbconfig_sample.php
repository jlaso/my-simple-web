<?php

    define('DBHOST', 'localhost');
    define('DBNAME', 'my-simple-web');
    define('DBUSER', 'root');
    define('DBPASS', 'root');

    $languages = array(
        'en'    => _('English'),
        'es'    => _('Espa&ntilde;ol'),
    );

    define('LANGUAGES', serialize($languages));