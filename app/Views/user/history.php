<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1 class="text-3xl font-bold mb-6 text-blue-600">History Absensi</h1>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="px-6 py-3 text-left">Tanggal</th>
                <th class="px-6 py-3 text-left">Jam Datang</th>
                <th class="px-6 py-3 text-left">Jam Pulang</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Foto</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($allAbsensi)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-600">
                        <i class="fas fa-inbox"></i> Belum ada data absensi
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($allAbsensi as $row): ?>
                    <tr class="border-b hover:bg-gray-50">
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
                                    <i class="fas fa-times-circle"></i> Belum Absensi
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <?php if ($row['foto_datang']): ?>
                                    <a href="/uploads/absensi/<?= $row['foto_datang'] ?>" target="_blank" 
                                       class="text-blue-600 hover:underline text-sm">
                                        <i class="fas fa-image"></i> Datang
                                    </a>
                                <?php endif; ?>
                                <?php if ($row['foto_pulang']): ?>
                                    <a href="/uploads/absensi/<?= $row['foto_pulang'] ?>" target="_blank"
                                       class="text-blue-600 hover:underline text-sm">
                                        <i class="fas fa-image"></i> Pulang
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
