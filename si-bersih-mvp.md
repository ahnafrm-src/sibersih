# SI-BERSIH — MVP Document
> Sistem Monitoring & Akuntabilitas Kebersihan Pasca-MBG

---

## 1. Gambaran Umum

**SI-BERSIH** adalah aplikasi web internal untuk memantau kebersihan ruang kelas dan menghasilkan akuntabilitas kebersihan per kelas di sekolah. Dibangun dengan Laravel 11, Blade, Tailwind CSS, dan MySQL. Akses untuk siswa/guru (submit laporan) dan admin/guru piket (kelola laporan & verifikasi).

**Latar belakang masalah:**
Berdasarkan wawancara dengan petugas kebersihan (OB), masalah utama adalah siswa yang membuang sampah sembarangan, terutama saat program MBG (sisa buah dan makanan). Akar masalahnya: karena siswa berpindah-pindah ruangan setiap pergantian jam pelajaran, tidak ada pihak yang merasa bertanggung jawab atas kebersihan satu ruangan tertentu, sehingga seluruh beban jatuh ke OB seorang diri.

**Tujuan utama:**
- Mengembalikan rasa tanggung jawab kebersihan ke kelas yang sedang menempati suatu ruangan
- Menyediakan data konkret ke wali kelas untuk menindaklanjuti ke siswa
- Menjaga proses tetap adil lewat mekanisme koreksi manual dan sanggahan

Sistem ini berperan sebagai **penyedia data dan akuntabilitas**, bukan pengganti peran guru dalam menegakkan aturan — keputusan akhir (teguran, tindak lanjut) tetap di tangan manusia.

---

## 2. Stack Teknologi

| Kebutuhan | Teknologi |
|---|---|
| Backend | Laravel 11 |
| Frontend | Blade + Tailwind CSS |
| Database | MySQL |
| Upload foto | Laravel Storage (local disk) |
| Scheduler | Laravel Task Scheduling (hitung skor mingguan) |
| Auth | Laravel Breeze (session-based) |

---

## 3. Struktur Database

### Tabel `users` (bawaan Laravel, disesuaikan)

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigIncrements | Primary Key |
| nama | varchar(100) | Nama pengguna |
| email | varchar(100), unique | Untuk login |
| password | varchar | — |
| role | enum('siswa', 'guru', 'admin') | Peran pengguna |
| kelas_id | foreignId, nullable | FK → kelas.id (khusus siswa) |
| created_at | timestamp | — |
| updated_at | timestamp | — |

### Tabel `kelas`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigIncrements | Primary Key |
| nama_kelas | varchar(50) | Contoh: "X RPL 1" |
| created_at | timestamp | — |
| updated_at | timestamp | — |

### Tabel `ruangan`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigIncrements | Primary Key |
| nama_ruangan | varchar(50) | Contoh: "Ruang 5" |
| created_at | timestamp | — |
| updated_at | timestamp | — |

### Tabel `jadwal_pelajaran`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigIncrements | Primary Key |
| ruangan_id | foreignId | FK → ruangan.id |
| kelas_id | foreignId | FK → kelas.id |
| hari | enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') | Hari berlaku |
| jam_mulai | time | Jam mulai slot |
| jam_selesai | time | Jam selesai slot |
| created_at | timestamp | — |
| updated_at | timestamp | — |

### Tabel `laporan`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigIncrements | Primary Key |
| pelapor_id | foreignId | FK → users.id |
| ruangan_id | foreignId | FK → ruangan.id |
| foto | varchar(255) | Path file foto |
| waktu_lapor | timestamp | Waktu submit (otomatis) |
| kelas_terduga_id | foreignId, nullable | FK → kelas.id (hasil auto-assignment) |
| status | enum('baru','ditindak','selesai','disengketakan') | Default: baru |
| catatan_koreksi | text, nullable | Diisi jika ada override manual |
| created_at | timestamp | — |
| updated_at | timestamp | — |

### Tabel `sanggahan`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigIncrements | Primary Key |
| laporan_id | foreignId | FK → laporan.id |
| diajukan_oleh | foreignId | FK → users.id |
| alasan | text | Alasan sanggahan |
| status_verifikasi | enum('menunggu','diterima','ditolak') | Default: menunggu |
| diverifikasi_oleh | foreignId, nullable | FK → users.id |
| catatan_verifikasi | text, nullable | Catatan hasil verifikasi |
| created_at | timestamp | — |
| updated_at | timestamp | — |

### Tabel `skor_mingguan`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigIncrements | Primary Key |
| kelas_id | foreignId | FK → kelas.id |
| minggu_ke | integer | Minggu ke-berapa dalam tahun ajaran |
| tahun_ajaran | varchar(9) | Contoh: "2026/2027" |
| poin | integer | Default: 100, dikurangi per laporan terverifikasi |
| created_at | timestamp | — |
| updated_at | timestamp | — |

---

## 4. Relasi Antar Model

```
Kelas → hasMany → User (siswa)
Kelas → hasMany → JadwalPelajaran
Kelas → hasMany → Laporan (via kelas_terduga_id)
Kelas → hasMany → SkorMingguan

Ruangan → hasMany → JadwalPelajaran
Ruangan → hasMany → Laporan

User → hasMany → Laporan (sebagai pelapor)
User → hasMany → Sanggahan (sebagai pengaju)
User → hasMany → Sanggahan (sebagai verifikator)

Laporan → belongsTo → User (pelapor)
Laporan → belongsTo → Ruangan
Laporan → belongsTo → Kelas (kelas_terduga)
Laporan → hasOne → Sanggahan

Sanggahan → belongsTo → Laporan
Sanggahan → belongsTo → User (pengaju & verifikator)
```

---

## 5. Halaman & Fitur MVP

### 5.1 Login
- Form email + password
- Redirect ke halaman sesuai role (siswa → form lapor, admin/guru → dashboard)
- Tidak ada registrasi publik

---

### 5.2 Submit Laporan (siswa/guru)
**URL:** `/lapor`

- Form: Foto (upload), Ruangan (dropdown), Catatan (opsional)
- Waktu tercatat otomatis dari server saat submit
- Setelah submit, sistem otomatis mencocokkan `ruangan_id` + waktu ke `jadwal_pelajaran` yang berlaku, mengisi `kelas_terduga_id`
- Tampilkan pesan konfirmasi ke pelapor setelah berhasil terkirim

---

### 5.3 Dashboard Admin/Guru Piket
**URL:** `/dashboard`

Menampilkan ringkasan kondisi kebersihan hari ini:

| Kartu | Isi |
|---|---|
| Laporan baru | Jumlah laporan berstatus "baru" |
| Sedang ditindak | Jumlah laporan berstatus "ditindak" |
| Disengketakan | Jumlah laporan berstatus "disengketakan" |
| Selesai hari ini | Jumlah laporan selesai hari ini |

**Papan status ruangan** — grid ruangan dengan indikator warna status (bersih/menunggu tindak lanjut/disengketakan)

---

### 5.4 Kelola Laporan
**URL:** `/laporan`

**List halaman:**
- Tabel: Foto, Ruangan, Kelas terduga, Waktu lapor, Status, Aksi
- Filter berdasarkan status
- Search berdasarkan ruangan/kelas

**Detail Laporan:**
- Foto, ruangan, waktu, kelas terduga
- Tombol ubah status (baru → ditindak → selesai)
- Tombol koreksi kelas manual (isi `kelas_terduga_id` baru + `catatan_koreksi`)

---

### 5.5 Sanggahan
**URL:** `/sanggahan`

**Ajukan sanggahan** (oleh wali kelas/perwakilan kelas terkait):
- Form: pilih laporan, alasan sanggahan
- Setelah diajukan, status laporan otomatis berubah menjadi "disengketakan"

**Verifikasi sanggahan** (oleh admin/guru piket):
- List sanggahan berstatus "menunggu"
- Tombol: Terima (poin dibatalkan) / Tolak (poin tetap dipotong)
- Form catatan verifikasi

---

### 5.6 Manajemen Jadwal Pelajaran
**URL:** `/jadwal`

- CRUD jadwal: pilih ruangan, kelas, hari, jam mulai, jam selesai
- Diinput oleh admin/TU sekali per semester
- Search/filter berdasarkan ruangan atau kelas

---

### 5.7 Rekap Skor Mingguan
**URL:** `/skor`

- Tabel/bar chart: kelas, poin minggu berjalan
- Filter berdasarkan minggu/tahun ajaran
- Skor dihitung otomatis via scheduler: basis 100 poin, dikurangi 1 poin per laporan berstatus "selesai" atau "ditindak" (bukan "disengketakan" yang ditolak) yang ter-assign ke kelas tersebut dalam minggu itu

---

## 6. Struktur Folder Laravel

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── DashboardController.php
│   │   ├── LaporanController.php
│   │   ├── SanggahanController.php
│   │   ├── JadwalPelajaranController.php
│   │   └── SkorMingguanController.php
│   └── Requests/
│       ├── StoreLaporanRequest.php
│       └── StoreSanggahanRequest.php
├── Models/
│   ├── User.php
│   ├── Kelas.php
│   ├── Ruangan.php
│   ├── JadwalPelajaran.php
│   ├── Laporan.php
│   ├── Sanggahan.php
│   └── SkorMingguan.php
├── Services/
│   └── AutoAssignmentService.php
└── Console/
    └── Commands/
        └── HitungSkorMingguan.php

resources/views/
├── layouts/
│   └── app.blade.php
├── dashboard.blade.php
├── lapor/
│   └── create.blade.php
├── laporan/
│   ├── index.blade.php
│   └── show.blade.php
├── sanggahan/
│   ├── create.blade.php
│   └── index.blade.php
├── jadwal/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── skor/
    └── index.blade.php
```

---

## 7. Routes

```php
// Auth
Route::get('/login', ...)
Route::post('/login', ...)
Route::post('/logout', ...)

// Lapor (siswa/guru)
Route::get('/lapor', [LaporanController::class, 'create'])
Route::post('/lapor', [LaporanController::class, 'store'])

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])

// Laporan (admin/guru piket)
Route::resource('/laporan', LaporanController::class)
    ->only(['index', 'show', 'update'])

// Sanggahan
Route::get('/sanggahan', [SanggahanController::class, 'index'])
Route::post('/sanggahan', [SanggahanController::class, 'store'])
Route::patch('/sanggahan/{sanggahan}/verifikasi', [SanggahanController::class, 'verifikasi'])

// Jadwal Pelajaran
Route::resource('/jadwal', JadwalPelajaranController::class)

// Skor Mingguan
Route::get('/skor', [SkorMingguanController::class, 'index'])
```

Semua route di atas (kecuali `/lapor` untuk siswa) dilindungi middleware `auth` dan dibatasi sesuai `role`.

---

## 8. Urutan Build

Ikuti urutan ini agar setiap tahap langsung bisa ditest:

1. **Setup project** — install Laravel, konfigurasi `.env`, koneksi DB
2. **Migration & Model** — buat semua tabel (`kelas`, `ruangan`, `jadwal_pelajaran`, `laporan`, `sanggahan`, `skor_mingguan`), definisikan relasi antar model
3. **Auth** — install Breeze, sesuaikan view login, tambahkan kolom `role` dan `kelas_id` ke tabel `users`, seed akun siswa/guru/admin
4. **Layout** — buat `layouts/app.blade.php` dengan navbar sesuai role
5. **Manajemen jadwal pelajaran** — CRUD jadwal (harus ada dulu sebelum fitur laporan berfungsi penuh)
6. **Submit laporan** — form upload foto + pilih ruangan, simpan waktu otomatis
7. **Auto-assignment** — buat `AutoAssignmentService` yang mencocokkan `ruangan_id` + waktu laporan ke `jadwal_pelajaran`, isi `kelas_terduga_id`
8. **Kelola laporan** — dashboard admin, list & detail laporan, update status, koreksi manual kelas
9. **Sanggahan** — form ajukan sanggahan, halaman verifikasi oleh admin/guru piket
10. **Skor mingguan** — buat `HitungSkorMingguan` command + scheduler, halaman rekap skor
11. **Polish** — validasi form, konfirmasi aksi, notifikasi sukses/gagal

---

## 9. Catatan Penting

- **OB tidak memiliki akun di sistem** — berdasarkan temuan wawancara bahwa OB jarang memegang HP, sehingga tidak dijadikan pengguna aktif
- **Tidak ada auto-eskalasi bertimer** — status laporan diperbarui manual oleh admin/guru piket untuk mengurangi kompleksitas teknis di tahap awal
- **Tidak ada notifikasi otomatis (WA/Telegram)** — dashboard dicek manual; disebutkan sebagai rencana pengembangan lanjutan
- **Tidak ada rekap area umum terpisah** — seluruh laporan diproses melalui alur kelas berbasis jadwal pelajaran
- Fitur sanggahan sengaja disediakan untuk mengantisipasi penyalahgunaan sistem (misalnya siswa iseng membuang sampah ke ruangan kelas lain lalu melaporkannya) — poin ditahan sementara sampai diverifikasi manusia
- Data foto laporan bersifat sensitif secara sosial (menunjuk kelas tertentu) — pastikan akses dashboard dibatasi hanya untuk admin/guru piket
