# Piencarimaba

A simple web application for searching student data from PDDikti with a user-friendly interface. It includes dark mode, search history, and photo preview features.

## Menjalankan secara lokal

Pastikan sudah terpasang PHP. Jalankan server PHP bawaan dari root project:

```bash
php -S localhost:8000
```

Kemudian buka `http://localhost:8000` di browser untuk menggunakan aplikasi.

## Struktur

- `index.html` - Halaman utama aplikasi.
- `api/search.php` - Endpoint pencarian data mahasiswa.
- `api/photo.php` - Endpoint proxy untuk foto mahasiswa.

## Catatan

- Pastikan koneksi internet untuk mengakses API eksternal.
- Fitur pencarian menggunakan data dari PDDikti dan bekerja lebih baik dengan query yang spesifik.
