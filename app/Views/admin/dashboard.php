<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1 class="text-3xl font-bold mb-8 text-blue-600">
    <i class="fas fa-chart-line"></i> Admin Dashboard
</h1>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-gradient-to-br from-blue-400 to-blue-600 text-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-blue-100">Total Users</p>
                <p class="text-4xl font-bold"><?= $totalUsers ?></p>
            </div>
            <i class="fas fa-users text-4xl opacity-50"></i>
        </div>
    </div>

    <!-- Total Lokasi -->
    <div class="bg-gradient-to-br from-green-400 to-green-600 text-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-green-100">Total Lokasi</p>
                <p class="text-4xl font-bold"><?= $totalLokasi ?></p>
            </div>
            <i class="fas fa-map-marker-alt text-4xl opacity-50"></i>
        </div>
    </div>

    <!-- Total Absensi -->
    <div class="bg-gradient-to-br from-purple-400 to-purple-600 text-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-purple-100">Total Absensi</p>
                <p class="text-4xl font-bold"><?= $totalAbsensi ?></p>
            </div>
            <i class="fas fa-check-circle text-4xl opacity-50"></i>
        </div>
    </div>

    <!-- Hari Ini -->
    <div class="bg-gradient-to-br from-orange-400 to-orange-600 text-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-orange-100">Hari Ini</p>
                <p class="text-3xl font-bold"><?= date('d M Y') ?></p>
            </div>
            <i class="fas fa-calendar-alt text-4xl opacity-50"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Quick Actions -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold mb-4 text-blue-600">
            <i class="fas fa-bolt"></i> Quick Actions
        </h2>
        <div class="flex flex-col gap-3">
            <a href="/admin/add-user" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-center">
                <i class="fas fa-user-plus"></i> Tambah User
            </a>
            <a href="/admin/add-lokasi" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-center">
                <i class="fas fa-plus"></i> Tambah Lokasi
            </a>
            <a href="/admin/users" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded text-center">
                <i class="fas fa-users"></i> Kelola Users
            </a>
        </div>
    </div>

    <!-- Recent Info -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold mb-4 text-blue-600">
            <i class="fas fa-info-circle"></i> Informasi
        </h2>
        <div class="text-sm text-gray-600">
            <p class="mb-2"><strong>Sistem:</strong> CI4 + Tailwind</p>
            <p class="mb-2"><strong>Database:</strong> MySQL</p>
            <p class="mb-2"><strong>Versi:</strong> 1.0</p>
            <p class="mb-2"><strong>Mode:</strong> Production</p>
        </div>
    </div>

    <!-- Support -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold mb-4 text-blue-600">
            <i class="fas fa-headset"></i> Support
        </h2>
        <p class="text-sm text-gray-600 mb-4">
            Butuh bantuan? Hubungi administrator sistem untuk masalah teknis.
        </p>
        <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm block text-center">
            <i class="fas fa-envelope"></i> Hubungi Support
        </a>
    </div>
</div>

<?= $this->endSection() ?>
