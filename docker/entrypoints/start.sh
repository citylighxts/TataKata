set -e

if [ -f /var/www/html/artisan ]; then
  php /var/www/html/artisan storage:link || true
fi

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

exec supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
