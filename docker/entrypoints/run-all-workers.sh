#!/usr/bin/env sh
# Skrip ini akan menjalankan worker.sh sebanyak 8 kali.

echo "============================================="
echo "Memulai 8 PROSES WORKER..."
echo "============================================="

# Menjalankan 7 worker di background
# Tanda '&' di akhir berarti "jalankan di background"

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

# Menjalankan worker ke-8 di foreground
# Ini PENTING. Perintah 'exec' akan membuat
# container tetap hidup menggunakan proses ini.

echo "Starting worker 8 (foreground)..."
exec sh docker/entrypoints/worker.sh