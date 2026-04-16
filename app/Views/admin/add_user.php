<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-blue-600">
        <i class="fas fa-user-plus"></i> Tambah User Baru
    </h1>

    <form method="POST" class="bg-white p-8 rounded-lg shadow-lg">
        <?= csrf_field() ?>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
            <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Password</label>
            <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Lokasi Kerja</label>
            <select name="lokasi_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                <option value="">-- Pilih Lokasi --</option>
                <?php foreach ($lokasi as $l): ?>
                    <option value="<?= $l['id'] ?>"><?= $l['name'] ?> (Radius: <?= $l['radius'] ?>m)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="/admin/users" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg text-center">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
