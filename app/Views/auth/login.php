<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-center min-h-[calc(100vh-200px)]">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center mb-8 text-blue-600">
            <i class="fas fa-sign-in-alt"></i> Login
        </h1>



        <form method="POST">
            <?= csrf_field() ?>

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

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                Login
            </button>
        </form>

        <p class="text-center mt-4">
            Belum punya akun? <a href="/auth/register" class="text-blue-600 hover:text-blue-700 font-bold">Daftar di sini</a>
        </p>
    </div>
</div>

<?= $this->endSection() ?>
