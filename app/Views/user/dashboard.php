<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-2 text-blue-600">Status Hari Ini</h2>
        <?php if ($todayAbsensi): ?>
            <p class="text-sm text-gray-600">
                <strong>Jam Datang:</strong> <?= $todayAbsensi['jam_datang'] ?? '-' ?>
            </p>
            <p class="text-sm text-gray-600">
                <strong>Jam Pulang:</strong> <?= $todayAbsensi['jam_pulang'] ?? '-' ?>
            </p>
        <?php else: ?>
            <p class="text-sm text-red-600">Belum ada absensi hari ini</p>
        <?php endif; ?>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-2 text-blue-600">Lokasi Kerja</h2>
        <?php if ($lokasi): ?>
            <p class="text-sm text-gray-600">
                <strong><?= $lokasi['name'] ?? $lokasi['lokasi_id'] ?></strong>
            </p>
            <p class="text-xs text-gray-500">
                Radius: <?= isset($lokasi['radius']) ? $lokasi['radius'] . ' meter' : '-' ?>
            </p>
        <?php else: ?>
            <p class="text-sm text-red-600">Lokasi belum ditentukan admin</p>
        <?php endif; ?>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-2 text-blue-600">Total Absensi</h2>
        <p class="text-3xl font-bold text-blue-600"><?= count($allAbsensi) ?></p>
        <p class="text-sm text-gray-600">kali sebulan</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Absensi Datang -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4 text-green-600">
            <i class="fas fa-arrow-circle-right"></i> Absensi Datang
        </h2>
        
        <?php if (!$todayAbsensi || !$todayAbsensi['jam_datang']): ?>
            <button onclick="startAbsensi('datang')" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-lg mb-4">
                <i class="fas fa-camera"></i> Ambil Foto Datang
            </button>
        <?php else: ?>
            <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded">
                <i class="fas fa-check-circle"></i> Sudah absensi datang jam <?= $todayAbsensi['jam_datang'] ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Absensi Pulang -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4 text-red-600">
            <i class="fas fa-arrow-circle-left"></i> Absensi Pulang
        </h2>
        
        <?php if ($todayAbsensi && !$todayAbsensi['jam_pulang']): ?>
            <button onclick="startAbsensi('pulang')" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-lg mb-4">
                <i class="fas fa-camera"></i> Ambil Foto Pulang
            </button>
        <?php elseif ($todayAbsensi && $todayAbsensi['jam_pulang']): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded">
                <i class="fas fa-check-circle"></i> Sudah absensi pulang jam <?= $todayAbsensi['jam_pulang'] ?>
            </div>
        <?php else: ?>
            <div class="bg-gray-100 border border-gray-400 text-gray-700 p-4 rounded">
                <i class="fas fa-info-circle"></i> Absensi datang dulu terlebih dahulu
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal untuk Camera -->
<div id="cameraModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h2 class="text-xl font-bold mb-4" id="modalTitle">Ambil Foto</h2>
        
        <div class="mb-4">
            <video id="cameraStream" width="100%" height="300" autoplay class="rounded mb-4"></video>
            <input type="hidden" id="canvasData">
        </div>

        <div class="flex gap-2">
            <button onclick="capturePhoto()" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded">
                <i class="fas fa-camera"></i> Ambil Foto
            </button>
            <button onclick="closeCameraModal()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 rounded">
                Batal
            </button>
        </div>

        <canvas id="canvas" class="hidden"></canvas>
        <div id="photoPreview" class="mt-4 hidden">
            <img id="previewImage" src="" class="w-full rounded mb-4">
            <button onclick="submitAbsensi()" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 rounded mb-2">
                <i class="fas fa-check"></i> Kirim Absensi
            </button>
            <button onclick="retakePhoto()" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 rounded">
                <i class="fas fa-redo"></i> Ambil Ulang
            </button>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDummy"></script>
<script>
let currentStream = null;
let currentType = '';
let photoData = null;

function startAbsensi(type) {
    currentType = type;
    document.getElementById('modalTitle').textContent = `Ambil Foto ${type === 'datang' ? 'Datang' : 'Pulang'}`;
    document.getElementById('cameraModal').classList.remove('hidden');
    
    // Check location first
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            checkLocationAndStartCamera(position, type);
        }, function() {
            alert('Gagal mendapatkan lokasi. Pastikan GPS diaktifkan.');
        });
    }
}

function checkLocationAndStartCamera(position, type) {
    const latitude = position.coords.latitude;
    const longitude = position.coords.longitude;

    fetch('/user/check-location', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
            latitude: latitude,
            longitude: longitude
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Lokasi tepat, mulai camera
            startCamera();
        } else {
            alert('⚠️ ' + data.message + '\nJarak: ' + data.distance + 'm\nRadius yang diperlukan: ' + data.requiredRadius + 'm');
            closeCameraModal();
        }
    });
}

function startCamera() {
    navigator.mediaDevices.getUserMedia({ 
        video: { facingMode: 'user' },
        audio: false 
    })
    .then(stream => {
        currentStream = stream;
        document.getElementById('cameraStream').srcObject = stream;
        document.getElementById('photoPreview').classList.add('hidden');
        document.getElementById('cameraStream').classList.remove('hidden');
    })
    .catch(error => {
        alert('Gagal mengakses kamera: ' + error.message);
        console.error(error);
    });
}

function capturePhoto() {
    const video = document.getElementById('cameraStream');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0);
    
    canvas.toBlob(function(blob) {
        const reader = new FileReader();
        reader.onloadend = function() {
            photoData = blob;
            document.getElementById('previewImage').src = reader.result;
            document.getElementById('photoPreview').classList.remove('hidden');
            document.getElementById('cameraStream').classList.add('hidden');
        };
        reader.readAsDataURL(blob);
    });
}

function retakePhoto() {
    photoData = null;
    document.getElementById('photoPreview').classList.add('hidden');
    document.getElementById('cameraStream').classList.remove('hidden');
    startCamera();
}

function closeCameraModal() {
    document.getElementById('cameraModal').classList.add('hidden');
    if (currentStream) {
        currentStream.getTracks().forEach(track => track.stop());
    }
    currentType = '';
    photoData = null;
}

function submitAbsensi() {
    if (!photoData) {
        alert('Ambil foto terlebih dahulu');
        return;
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const formData = new FormData();
            formData.append('type', currentType);
            formData.append('latitude', position.coords.latitude);
            formData.append('longitude', position.coords.longitude);
            formData.append('photo', photoData, 'photo.jpg');

            fetch('/user/save-absensi', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✓ ' + data.message);
                    closeCameraModal();
                    location.reload();
                } else {
                    alert('✗ ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
                console.error(error);
            });
        });
    } else {
        alert('Geolocation tidak didukung');
    }
}
</script>

<?= $this->endSection() ?>
