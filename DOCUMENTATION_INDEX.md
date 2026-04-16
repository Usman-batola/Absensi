# 📚 Aplikasi Absensi - Documentation Index

Dokumentasi lengkap untuk Aplikasi Absensi CI4.

---

## 🚀 Getting Started

Start dengan salah satu dari dokumentasi berikut sesuai kebutuhan:

### Untuk Setup Cepat (5 menit)
👉 **[QUICKSTART.md](QUICKSTART.md)**
- Setup database
- Default login credentials
- Lokasi test
- Quick testing checklist

### Untuk Installation Lengkap
👉 **[INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md)**
- Prerequisites
- Step-by-step installation
- Production deployment
- Server configuration
- Security setup
- Troubleshooting

### Untuk User & Feature Documentation
👉 **[README_APP.md](README_APP.md)**
- Fitur lengkap
- Panduan penggunaan (Admin & User)
- Database structure
- Konfigurasi
- Security notes
- FAQ

---

## 📖 Detailed Documentation

### 1. Project Overview
**File:** [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md)
- Project overview
- Completed features
- File structure
- Technologies used
- Future enhancements

### 2. Tailwind CSS Setup
**File:** [TAILWIND_SETUP.md](TAILWIND_SETUP.md)
- Current CDN setup
- Development mode
- Production optimization
- Tailwind configuration
- Performance tips

### 3. Installation & Deployment
**File:** [INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md)
- Prerequisites checklist
- Step-by-step installation
- Database setup
- Web server configuration (Apache/Nginx)
- Production deployment
- Security configuration
- Backups & monitoring
- Post-deployment checklist

---

## 🎯 Quick Reference

### URLs & Routes
| Feature | URL | Method |
|---------|-----|--------|
| Login | /auth/login | GET/POST |
| Register | /auth/register | GET/POST |
| Admin Dashboard | /admin/dashboard | GET |
| User Dashboard | /user/dashboard | GET |
| Manage Users | /admin/users | GET |
| Manage Lokasi | /admin/lokasi | GET |
| View Absensi | /admin/absensi | GET |
| User History | /user/history | GET |

### Default Accounts (After Seeding)
```
Admin:
  Email: admin@test.com
  Password: admin123

User 1:
  Email: budi@test.com
  Password: user123
  Lokasi: Kantor Pusat Jakarta

User 2:
  Email: ani@test.com
  Password: user123
  Lokasi: Cabang Bandung
```

### Key Files
```
Controllers:      app/Controllers/
Models:          app/Models/
Views:           app/Views/
Database Setup:  app/Database/Migrations/
Routes:          app/Config/Routes.php
Environment:     .env (copy from .env.example)
```

---

## 💡 Common Tasks

### Task: Setup Local Development
```bash
1. Read: QUICKSTART.md
2. Run: php spark migrate
3. Run: php spark db:seed InitialSeeder
4. Run: php spark serve
5. Visit: http://localhost:8080
```

### Task: Deploy to Production
```bash
1. Read: INSTALLATION_GUIDE.md (Step 6)
2. Configure web server (Apache/Nginx)
3. Setup HTTPS/SSL
4. Configure .env for production
5. Run migrations
6. Setup monitoring
```

### Task: Add New User
```bash
1. Login as admin@test.com
2. Go to Users → Add User Baru
3. Fill form & select lokasi
4. Save
```

### Task: Add New Lokasi
```bash
1. Login as admin
2. Go to Lokasi → Add Lokasi
3. Get GPS coordinates from Google Maps
4. Fill form
5. Save
```

### Task: Debug Issues
```bash
Read: INSTALLATION_GUIDE.md (Step 10 - Troubleshooting)
Or check app logs: writable/logs/
```

---

## 🔧 Tech Stack

| Component | Version | Details |
|-----------|---------|---------|
| Framework | CodeIgniter 4.7.2 | Backend framework |
| Database | MySQL 8.0+ | Data storage |
| Frontend | Tailwind CSS | UI framework (via CDN) |
| Icons | Font Awesome 6.4 | Icon library |
| Camera API | HTML5 | Browser API |
| GPS API | Geolocation | Browser API |
| Language | PHP 8.1+ | Server language |

---

## 📱 Browser Compatibility

### Supported Browsers
- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+

### Requirements
- Modern JavaScript support
- Geolocation API
- MediaDevices API (for camera)
- HTML5 Canvas

---

## 🔐 Security features

- ✅ Password hashing (PASSWORD_DEFAULT)
- ✅ Session-based authentication
- ✅ Role-based access control  
- ✅ SQL injection prevention
- ✅ File upload validation
- ✅ CSRF protection ready
- ✅ Secure headers configuration

---

## 📊 Database Tables

**users** - User accounts (admin & regular users)
**lokasi** - Lokasi kerja dengan GPS coordinates
**lokasi_user** - Relasi antara user dengan lokasi
**absensi** - Riwayat absensi dengan foto & GPS

Details: See [README_APP.md](README_APP.md) → Database Structure

---

## 🚀 Features

### Admin Features
- Dashboard dengan statistik
- User management (CRUD)
- Lokasi management (CRUD)
- View semua absensi
- Search & filter absensi

### User Features
- Dashboard dengan status hari ini
- Absensi dengan foto
- GPS validation
- History view
- Datang & Pulang tracking

### Technical Features
- Responsive design
- Real-time GPS validation
- Camera integration
- Haversine formula untuk jarak
- Session management
- Error handling

---

## 🐛 Known Issues & Limitations

### Current Limitations
1. Single lokasi per user (can be enhanced)
2. Manual GPS coordinate input (no map picker)
3. No email notifications
4. No mobile app (web-only)
5. Simple authentication (no OAuth/2FA)

### Future Improvements
- Face recognition
- Multiple lokasi per user
- Advanced reporting
- Mobile app
- Email & SMS notifications
- QR code check-in

---

## 📞 Support Resources

### Dokumentasi
- [README_APP.md](README_APP.md) - Full feature guide
- [QUICKSTART.md](QUICKSTART.md) - Quick setup
- [INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md) - Deploy guide
- [TAILWIND_SETUP.md](TAILWIND_SETUP.md) - CSS guide

### External Resources
- [CodeIgniter 4 Docs](https://codeigniter.com/docs/4/)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [Font Awesome Icons](https://fontawesome.com/docs)
- [MySQL Documentation](https://dev.mysql.com/doc/)

### When Something Goes Wrong
1. Check application logs: `writable/logs/`
2. Check browser console: `F12` → Console tab
3. Read troubleshooting section in [INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md)
4. Contact development team

---

## 📈 Project Information

**Name:** Aplikasi Absensi  
**Version:** 1.0  
**Status:** Production Ready  
**Last Updated:** April 16, 2024  
**License:** Proprietary  

---

## 🎓 Learning Resources

### For PHP/CodeIgniter Developers
- [CodeIgniter 4 Official Guide](https://codeigniter.com/)
- [PHP Documentation](https://www.php.net/manual/)
- Existing code in `/app/Controllers/`, `/app/Models/`

### For Frontend Developers
- [Tailwind CSS Official Docs](https://tailwindcss.com/)
- [Font Awesome Icon Library](https://fontawesome.com/)
- HTML5 APIs documentation

### For DevOps/System Admin
- Web server configuration (Apache/Nginx)
- MySQL database administration
- Linux system administration
- SSL/HTTPS setup

---

## ✅ Checklist untuk Go-Live

- [ ] Read INSTALLATION_GUIDE.md (Production section)
- [ ] Update .env for production
- [ ] Setup HTTPS/SSL
- [ ] Configure web server
- [ ] Setup database backups
- [ ] Setup monitoring & alerts
- [ ] Test all features on production
- [ ] Create admin account
- [ ] Document server configuration
- [ ] Train users
- [ ] Setup support process

---

## 📋 Document Map

```
/Absensi
├──📄 README_APP.md ..................... Main documentation
├── 📄 QUICKSTART.md .................... Quick setup guide
├── 📄 INSTALLATION_GUIDE.md ............ Full installation guide
├── 📄 PROJECT_SUMMARY.md .............. Project overview
├── 📄 TAILWIND_SETUP.md ............... CSS configuration
├── 📄 .env.example .................... Environment template
└── 📄 PROJECT_README.md (this file)... Documentation index
```

---

## 🎉 Next Steps

1. **First Time?** → Read [QUICKSTART.md](QUICKSTART.md)
2. **Setup Locally?** → Follow [INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md) Step 1-4
3. **Deploy to Server?** → Follow [INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md) Step 6
4. **Need Help?** → Check [README_APP.md](README_APP.md) or troubleshooting section

---

**Happy coding! 🚀**

Jika ada pertanyaan, baca dokumentasi terkait atau hubungi tim development.
