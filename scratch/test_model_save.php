<?php
// Load framework
require 'spark';
$lokasiUserModel = new \App\Models\LokasiUserModel();
try {
    $lokasiUserModel->save(['user_id' => 999, 'lokasi_id' => 1]);
    echo "Success!\n";
    // Cleanup
    $lokasiUserModel->where('user_id', 999)->delete();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
