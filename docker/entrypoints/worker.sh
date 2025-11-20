set -e

: ${QUEUE_WORKER_OPTS:=--sleep=3 --tries=3 --timeout=900 --memory=512}

echo "Starting Laravel queue worker with options: ${QUEUE_WORKER_OPTS}"

if [ ! -L "public/storage" ]; then
    echo "Storage link not found, creating link..."
    php artisan storage:link
else
    echo "Storage link already exists, skipping."
fi

php artisan queue:work ${QUEUE_WORKER_OPTS}
