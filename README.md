ADMIN: fede@gmail.com - rop12345
SSH: http://192.168.1.174/
./mov.sh https://github.com/Daryl786/proyecto.git
.................
RewriteEngine On

# Evitar que se reescriban archivos y directorios que existen físicamente
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# Redirigir todas las peticiones a index.php con el parámetro url
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

# Denegar acceso a archivos sensibles
<FilesMatch "(\.(bak|config|dist|fla|inc|ini|log|psd|sh|sql|swp)|~)$">
    Order allow,deny
    Deny from all
    Satisfy All
</FilesMatch>

# Prevenir listado de directorios
Options -Indexes

# Protección adicional para archivos importantes
<FilesMatch "^(composer\.(json|lock)|\.env|\.git.*)$">
    Order allow,deny
    Deny from all
</FilesMatch>
