<nav class="bg-blue-600 text-white shadow-lg">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <div class="text-2xl font-bold">
                <i class="fas fa-clock"></i> Absensi App
            </div>
            
            <div class="flex items-center gap-4">
                <?php if (session()->has('isLoggedIn')): ?>
                    <span class="text-sm">
                        Halo, <strong><?= session()->get('user_name') ?></strong>
                        (<?= session()->get('user_role') ?>)
                    </span>
                    <a href="/auth/logout" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded flex items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                <?php else: ?>
                    <a href="/auth/login" class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<?php if (session()->has('isLoggedIn')): ?>
    <div class="bg-blue-500 text-white">
        <div class="container mx-auto px-4">
            <div class="flex gap-4">
                <?php if (session()->get('user_role') === 'admin'): ?>
                    <a href="/admin/dashboard" class="px-4 py-3 hover:bg-blue-600 flex items-center gap-2">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="/admin/users" class="px-4 py-3 hover:bg-blue-600 flex items-center gap-2">
                        <i class="fas fa-users"></i> Users
                    </a>
                    <a href="/admin/lokasi" class="px-4 py-3 hover:bg-blue-600 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt"></i> Lokasi
                    </a>
                    <a href="/admin/absensi" class="px-4 py-3 hover:bg-blue-600 flex items-center gap-2">
                        <i class="fas fa-list"></i> Data Absensi
                    </a>
                <?php else: ?>
                    <a href="/user/dashboard" class="px-4 py-3 hover:bg-blue-600 flex items-center gap-2">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="/user/history" class="px-4 py-3 hover:bg-blue-600 flex items-center gap-2">
                        <i class="fas fa-history"></i> History
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
