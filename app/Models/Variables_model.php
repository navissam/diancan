<?php

namespace App\Models;

use CodeIgniter\Model;
use phpDocumentor\Reflection\Types\This;

class Variables_model extends Model
{
    protected $table      = 'variables';
    protected $primaryKey = 'varName';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['varValue'];

    protected $useTimestamps = true;
    protected $createdField  = '';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getValue($key)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where([$this->primaryKey => $key]);
        $result = $builder->get()->getResultArray();
        return $result[0]['varValue'];
    }

    public function getAnnouncement()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('announcement');
        $builder->where('content_id', 'announce');
        $result = $builder->get()->getFirstRow('array');
        return $result;
    }
    public function updateAnnouncement($content)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('announcement');
        $builder->update(['content' => $content]);
        $builder->where('content_id', 'announce');
        return $builder;
    }

    public function cancelAnnouncement()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('announcement');
        $builder->update(['status' => 0]);
        $builder->where('content_id', 'announce');
        return $builder;
    }
    public function publishAnnouncement()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('announcement');
        $builder->update(['status' => 1]);
        $builder->where('content_id', 'announce');
        return $builder;
    }
}
