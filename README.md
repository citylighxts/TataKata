# TataTAKu: Big Project Kelompok 6 PBKK C 2025

## Deskripsi Program

TataTAKu merupakan website berbasis AI yang membantu pengguna (mahasiswa) dalam menyempurnakan dokumen tugas akhir mereka sesuai dengan kaidah penulisan bahasa Indonesia baku. Dengan teknologi pemrosesan bahasa alami (NLP), TataTAKu mampu memeriksa kata baku, kalimat efektif, tanda baca, imbuhan, serta ejaan pada suatu karya tulis untuk memastikan apakah penulisan sudah sesuai dengan kaidah bahasa Indonesia yang baik dan benar.

Website TataTAKu dirancang agar mudah digunakan oleh seluruh pengguna yang terlibat. Pengguna cukup mendaftar dan login menggunakan akun email yang dimiliki kemudian masuk ke dashboard website untuk input file tugas akhir bertipe PDF. Sistem AI akan langsung memberikan analisis serta saran perbaikan yang detail. Output dari website ini adalah perbandingan dari isi file PDF asli dan hasil penulisan yang sudah diintegrasikan dengan AI. Pengguna dapat mengunduh hasil analisis penulisan tugas akhir oleh AI dengan format `.pdf` ke perangkat.

## How to Run
1. Jalankan instalasi untuk backend dengan command
   ```
   composer install
   ```
   dan instalasi frontend dengan command
   ```
   npm install && npm run build
   ```
   
2. Copy konfigurasi **.env** dengan command terlampir untuk perangkat Linux/macOS
   ```
   cp -n .env.example .env
   ```
   atau command di bawah untuk perangkat Windows
   ```
   Copy-Item .env.example .env
   ```

3. Jalankan command terlampir untuk enkripsi data
   ```
   php artisan key:generate
   ```

4. Jalankan command terlampir untuk ekspor database **mysql** ke sistem backend
   ```
   php artisan migrate:fresh
   ```

5. Jalankan command terlampir pada terminal 1 untuk compile aset frontend
   ```
   php artisan serve
   ```
   
6. Jalankan command terlampir pada terminal 2 untuk mengakses program backend di browser dan AI processing
   ```
   sh docker/entrypoints/run-all-workers.sh
   ```

7. Jika frontend tidak tampil/jalan, jalankan command terlampir pada terminal 3
   ```
   npm run dev
   ```

## Repositori Lama
Link repositori lama: [TataTAKu Lama](https://github.com/salpurn/TataTAKu)
