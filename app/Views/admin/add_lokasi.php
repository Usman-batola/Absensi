<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-blue-600">
        <i class="fas fa-plus-circle"></i> Tambah Lokasi Baru
    </h1>

    <form method="POST" class="bg-white p-8 rounded-lg shadow-lg">
        <?= csrf_field() ?>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Nama Lokasi</label>
            <input type="text" name="name" placeholder="Misal: Kantor Pusat, Cabang Jakarta" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Latitude</label>
            <input type="number" name="latitude" step="0.000001" placeholder="-6.200000" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
            <p class="text-xs text-gray-500 mt-1">Misal: -6.200000</p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Longitude</label>
            <input type="number" name="longitude" step="0.000001" placeholder="106.816666"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
            <p class="text-xs text-gray-500 mt-1">Misal: 106.816666</p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Radius (Meter)</label>
            <input type="number" name="radius" min="10" value="100" placeholder="100"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
            <p class="text-xs text-gray-500 mt-1">Jarak maksimal user dari lokasi untuk bisa absen (dalam meter). Default: 100m</p>
        </div>

        <div class="bg-blue-50 border border-blue-200 p-4 rounded mb-6">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle"></i> 
                <strong>Tip:</strong> Anda bisa menggunakan Google Maps untuk mendapatkan koordinat latitude dan longitude. 
                Klik kanan di Google Maps dan pilih lokasi untuk melihat koordinatnya.
            </p>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="/admin/lokasi" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg text-center">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>

    <!-- Info tambahan -->
    <div class="bg-yellow-50 border border-yellow-200 p-4 rounded mt-6">
        <h3 class="font-bold text-yellow-800 mb-2">Cara Mendapatkan Koordinat:</h3>
        <ol class="text-sm text-yellow-800 list-decimal list-inside space-y-1">
            <li>Buka <a href="https://maps.google.com" target="_blank" class="text-blue-600 hover:underline">Google Maps</a></li>
            <li>Temukan lokasi tempat kerja Anda</li>
            <li>Klik kanan pada lokasi tersebut</li>
            <li>Salin koordinat yang muncul (format: latitude, longitude)</li>
            <li>Paste di form ini</li>
        </ol>
    </div>
</div>

<?= $this->endSection() ?>
