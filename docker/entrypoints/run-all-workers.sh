echo "============================================="
echo "Memulai 8 PROSES WORKER..."
echo "============================================="


echo "Starting worker 1 (background)..."
sh docker/entrypoints/worker.sh &

echo "Starting worker 2 (background)..."
sh docker/entrypoints/worker.sh &

echo "Starting worker 3 (background)..."
sh docker/entrypoints/worker.sh &

echo "Starting worker 4 (background)..."
sh docker/entrypoints/worker.sh &

echo "Starting worker 5 (background)..."
sh docker/entrypoints/worker.sh &

echo "Starting worker 6 (background)..."
sh docker/entrypoints/worker.sh &

echo "Starting worker 7 (background)..."
sh docker/entrypoints/worker.sh &

echo "Starting worker 8 (foreground)..."
exec sh docker/entrypoints/worker.sh