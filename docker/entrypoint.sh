#!/bin/sh
set -e
cd /var/www/html

if [ -z "$APP_KEY" ]; then
  echo "Falta APP_KEY: la plataforma la entrega en el secreto app-secretos" >&2
  exit 1
fi

echo "Esperando a la base de datos ${DB_HOST}:${DB_PORT}..."
i=0
until php artisan migrate --force --no-interaction; do
  i=$((i + 1))
  if [ "$i" -ge 30 ]; then
    echo "La base de datos no respondió a tiempo" >&2
    exit 1
  fi
  sleep 4
done

php artisan db:seed --class=ProductoSeeder --force --no-interaction
php artisan config:cache
php artisan view:cache
chown -R www-data:www-data storage bootstrap/cache

exec apache2-foreground
