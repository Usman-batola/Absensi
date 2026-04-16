# Aplikasi Absensi - Panduan Setup & Penggunaan

Aplikasi Absensi adalah sistem manajemen absensi modern berbasis **CodeIgniter 4** dengan fitur GPS tracking, kamera, dan dashboard admin yang lengkap.

## 📋 Fitur Utama

✅ **Authentication**
- Login Admin dan User
- Self-register untuk user baru
- Session management

✅ **Admin Features**
- Dashboard dengan statistik
- Kelola Users (Tambah, Edit, Hapus)
- Kelola Lokasi (Tambah, Edit, Hapus)
- Lihat semua data absensi
- Pencarian data absensi berdasarkan nama

✅ **User Features**
- Dashboard dengan status absensi hari ini
- Track lokasi kerja yang ditentukan admin
- Ambil foto menggunakan kamera depan saat absen
- GPS validation (harus di lokasi yang tepat)
- Lihat history absensi lengkap

✅ **Technical**
- Framework: CodeIgniter 4
- Database: MySQL
- UI: Tailwind CSS
- Camera API: HTML5 MediaDevices API
- GPS: Geolocation API

---

## 🚀 Setup & Installation

### Prerequisites
- PHP 8.1+ dengan extension MySQLi
- MySQL 8.0+
- Composer
- Modern Web Browser (Chrome, Firefox, Edge)

### Step 1: Clone Repository
```bash
cd /workspaces/Absensi
```

### Step 2: Setup Database
1. Buat database baru di MySQL:
```sql
CREATE DATABASE absensi;
```

2. Jalankan migrations untuk membuat tables:
```bash
php spark migrate
```

### Step 3: Buat Admin User (Opsional - Manual)
Anda bisa membuat admin user dengan query:
```sql
INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES ('Admin', 'admin@test.com', '$2y$10$...', 'admin', NOW(), NOW());
```

> Password hash bisa dibuat dengan online tools atau menggunakan:
> ```php
> password_hash('password123', PASSWORD_DEFAULT)
> ```

### Step 4: Jalankan Development Server
```bash
php spark serve
```

Server akan berjalan di `http://localhost:8080`

---

## 📖 Panduan Penggunaan

### Login Pertama Kali
1. Untuk Admin:
   - Email: admin@test.com
   - Password: password123

2. Untuk User:
   - Register di halaman registration
   - Login dengan email dan password yang didaftar

### Admin Dashboard

#### 1. **Manage Users**
- Klik menu Users di navbar
- Tambah user baru dengan klik tombol "Tambah User Baru"
- Edit user untuk mengubah data dan assign lokasi
- Hapus user jika sudah tidak diperlukan

#### 2. **Manage Lokasi**
- Klik menu Lokasi di navbar
- Tambah lokasi dengan koordinat GPS (bisa dari Google Maps)
- Set radius sebagai batas jarak user dari lokasi untuk absen
- Edit atau hapus lokasi sesuai kebutuhan

#### 3. **View Absensi**
- Klik menu Data Absensi
- Lihat semua absensi dari seluruh user
- Cari berdasarkan nama user
- Lihat status (Lengkap, Menunggu Pulang, Belum)

### User Dashboard

#### 1. **Absensi Datang**
1. Buka dashboard user
2. Klik tombol "Ambil Foto Datang"
3. Aplikasi akan meminta akses kamera dan GPS
4. Tunggu verifikasi lokasi
5. Jika lokasi tepat, ambil foto
6. Foto akan disimpan sebagai bukti absensi datang

#### 2. **Absensi Pulang**
1. Lakukan hal yang sama dengan absensi datang
2. Klik tombol "Ambil Foto Pulang"
3. Lengkapi proses yang sama

#### 3. **Lihat History**
- Klik menu History di navbar
- Lihat semua riwayat absensi
- Lihat foto yang sudah diambil
- Filter berdasarkan tanggal

---

## 🗄️ Database Structure

### users table
```
id (int, PK)
name (varchar 255)
email (varchar 255, unique)
password (varchar 255)
role (enum: admin, user)
created_at (datetime)
updated_at (datetime)
```

### lokasi table
```
id (int, PK)
name (varchar 255)
latitude (decimal 10,8)
longitude (decimal 11,8)
radius (int) - dalam meter
created_at (datetime)
updated_at (datetime)
```

### lokasi_user table
```
id (int, PK)
user_id (int, FK to users)
lokasi_id (int, FK to lokasi)
created_at (datetime)
```

### absensi table
```
id (int, PK)
user_id (int, FK to users)
lokasi_id (int, FK to lokasi)
tanggal (date)
jam_datang (time, nullable)
jam_pulang (time, nullable)
foto_datang (varchar 255, nullable)
foto_pulang (varchar 255, nullable)
latitude_datang (decimal 10,8, nullable)
longitude_datang (decimal 11,8, nullable)
latitude_pulang (decimal 10,8, nullable)
longitude_pulang (decimal 11,8, nullable)
created_at (datetime)
updated_at (datetime)
```

---

## ⚙️ Konfigurasi

### File: `.env`
```
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
database.default.hostname = localhost
database.default.database = absensi
database.default.username = root
database.default.password = 123
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### File: `app/Config/Routes.php`
Semua routes sudah dikonfigurasi untuk Auth, User, dan Admin.

---

## 🔐 Security Notes

⚠️ **PENTING untuk Production:**
1. Ubah app.baseURL di `.env`
2. Set `CI_ENVIRONMENT = production`
3. Update database credentials
4. Enable CSRF protection (`CSPEnabled = true`)
5. Setup SSL/HTTPS
6. Gunakan password yang kuat untuk database

---

## 📱 Cara Mendapatkan Koordinat GPS

1. Buka **Google Maps**
2. Cari lokasi yang diinginkan
3. Klik kanan pada marker
4. Koordinat akan muncul di bagian atas (format: latitude, longitude)
5. Copy dan paste ke form tambah/edit lokasi

### Contoh:
```
-6.200000, 106.816666
Latitude: -6.200000
Longitude: 106.816666
```

---

## 🐛 Troubleshooting

### Error 404 Page Not Found
- Pastikan file `.htaccess` ada di folder `public`
- Periksa konfigurasi Routes.php
- Clear browser cache dan reload

### Error Database Connection
- Pastikan MySQL running
- Check credentials di `.env`
- Pastikan database `absensi` sudah dibuat
- Run `php spark migrate`

### Camera/GPS Tidak Bekerja
- Gunakan HTTPS (atau localhost untuk development)
- Izinkan akses kamera dan GPS di browser
- Pastikan device memiliki GPS/camera

### Foto Tidak Tersimpan
- Check folder `public/uploads/absensi/` exist
- Pastikan permission folder adalah 755
- Check storage space

---

## 📚 File Structure

```
Absensi/
├── app/
│   ├── Controllers/
│   │   ├── Home.php
│   │   ├── Auth.php
│   │   ├── User.php
│   │   └── Admin.php
│   ├── Models/
│   │   ├── UserModel.php
│   │   ├── LokasiModel.php
│   │   ├── LokasiUserModel.php
│   │   └── AbsensiModel.php
│   ├── Views/
│   │   ├── layouts/
│   │   │   ├── main.php
│   │   │   ├── navbar.php
│   │   │   └── footer.php
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   └── register.php
│   │   ├── user/
│   │   │   ├── dashboard.php
│   │   │   └── history.php
│   │   └── admin/
│   │       ├── dashboard.php
│   │       ├── users.php
│   │       ├── add_user.php
│   │       ├── edit_user.php
│   │       ├── lokasi.php
│   │       ├── add_lokasi.php
│   │       ├── edit_lokasi.php
│   │       └── absensi.php
│   ├── Database/
│   │   └── Migrations/
│   │       ├── 2024-04-16-000001_CreateUsersTable.php
│   │       ├── 2024-04-16-000002_CreateLokasitTable.php
│   │       ├── 2024-04-16-000003_CreateLokasiUserTable.php
│   │       └── 2024-04-16-000004_CreateAbsensiTable.php
│   └── Config/
│       └── Routes.php
├── public/
│   ├── uploads/
│   │   └── absensi/
│   └── index.php
├── .env
└── composer.json
```

---

## 🎯 Next Steps & Optimization

### Features yang bisa ditambahkan:
1. Export absensi ke Excel/PDF
2. Email notification
3. SMS reminder untuk user
4. Dashboard dengan chart analytics
5. Bulk import user
6. Backup database otomatis
7. Mobile app dengan React Native/Flutter
8. Multi-lokasi per user

### Performance optimization:
1. Add database indexing
2. Implement caching
3. Compress images
4. Minify CSS/JS
5. Setup CDN untuk assets

---

## 📞 Support & Contact

Untuk pertanyaan atau bug report, silakan hubungi tim development.

---

## 📄 License

Proprietary - All rights reserved

---

**Version:** 1.0  
**Last Updated:** April 16, 2024  
**Status:** Production Ready
