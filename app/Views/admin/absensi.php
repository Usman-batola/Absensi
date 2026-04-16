<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-blue-600">
        <i class="fas fa-list"></i> Data Absensi
    </h1>
</div>

<!-- Search Bar -->
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" class="flex gap-2">
        <input type="text" name="search" value="<?= $search ?? '' ?>" placeholder="Cari berdasarkan nama user..."
               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
            <i class="fas fa-search"></i> Cari
        </button>
        <a href="/admin/absensi" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
            <i class="fas fa-times"></i> Reset
        </a>
    </form>
</div>

<div class="bg-white rounded-lg shadow-lg overflow-x-auto">
    <table class="w-full">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="px-6 py-3 text-left">No</th>
                <th class="px-6 py-3 text-left">Nama User</th>
                <th class="px-6 py-3 text-left">Lokasi</th>
                <th class="px-6 py-3 text-left">Tanggal</th>
                <th class="px-6 py-3 text-left">Jam Datang</th>
                <th class="px-6 py-3 text-left">Jam Pulang</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Foto</th>
                <th class="px-6 py-3 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($absensi)): ?>
                <tr>
                    <td colspan="9" class="px-6 py-4 text-center text-gray-600">
                        <i class="fas fa-inbox"></i> Belum ada data absensi
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($absensi as $index => $row): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4"><?= $index + 1 ?></td>
                        <td class="px-6 py-4 font-semibold"><?= $row['name'] ?></td>
                        <td class="px-6 py-4"><?= $row['lokasi_name'] ?></td>
                        <td class="px-6 py-4"><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                        <td class="px-6 py-4">
                            <?php if ($row['jam_datang']): ?>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-sm">
                                    <?= $row['jam_datang'] ?>
                                </span>
                            <?php else: ?>
                                <span class="text-gray-500">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ($row['jam_pulang']): ?>
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded text-sm">
                                    <?= $row['jam_pulang'] ?>
                                </span>
                            <?php else: ?>
                                <span class="text-gray-500">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ($row['jam_datang'] && $row['jam_pulang']): ?>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-sm">
                                    <i class="fas fa-check-circle"></i> Lengkap
                                </span>
                            <?php elseif ($row['jam_datang']): ?>
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded text-sm">
                                    <i class="fas fa-clock"></i> Menunggu Pulang
                                </span>
                            <?php else: ?>
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded text-sm">
                                    <i class="fas fa-times-circle"></i> Belum
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <?php if ($row['foto_datang']): ?>
                                    <a href="/uploads/absensi/<?= $row['foto_datang'] ?>" target="_blank" 
                                       class="text-blue-600 hover:text-blue-800 text-sm">
                                        <i class="fas fa-image"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <a href="/admin/delete-absensi/<?= $row['id'] ?>" 
                               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                               onclick="return confirm('Yakin ingin menghapus data absensi ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
