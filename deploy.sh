#!/usr/bin/env bash
set -euo pipefail

APP_DIR="/var/www/html/optcg"
APP_PORT="${APP_PORT:-8091}"
APP_URL="${APP_URL:-http://localhost:${APP_PORT}}"

cd "$APP_DIR"

echo "[deploy] Actualizando código desde origin/main..."
git pull --ff-only origin main

echo "[deploy] Preparando .env..."
if [ ! -f .env ]; then
    APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
    cat > .env <<EOF
APP_URL=${APP_URL}
APP_PORT=${APP_PORT}
APP_KEY=${APP_KEY}
EOF
    echo "[deploy] .env creado con nueva APP_KEY"
elif ! grep -q '^APP_KEY=.\+' .env; then
    printf 'APP_KEY=base64:%s\n' "$(php -r 'echo base64_encode(random_bytes(32));')" >> .env
    echo "[deploy] APP_KEY añadida al .env existente"
else
    echo "[deploy] .env ya existente"
fi

echo "[deploy] Reconstruyendo y levantando contenedores..."
docker compose up -d --build --pull always

echo "[deploy] Limpiando imágenes antiguas..."
docker image prune -f

echo "[deploy] Despliegue completado."
docker compose ps
