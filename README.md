# SI-BERSIH
**Sistem Monitoring & Akuntabilitas Kebersihan Pasca-MBG**

Aplikasi web internal untuk memantau kebersihan ruang kelas dan menghasilkan akuntabilitas kebersihan per kelas di sekolah. Dibangun sebagai proyek UKK (Ujian Kompetensi Keahlian) program RPL/PPLG.

---

## Latar Belakang

Berdasarkan wawancara dengan petugas kebersihan sekolah, masalah utama yang teridentifikasi adalah siswa yang membuang sampah sembarangan — khususnya saat program MBG (Makan Bergizi Gratis). Akar masalahnya: karena siswa berpindah ruangan setiap pergantian jam, tidak ada pihak yang merasa bertanggung jawab atas kebersihan satu ruangan tertentu, sehingga seluruh beban jatuh ke petugas kebersihan.

SI-BERSIH hadir untuk mengembalikan rasa tanggung jawab itu ke kelas yang sedang menempati suatu ruangan — berdasarkan data jadwal pelajaran.

---

## Fitur Utama

- **Lapor titik kotor** — siapapun (tanpa akun) bisa submit laporan kebersihan dengan foto, nama, dan pilihan ruangan
- **Auto-assignment kelas** — sistem otomatis menentukan kelas penanggung jawab berdasarkan ruangan + waktu laporan yang dicocokkan ke jadwal pelajaran
- **Dashboard admin** — ringkasan laporan harian, papan status ruangan, leaderboard kelas paling kotor & pelapor paling aktif
- **Kelola laporan** — admin dapat mengubah status laporan (`baru` → `ditindak` → `selesai`) dan melakukan koreksi kelas manual
- **Manajemen jadwal pelajaran** — CRUD jadwal per ruangan, kelas, hari, dan jam
- **Rekap skor mingguan** — poin kebersihan per kelas berbasis laporan terverifikasi

---

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 11 |
| Frontend | Blade Templating |
| Database | MySQL |
| ORM | Eloquent |
| Auth | Session-based (custom `AuthController`) |
| PWA | `erag/laravel-pwa` |
| Fonts | IBM Plex Sans, IBM Plex Mono |

---

## Struktur Database

Tujuh tabel utama:

| Tabel | Fungsi |
|---|---|
| `users` | Akun `admin` dan `guru` |
| `kelas` | Data kelas (dengan kolom `tingkat`: 10/11/12) |
| `ruangan` | Data ruangan |
| `jadwal_pelajaran` | Slot jadwal per ruangan, kelas, hari, dan jam |
| `laporan` | Laporan kebersihan beserta status dan kelas terduga |
| `sanggahan` | (Vestigial — fitur sanggahan digantikan koreksi manual admin) |
| `skor_mingguan` | Snapshot skor kebersihan mingguan per kelas |

---

## Instalasi & Setup

### Prasyarat
- PHP 8.2+
- Composer
- MySQL
- Node.js & npm

### Langkah-langkah

```bash
# 1. Clone repo
git clone https://github.com/<username>/si-bersih.git
cd si-bersih

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Salin dan konfigurasi environment
cp .env.example .env
php artisan key:generate

# 4. Atur koneksi database di .env
# DB_DATABASE=sibersih
# DB_USERNAME=root
# DB_PASSWORD=
# APP_TIMEZONE=Asia/Jakarta

# 5. Jalankan migrasi dan seeder
php artisan migrate --seed

# 6. Buat symlink storage
php artisan storage:link

# 7. Jalankan server
php artisan serve
```

---

## Akun Default (Seeder)

| Role | Email | Password |
|---|---|---|
| Admin | admin@sibersih.sch | password |
| Guru | guru@sibersih.sch | password |

> Laporan dapat disubmit secara publik tanpa login melalui `/lapor`.

---

## Struktur Folder Penting

```
app/
├── Http/Controllers/
│   ├── AuthController.php
│   ├── DashboardController.php
│   ├── LaporanController.php
│   ├── JadwalPelajaranController.php
│   └── SkorMingguanController.php
├── Models/
│   ├── Kelas.php
│   ├── Ruangan.php
│   ├── JadwalPelajaran.php
│   ├── Laporan.php
│   └── SkorMingguan.php
└── Services/
    └── AutoAssignmentService.php

resources/views/
├── layouts/app.blade.php
├── dashboard.blade.php
├── lapor/
├── laporan/
├── jadwal/
└── skor/
```

---

## Alur Sistem

```
Pelapor mengisi form lapor (foto + ruangan + nama + kelas)
        ↓
AutoAssignmentService mencocokkan ruangan_id + waktu → jadwal_pelajaran
        ↓
kelas_terduga_id terisi otomatis di tabel laporan
        ↓
Admin mereview laporan di dashboard
        ↓
Admin mengubah status / koreksi kelas manual jika perlu
        ↓
Skor mingguan kelas diperbarui berdasarkan laporan berstatus selesai/ditindak
```

---

## Catatan Pengembangan

- Petugas kebersihan **tidak memiliki akun** di sistem — berdasarkan temuan wawancara
- Tidak ada auto-eskalasi bertimer — status diperbarui manual oleh admin/guru
- Tidak ada notifikasi otomatis (WA/Telegram) di tahap MVP ini
- Timezone wajib diset ke `Asia/Jakarta` di `config/app.php` agar auto-assignment berbasis jam berjalan benar

---

## Lisensi

Proyek ini dibuat untuk keperluan pendidikan (UKK SMK). Tidak untuk penggunaan komersial.
