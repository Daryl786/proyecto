ADMIN: fede@gmail.com - rop12345
SSH: http://192.168.1.174/
./mov.sh https://github.com/Daryl786/proyecto.git
.................
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

<FilesMatch "(\.(bak|config|dist|fla|inc|ini|log|psd|sh|sql|swp)|~)$">
    Order allow,deny
    Deny from all
    Satisfy All
</FilesMatch>

Options -Indexes

<FilesMatch "^(composer\.(json|lock)|\.env|\.git.*)$">
    Order allow,deny
    Deny from all
</FilesMatch>
