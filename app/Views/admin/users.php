<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-blue-600">
        <i class="fas fa-users"></i> Kelola Users
    </h1>
    <a href="/admin/add-user" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
        <i class="fas fa-user-plus"></i> Tambah User Baru
    </a>
</div>

<div class="bg-white rounded-lg shadow-lg overflow-x-auto">
    <table class="w-full">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="px-6 py-3 text-left">No</th>
                <th class="px-6 py-3 text-left">Nama</th>
                <th class="px-6 py-3 text-left">Email</th>
                <th class="px-6 py-3 text-left">Lokasi Kerja</th>
                <th class="px-6 py-3 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-600">
                        <i class="fas fa-inbox"></i> Belum ada user
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $index => $user): ?>
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4"><?= $index + 1 ?></td>
                        <td class="px-6 py-4 font-semibold text-gray-800"><?= $user['name'] ?></td>
                        <td class="px-6 py-4 text-gray-600"><?= $user['email'] ?></td>
                        <td class="px-6 py-4">
                            <?php if ($user['lokasi_name']): ?>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded text-sm">
                                    <i class="fas fa-map-marker-alt"></i> <?= $user['lokasi_name'] ?>
                                </span>
                            <?php else: ?>
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded text-sm italic">
                                    Belum ditentukan
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="/admin/edit-user/<?= $user['id'] ?>" 
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm shadow-sm transition-all hover:scale-105">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="/admin/delete-user/<?= $user['id'] ?>" 
                               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm shadow-sm transition-all hover:scale-105"
                               onclick="return confirm('Yakin ingin menghapus user ini?')">
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
