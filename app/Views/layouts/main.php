<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Aplikasi Absensi' ?> - Absensi App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-gray-50">
    <?= $this->include('layouts/navbar') ?>
    
    <div class="container mx-auto px-4 py-6">
        <?php if (session()->has('success')): ?>
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>

    <?= $this->include('layouts/footer') ?>

    <script>
        // Function untuk mengecek lokasi GPS dengan proteksi anti-fake GPS
        function getLocation() {
            if (navigator.geolocation) {
                // Konfigurasi untuk akurasi tinggi
                const options = {
                    enableHighAccuracy: true, // Wajib untuk meminimalkan Fake GPS
                    timeout: 10000,
                    maximumAge: 0
                };

                navigator.geolocation.getCurrentPosition(showPosition, showError, options);
            } else {
                alert("Geolocation tidak didukung browser Anda");
            }
        }

        function showPosition(position) {
            // Deteksi sederhana Fake GPS
            // 1. Cek navigator.webdriver (sering digunakan bot/spoofing)
            if (navigator.webdriver) {
                console.warn("Automated browser detected");
            }

            // 2. Cek akurasi. Fake GPS sering memberikan akurasi yang terlalu "sempurna" (misal: 0 atau 1)
            // atau sangat buruk. Akurasi 100+ meter biasanya mencurigakan untuk High Accuracy.
            const accuracy = position.coords.accuracy;
            
            if (accuracy > 100) {
                console.warn("Akurasi terlalu rendah, kemungkinan sinyal lemah atau manipulasi.");
            }

            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            
            console.log(`Latitude: ${lat}, Longitude: ${lon}, Accuracy: ${accuracy}m`);
            
            window.userLocation = { 
                latitude: lat, 
                longitude: lon, 
                accuracy: accuracy,
                isMocked: position.mocked || false // Beberapa browser mobile mengirimkan flag ini
            };
        }

        function showError(error) {
            let msg = '';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    msg = "User menolak permintaan Geolocation.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    msg = "Informasi lokasi tidak tersedia.";
                    break;
                case error.TIMEOUT:
                    msg = "Waktu permintaan lokasi habis.";
                    break;
                case error.UNKNOWN_ERROR:
                    msg = "Terjadi kesalahan yang tidak diketahui.";
                    break;
            }
            console.error('Error:', msg);
            // alert('Gagal mendapatkan lokasi: ' + msg);
        }

        // Get location saat halaman load
        document.addEventListener('DOMContentLoaded', getLocation);
    </script>
</body>
</html>
