# 🚀 QUICKSTART - Aplikasi Absensi

Panduan cepat untuk langsung mulai menggunakan Aplikasi Absensi CI4.

## ⚡ Setup dalam 5 Menit

### 1. Database Setup
```bash
# Login ke MySQL/MariaDB
mysql -u root -p123

# Jalankan di MySQL console:
CREATE DATABASE absensi;
EXIT;
```

### 2. Run Migrations & Seed
```bash
php spark migrate
php spark db:seed InitialSeeder
```

### 3. Start Development Server
```bash
php spark serve
```

**Server akan berjalan di:** `http://localhost:8080`

---

## 🔐 Default Login Credentials

### Admin Account
```
Email: admin@test.com
Password: admin123
Role: Admin
```

### Test User Account 1
```
Email: budi@test.com
Password: user123
Lokasi: Kantor Pusat Jakarta
```

### Test User Account 2
```
Email: ani@test.com
Password: user123
Lokasi: Cabang Bandung
```

---

## 🗺️ Lokasi Test (Default)

### Kantor Pusat Jakarta
- Lat: -6.200000
- Lon: 106.816666
- Radius: 100m

### Cabang Bandung
- Lat: -6.914744
- Lon: 107.609810
- Radius: 150m

### Cabang Surabaya
- Lat: -7.250445
- Lon: 112.768845
- Radius: 150m

---

## ✅ Testing Checklist

- [ ] Login dengan admin@test.com
- [ ] Login dengan budi@test.com
- [ ] Dashboard admin bisa diakses
- [ ] List users tampil
- [ ] List lokasi tampil
- [ ] List absensi tampil
- [ ] User bisa akses dashboard
- [ ] Kamera bisa diakses (Chrome/Firefox)
- [ ] GPS bisa diakses
- [ ] Foto bisa disimpan

---

## 🐛 Common Issues

**Error: "SQLSTATE[HY000]: General error"**
- Pastikan MySQL running
- Jalankan `php spark migrate` lagi

**Error: "View not found"**
- Clear browser cache (Ctrl+Shift+Delete)
- Reload halaman

**Camera tidak bekerja**
- Pastikan menggunakan HTTPS atau localhost
- Izinkan akses camera di browser permission

---

## 📚 Dokumentasi Lengkap

Lihat `README_APP.md` untuk dokumentasi lengkap dan panduan advanced.

---

**Ready to go! 🎉**

Silakan mulai dengan login ke `http://localhost:8080`
