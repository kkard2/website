# php moment

# apache settings
`/etc/httpd/conf/httpd.conf`

```
DocumentRoot "/path/to/project/src"
<Directory "/path/to/project/src">
    # ...
    AllowOverride All
    # ...
</Directory>

# uncomment this line
LoadModule rewrite_module modules/mod_rewrite.so
```
