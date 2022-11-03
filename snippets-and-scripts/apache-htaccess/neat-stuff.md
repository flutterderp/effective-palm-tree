# Placeholder image
```sh
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^.*(jpg|png)$ /path/to/placeholder.svg [L,R=302]
```

# Useful headers

* [Content Security Policy (CSP)](https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP)
* [CSP Evaluator](https://csp-evaluator.withgoogle.com/)

```sh
<IfModule mod_headers.c>
  # Header set Content-Security-Policy: {policies}
  Header always set Content-Security-Policy "upgrade-insecure-requests;"
  Header set X-XSS-Protection "1; mode=block"
  # Header always append X-Frame-Options SAMEORIGIN
  Header set X-Content-Type-Options nosniff
  <FilesMatch "\.(css|js?)$">
    Header unset X-Content-Type-Options
  </FilesMatch>
</IfModule>
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
