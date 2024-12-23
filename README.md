# Apache settings

NOTE: This will break all other projects inside `htdocs/`, so backing up
      configuration file is advised.

Linux:
- `/etc/apache2/apache2.conf` (Debian/Ubuntu-based systems)
- `/etc/httpd/conf/httpd.conf` (CentOS/RHEL/Fedora-based systems)

Windows (XAMPP):
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
