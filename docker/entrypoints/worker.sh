#!/usr/bin/env sh
# Entrypoint script for running the Laravel queue worker.
# Usage: set QUEUE_WORKER_OPTS env var to override default options.

set -e

: ${QUEUE_WORKER_OPTS:=--sleep=3 --tries=3 --timeout=900 --memory=512}

echo "Starting Laravel queue worker with options: ${QUEUE_WORKER_OPTS}"

# Ensure storage link exists (idempotent)
if [ ! -L "public/storage" ]; then
    echo "Storage link not found, creating link..."
    php artisan storage:link
else
    echo "Storage link already exists, skipping."
fi

# Run the worker
php artisan queue:work ${QUEUE_WORKER_OPTS}
