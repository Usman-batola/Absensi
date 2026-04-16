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
        // Function untuk mengecek lokasi GPS
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation tidak didukung browser Anda");
            }
        }

        function showPosition(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            
            console.log(`Latitude: ${lat}, Longitude: ${lon}`);
            window.userLocation = { latitude: lat, longitude: lon };
        }

        function showError(error) {
            console.error('Error:', error.message);
            alert('Gagal mendapatkan lokasi: ' + error.message);
        }

        // Get location saat halaman load
        document.addEventListener('DOMContentLoaded', getLocation);
    </script>
</body>
</html>
