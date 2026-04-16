# 📖 INSTALLATION & DEPLOYMENT GUIDE

Panduan lengkap untuk installasi, konfigurasi, dan deployment Aplikasi Absensi.

---

## 🎯 Prerequisites Checklist

- [ ] PHP 8.1 atau lebih tinggi
- [ ] MySQL 8.0 atau MariaDB 10.5+
- [ ] Composer installed
- [ ] Git (untuk version control)
- [ ] Modern Web Browser (Chrome, Firefox, Edge, Safari)
- [ ] Domain/Server (untuk production)

### Verify Prerequisites
```bash
# Check PHP version
php --version

# Check Composer
composer --version

# Check MySQL
mysql --version
```

---

## 📦 Step 1: Installation

### Option A: Fresh Installation
```bash
# Navigate to project directory
cd /path/to/project

# The project is already set up with CI4
# Just ensure composer dependencies are installed
composer install
```

### Option B: From Repository
```bash
git clone https://github.com/Usman-batola/Absensi.git
cd Absensi
composer install
```

---

## 🗄️ Step 2: Database Configuration

### 2.1 Create Database
```bash
# Login to MySQL
mysql -u root -p

# In MySQL console:
CREATE DATABASE absensi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 2.2 Update .env File
```bash
# Copy from template
cp .env.example .env

# Edit .env with your database credentials
```

Update these values in `.env`:
```
database.default.hostname = localhost
database.default.database = absensi
database.default.username = root
database.default.password = 123
database.default.port = 3306
```

### 2.3 Verify Connection
```bash
php spark db:show
```

---

## 🔧 Step 3: Database Setup

### 3.1 Run Migrations
```bash
# Run all migrations
php spark migrate --all

# Or step by step (not necessary)
php spark migrate
```

### 3.2 Seed Sample Data (Optional)
```bash
# Populate with sample data for testing
php spark db:seed InitialSeeder

# To reset and reseed:
php spark migrate:refresh --seed
```

---

## ▶️ Step 4: Application Setup

### 4.1 Create Required Directories
```bash
# Create uploads directory if not exists
mkdir -p public/uploads/absensi

# Set permissions
chmod 755 public/uploads/absensi
chmod 755 public/uploads
```

### 4.2 Generate App Key (if needed)
```bash
# CI4 uses app.baseURL from .env, no key generation needed
```

### 4.3 Start Development Server
```bash
# Option 1: Using Built-in Server
php spark serve

# Option 2: Using Apache/Nginx (see section below)
```

**Server akan berjalan di:** `http://localhost:8080`

---

## 🔐 Step 5: Initial Setup

### 5.1 First Time Login
1. Open browser
2. Navigate to `http://localhost:8080`
3. Login dengan default credentials:
   ```
   Email: admin@test.com
   Password: admin123
   ```

### 5.2 Verify Features
- [ ] Login page berfungsi
- [ ] Dashboard admin accessible
- [ ] User list tampil
- [ ] Lokasi list tampil
- [ ] Dapat membuat user baru
- [ ] Dapat membuat lokasi baru
- [ ] User dapat login
- [ ] User dapat akses dashboard
- [ ] Camera permission dialog muncul
- [ ] GPS permission dialog muncul

---

## 🌐 Step 6: Production Deployment

### 6.1 Web Server Configuration

#### Apache Setup
```apache
# In /etc/apache2/sites-available/absensi.conf

<VirtualHost *:80>
    ServerName absensi.example.com
    DocumentRoot /var/www/absensi/public
    
    <Directory /var/www/absensi/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    # Enable mod_rewrite
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteBase /
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php/$1 [L]
    </IfModule>
    
    # Set permissions
    <Directory /var/www/absensi/writable>
        Require all granted
    </Directory>
</VirtualHost>
```

Enable site:
```bash
sudo a2ensite absensi
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Nginx Setup
```nginx
# In /etc/nginx/sites-available/absensi

upstream php {
    server unix:/var/run/php/php8.1-fpm.sock;
}

server {
    listen 80;
    server_name absensi.example.com;
    root /var/www/absensi/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\. {
        deny all;
    }
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/absensi /etc/nginx/sites-enabled/
sudo systemctl restart nginx
```

### 6.2 Environment Configuration
```bash
# Update .env for production
CI_ENVIRONMENT = production
app.baseURL = 'https://absensi.example.com/'
app.forceGlobalSecureRequests = true
database.default.encryption = true

# Optional: Use environment variables instead of .env file
export CI_ENVIRONMENT=production
export DATABASE_DEFAULT_HOSTNAME=localhost
# ... etc
```

### 6.3 Security Setup

#### Enable HTTPS
```bash
# Using Certbot for Let's Encrypt
sudo apt-get install certbot python3-certbot-apache
sudo certbot --apache -d absensi.example.com

# Or for Nginx
sudo apt-get install certbot python3-certbot-nginx
sudo certbot --nginx -d absensi.example.com
```

#### File Permissions
```bash
# Set proper permissions
sudo chown -R www-data:www-data /var/www/absensi
sudo chmod -R 755 /var/www/absensi
sudo chmod -R 777 /var/www/absensi/writable
sudo chmod -R 777 /var/www/absensi/public/uploads
```

#### Firewall Configuration
```bash
# UFW
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable

# Or iptables
sudo iptables -A INPUT -p tcp --dport 80 -j ACCEPT
sudo iptables -A INPUT -p tcp --dport 443 -j ACCEPT
```

### 6.4 Database Optimization
```bash
# Backup before production
mysqldump -u root -p absensi > absensi_backup.sql

# Create indexes (optional but recommended)
mysql -u root -p absensi < /path/to/indexes.sql
```

indexes.sql:
```sql
ALTER TABLE users ADD UNIQUE INDEX idx_email (email);
ALTER TABLE absensi ADD INDEX idx_user_id (user_id);
ALTER TABLE absensi ADD INDEX idx_tanggal (tanggal);
ALTER TABLE absensi ADD INDEX idx_lokasi_id (lokasi_id);
ALTER TABLE lokasi_user ADD INDEX idx_user_id (user_id);
```

### 6.5 Backups & Monitoring

#### Automatic Backups
```bash
# Create backup script
#!/bin/bash
BACKUP_DIR="/backups/absensi"
DATE=$(date +%Y%m%d_%H%M%S)

# Backup database
mysqldump -u root -p123 absensi > $BACKUP_DIR/db_$DATE.sql

# Backup files
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/absensi

# Keep only last 30 days
find $BACKUP_DIR -name "*.sql" -mtime +30 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +30 -delete
```

Add to crontab:
```bash
sudo crontab -e
# Add: 0 2 * * * /usr/local/bin/backup_absensi.sh
```

#### Monitoring
```bash
# Check disk space
df -h

# Check MySQL status
mysqladmin -u root -p status

# Check logs
tail -f /var/log/apache2/error.log
```

---

## 💻 Step 7: Local Development Setup

### 7.1 Development Server
```bash
php spark serve --host 0.0.0.0 --port 8080
```

### 7.2 Database in Docker (Optional)
```dockerfile
# Dockerfile.dev
FROM mysql:8.0
ENV MYSQL_ROOT_PASSWORD=123
ENV MYSQL_DATABASE=absensi
COPY init.sql /docker-entrypoint-initdb.d/
```

Run:
```bash
docker build -f Dockerfile.dev -t absensi-db .
docker run -d -p 3306:3306 absensi-db
```

### 7.3 Hot Reload (Optional)
Install nodemon:
```bash
npm install -g nodemon

# Run with auto-restart
nodemon --exec "php spark serve" --watch app
```

---

## 🧪 Step 8: Testing

### Unit Testing
```bash
# Using PHPUnit (if included)
php spark test

# Or manually
./vendor/bin/phpunit
```

### Functional Testing
Manual checklist:
- [ ] All routes accessible
- [ ] Database operations working
- [ ] File uploads working
- [ ] Camera/GPS requests working
- [ ] Responsive layout on mobile/tablet/desktop
- [ ] Error handling working
- [ ] Session timeout working

---

## 🚀 Step 9: Deployment Checklist

- [ ] .env file configured
- [ ] Database migrated
- [ ] HTTPS enabled
- [ ] File permissions correct
- [ ] Uploads directory writable
- [ ] Database backups set up
- [ ] Logs configured
- [ ] Monitoring active
- [ ] DNS configured
- [ ] Email (if needed) configured
- [ ] CDN configured (optional)

---

## 🔍 Step 10: Post-Deployment

### 10.1 Verify Installation
```bash
# Check server status
php spark serve --version

# Check health
curl -I https://absensi.example.com/

# Check database
php spark db:show
```

### 10.2 Create Admin Account
```bash
# Via CLI (if command available)
php spark make:admin "Admin Name" admin@example.com password

# Or via SQL
INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES ('Admin Name', 'admin@example.com', '$2y$10$...', 'admin', NOW(), NOW());
```

### 10.3 Configure Email (Optional)
Update `.env`:
```
email.fromEmail = noreply@absensi.example.com
email.fromName = "Aplikasi Absensi"
```

### 10.4 Setup Monitoring & Alerts
- Setup uptime monitoring
- Setup error tracking (Sentry, Bugsnag)
- Setup performance monitoring (New Relic)
- Setup log aggregation (ELK Stack)

---

## 🐛 Troubleshooting

### Database Connection Error
```bash
# Check MySQL is running
sudo systemctl status mysql

# Test connection
mysql -u root -p -h localhost -e "SELECT 1;"

# Check .env credentials
grep database.default .env
```

### Upload Directory Permission Error
```bash
# Fix permissions
sudo chmod 775 public/uploads
sudo chown www-data:www-data public/uploads
```

### Camera/GPS Not Working
- Ensure HTTPS (required by browser)
- Check browser permissions
- Test on HTTP localhost (allowed for dev)

### CSS Not Loading
- Clear browser cache
- Check Tailwind CDN connectivity
- If using local CSS, check build status

---

## 📞 Support & Help

For issues or questions:
1. Check documentation in `README_APP.md`
2. Review `QUICKSTART.md` for common issues
3. Check application logs in `writable/logs/`
4. Contact development team

---

**Document Version:** 1.0  
**Last Updated:** April 16, 2024  
**Status:** Production Ready
