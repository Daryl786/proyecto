#!/bin/bash

# --- CONFIGURACIÓN ---
REPO_URL="$1"  # URL del repositorio (primer argumento)
TMP_DIR="/tmp/proyecto-main"
WWW_DIR="/var/www"
MYSQL_DIR="/var/lib/mysql"
DB_NAME="proyutu"
SQL_FILE="BD_proyutu.sql"

# --- FUNCIONES ---
function error_exit() {
    echo "Error: $1"
    exit 1
}

# --- VERIFICAR ARGUMENTO ---
if [ -z "$REPO_URL" ]; then
    echo "Uso: $0 <url_del_repositorio_git>"
    exit 1
fi

# --- MOVER mini-framework ---
if [ -d "$TMP_DIR/mini-framework" ]; then
    echo "Moviendo mini-framework a $WWW_DIR..."
    sudo mv "$TMP_DIR/mini-framework" "$WWW_DIR/" || error_exit "No se pudo mover mini-framework."
else
    error_exit "No se encontró la carpeta mini-framework en el repositorio."
fi

# --- MOVER BD_proyutu.sql ---
if [ -f "$TMP_DIR/$SQL_FILE" ]; then
    echo "Moviendo $SQL_FILE a $MYSQL_DIR..."
    sudo mv "$TMP_DIR/$SQL_FILE" "$MYSQL_DIR/" || error_exit "No se pudo mover el archivo SQL."
else
    error_exit "No se encontró $SQL_FILE en el repositorio."
fi

# --- VERIFICAR SI EXISTE LA BASE DE DATOS ---
echo "Verificando base de datos '$DB_NAME'..."
DB_EXISTS=$(mysql -u root -p -e "SHOW DATABASES LIKE '$DB_NAME';" | grep "$DB_NAME")

if [ -z "$DB_EXISTS" ]; then
    echo "Creando base de datos '$DB_NAME'..."
    mysql -u root -p -e "CREATE DATABASE $DB_NAME;" || error_exit "No se pudo crear la base de datos."
else
    echo "La base de datos '$DB_NAME' ya existe."
fi

# --- IMPORTAR BASE DE DATOS ---
echo "Importando base de datos..."
mysql -u root -p "$DB_NAME" < "$MYSQL_DIR/$SQL_FILE" || error_exit "Error al importar la base de datos."

# --- LIMPIEZA ---
echo "Limpiando archivos temporales..."
rm -rf "$TMP_DIR"

echo "Todo listo. mini-framework fue movido a $WWW_DIR y la base de datos '$DB_NAME' fue importada correctamente."

