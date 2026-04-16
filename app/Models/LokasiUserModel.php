<?php

namespace App\Models;

use CodeIgniter\Model;

class LokasiUserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'lokasi_user';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'lokasi_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = null;
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getUsersForLokasi($lokasiId)
    {
        return $this->select('users.*')
                    ->join('users', 'users.id = lokasi_user.user_id')
                    ->where('lokasi_user.lokasi_id', $lokasiId)
                    ->findAll();
    }

    public function getLokasiForUser($userId)
    {
        return $this->where('user_id', $userId)->first();
    }
}
