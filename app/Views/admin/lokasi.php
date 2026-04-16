<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-blue-600">
        <i class="fas fa-map-marker-alt"></i> Kelola Lokasi
    </h1>
    <a href="/admin/add-lokasi" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
        <i class="fas fa-plus"></i> Tambah Lokasi
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (empty($lokasi)): ?>
        <div class="col-span-full bg-white p-8 rounded-lg shadow-lg text-center text-gray-600">
            <i class="fas fa-inbox text-4xl mb-4"></i>
            <p>Belum ada lokasi. Mulai tambahkan lokasi kerja.</p>
        </div>
    <?php else: ?>
        <?php foreach ($lokasi as $l): ?>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-bold text-blue-600 mb-2">
                    <i class="fas fa-map-pin"></i> <?= $l['name'] ?>
                </h3>
                <div class="text-sm text-gray-600 mb-4">
                    <p><strong>Latitude:</strong> <?= number_format($l['latitude'], 6) ?></p>
                    <p><strong>Longitude:</strong> <?= number_format($l['longitude'], 6) ?></p>
                    <p><strong>Radius:</strong> <?= $l['radius'] ?> meter</p>
                </div>
                <div class="flex gap-2">
                    <a href="/admin/edit-lokasi/<?= $l['id'] ?>" 
                       class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-center text-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="/admin/delete-lokasi/<?= $l['id'] ?>" 
                       class="flex-1 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-center text-sm"
                       onclick="return confirm('Yakin ingin menghapus lokasi ini?')">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
