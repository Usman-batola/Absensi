<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-blue-600">
        <i class="fas fa-edit"></i> Edit Lokasi
    </h1>

    <form method="POST" class="bg-white p-8 rounded-lg shadow-lg">
        <?= csrf_field() ?>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Nama Lokasi</label>
            <input type="text" name="name" value="<?= $lokasi['name'] ?>" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Latitude</label>
            <input type="number" name="latitude" step="0.000001" value="<?= $lokasi['latitude'] ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Longitude</label>
            <input type="number" name="longitude" step="0.000001" value="<?= $lokasi['longitude'] ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Radius (Meter)</label>
            <input type="number" name="radius" min="10" value="<?= $lokasi['radius'] ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
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
</div>

<?= $this->endSection() ?>
