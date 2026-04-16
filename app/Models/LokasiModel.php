<?php

namespace App\Models;

use CodeIgniter\Model;

class LokasiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'lokasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'latitude', 'longitude', 'radius'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
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

    public function getLokasiForUser($userId)
    {
        return $this->select('lokasi.*')
                    ->join('lokasi_user', 'lokasi_user.lokasi_id = lokasi.id')
                    ->where('lokasi_user.user_id', $userId)
                    ->findAll();
    }
}
