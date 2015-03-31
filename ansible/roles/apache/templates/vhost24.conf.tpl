# Default Apache virtualhost template

<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot {{ doc_root }}
    {% set servernames = servername.split() %}
    {% for servername in servernames %}
    {% if loop.first %}
    ServerName {{ servername }}
    {% else %}
    ServerAlias {{ servername }}
    {% endif %}
    {% endfor %}

    <Directory {{ doc_root }}>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
        RewriteEngine On
        DirectoryIndex app_dev.php
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php [QSA,L]
        RewriteBase /
    </Directory>
</VirtualHost>
