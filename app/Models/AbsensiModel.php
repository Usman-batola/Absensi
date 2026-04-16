<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'absensi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id', 
        'lokasi_id', 
        'tanggal', 
        'jam_datang', 
        'jam_pulang', 
        'foto_datang', 
        'foto_pulang',
        'latitude_datang',
        'longitude_datang',
        'latitude_pulang',
        'longitude_pulang'
    ];

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

    public function getAbsensiByUser($userId, $tanggal = null)
    {
        $builder = $this->where('user_id', $userId);
        
        if ($tanggal) {
            $builder->where('tanggal', $tanggal);
        }
        
        return $builder->findAll();
    }

    public function getTodayAbsensi($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('tanggal', date('Y-m-d'))
                    ->first();
    }

    public function getAllAbsensi($page = 1, $perPage = 20)
    {
        return $this->select('absensi.*, users.name, lokasi.name as lokasi_name')
                    ->join('users', 'users.id = absensi.user_id')
                    ->join('lokasi', 'lokasi.id = absensi.lokasi_id')
                    ->paginate($perPage);
    }

    public function searchAbsensi($keyword, $page = 1, $perPage = 20)
    {
        return $this->select('absensi.*, users.name, lokasi.name as lokasi_name')
                    ->join('users', 'users.id = absensi.user_id')
                    ->join('lokasi', 'lokasi.id = absensi.lokasi_id')
                    ->like('users.name', $keyword)
                    ->paginate($perPage);
    }
}
