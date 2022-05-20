# Setting PHP version in htaccess
```shell
AddHandler application/x-httpd-php74 .php
<IfModule mod_suphp.c>
  SuPHP_ConfigPath %{DOCUMENT_ROOT}/public_html
</IfModule>
```

## Common PHP config overrides
```ini
allow_url_fopen = On
allow_url_include = Off
expose_php = Off
max_execution_time = 30
memory_limit = 128M
post_max_size = 64M
upload_max_filesize = 16M
zlib.output_compression = Off
```
