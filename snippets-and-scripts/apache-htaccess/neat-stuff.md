# Placeholder image
```sh
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^.*(jpg|png)$ /path/to/placeholder.svg [L,R=302]
```

# Remove “.html” extension from URL
```sh
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME}.html -f
RewriteRule ^(.*)$ $1.html
```

# Disable mod_security (if necessary)
```sh
<IfModule mod_security.c>
  # SecFilterEngine Off
  SecFilterScanPOST Off
</IfModule>
```

# ???
```sh
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
```
