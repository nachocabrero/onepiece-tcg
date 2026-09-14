#!/bin/bash

# Script de actualización de One Piece TCG
# Ejecutar: bash update.sh

set -e

echo "=== One Piece TCG Update Script ==="
echo ""

# 1. Actualizar código desde Git
echo "[1/4] Actualizando código desde Git..."
cd /var/www/onepiece-tcg  # Ajustar ruta según servidor
git pull --rebase

# 2. Instalar dependencias
echo "[2/4] Instalando dependencias..."
composer install --no-dev --optimize-autoloader

# 3. Migrar base de datos
echo "[3/4] Ejecutando migraciones..."
php artisan migrate --force

# 4. Ejecutar seeder para OP-17
echo "[4/4] Actualizando catálogo con OP-17..."
php artisan db:seed --class=DatabaseSeeder --force

# 5. Limpiar caché
echo "Limpiando caché..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo ""
echo "=== Actualización completada ==="
echo "Total cartas: $(php artisan tinker --execute="echo App\Models\Card::count();" --quiet)"
echo "Total sets: $(php artisan tinker --execute="echo App\Models\Set::count();" --quiet)"
