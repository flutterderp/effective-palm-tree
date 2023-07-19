# Force https
```sh
RewriteEngine On
RewriteCond %{HTTPS} !on [OR]
# RewriteCond %{HTTP:X-Forwarded-Proto} !https [OR]
# RewriteCond %{HTTP:CF-Visitor} '"scheme":"http"' [OR]
RewriteCond %{REQUEST_SCHEME} !https
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=302]
```

# Redirect temp URLs to primary domain
```sh
RewriteEngine On
RewriteCond %{HTTP_HOST} !^(?:www\.)?example\.com [NC]
RewriteRule ^(.*)$ http://www\.example\.com/$1 [L,R=302]
```

# Force ‘www’
```sh
RewriteEngine On
RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteRule ^(.*)$ http://www\.%{HTTP_HOST}%{REQUEST_URI} [L,R=302]
```

# Force non-‘www’
```sh
RewriteEngine On
RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]
RewriteRule ^(.*)$ http://%1%{REQUEST_URI} [L,R=302]
``````

# Force ‘www’ and https in one step
## Comment out the response headers that don't apply to your project/site
```sh
RewriteEngine On
RewriteCond %{HTTPS} !on [OR]
# RewriteCond %{HTTP:X-Forwarded-Proto} !https [OR]
# RewriteCond %{HTTP:CF-Visitor} '"scheme":"http"' [OR]
RewriteCond %{REQUEST_SCHEME} !https [OR]
RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteCond %{HTTP_HOST} ^(?:www\.)?(.+)
RewriteRule ^(.*)$ https://www\.%1%{REQUEST_URI} [L,R=302]
## Add a `?` to the rewrite rule if the host uses litespeed
## https://openlitespeed.org/kb/migrate-apache-rewrite-rules-to-openlitespeed/#2_Migrate_from_Apache_Document_Root_htaccess_to_OpenLiteSpeed_Vhost_Rewrite_Tab
# RewriteRule ^?(.*)$ https://www\.%1%{REQUEST_URI} [L,R=302]
```
