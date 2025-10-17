#!/bin/bash

ORIGEN="/var/www/mini-framework"

DESTINO="/backups"

FECHA=$(date +'%Y-%m-%d_%H-%M-%S')
ARCHIVO="mini-framework_backup_$FECHA.tar.gz"

echo "=============================="
echo "Iniciando backup: $FECHA"
echo "Origen: $ORIGEN"
echo "Destino: $DESTINO"
echo "=============================="

mkdir -p "$DESTINO"

tar -czf "$DESTINO/$ARCHIVO" "$ORIGEN"

if [ $? -eq 0 ]; then
    echo "Backup completado correctamente."
    echo "Archivo creado: $DESTINO/$ARCHIVO"
else
    echo "Error: no se pudo crear el backup."
    exit 1
fi

find "$DESTINO" -type f -name "mini-framework_backup_*.tar.gz" -mtime +7 -exec rm -f {} \;

echo "Backups antiguos eliminados (mayores a 7 días)."
echo "Proceso finalizado correctamente."

