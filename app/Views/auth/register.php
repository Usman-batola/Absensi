<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-center min-h-[calc(100vh-200px)]">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center mb-8 text-blue-600">
            <i class="fas fa-user-plus"></i> Register
        </h1>

        <?php if (session()->has('error')): ?>
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <?= csrf_field() ?>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2" for="name">
                    Nama Lengkap
                </label>
                <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" 
                       type="text" id="name" name="name" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2" for="email">
                    Email
                </label>
                <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" 
                       type="email" id="email" name="email" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2" for="password">
                    Password
                </label>
                <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" 
                       type="password" id="password" name="password" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2" for="confirm_password">
                    Konfirmasi Password
                </label>
                <input class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" 
                       type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                Register
            </button>
        </form>

        <p class="text-center mt-4">
            Sudah punya akun? <a href="/auth/login" class="text-blue-600 hover:text-blue-700 font-bold">Login di sini</a>
        </p>
    </div>
</div>

<?= $this->endSection() ?>
