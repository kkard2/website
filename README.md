live site is available @ [kkard2.com](https://kkard2.com/)

# apache

## Windows (XAMPP)

NOTE: this will break all other projects inside `htdocs/`, so backing up
      configuration file is advised.

- `{{XAMPP_DIR}}\apache\conf\httpd.conf`

```
# change document root to project's path
DocumentRoot "/path/to/project/src"
<Directory "/path/to/project/src">
    # ...

    # allows mod_rewrite to work (should be enabled by default in XAMPP)
    AllowOverride All

    # ...
</Directory>

# ...

# uncomment this line (should be uncommented by default in XAMPP)
LoadModule rewrite_module modules/mod_rewrite.so
```

## Linux
good luck

# mysql
- import `DO_NOT_USE_IN_PRODUCTION.sql` as `kkard2`
- every password is `12345678`
- admin username is `kkard2`
- there are test accounts `test1`, `test2` & `test3` (banned)

# php
php 8.1 is required (at least that's what my vps is running)

test
