<?php

namespace App\Models;

use CodeIgniter\Model;

class LokasiUserModel extends Model
{
    protected $table            = 'lokasi_user';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'lokasi_id'];

    // Dates
    protected $useTimestamps = false;

    public function getLokasiForUser($userId)
    {
        return $this->where('user_id', $userId)->first();
    }
}
