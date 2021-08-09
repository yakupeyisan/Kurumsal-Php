<?php

namespace Core\DataAccess\SignedSoftwareFramework;

abstract class RepositoryBase
{
    protected $db;
    public $table = "";
    public $errors = "";
    public $class;
    function __construct($table, $class)
    {
        $this->db = \Config\Database::connect();
        $this->table = $table;
        $this->class = $class;
    }
    public function GetAll($filter = null, int $page = 0, int $limit = 10): array
    {
        $builder = $this->db->table($this->table);
        if ($filter != null) {
            $builder->where($filter);
        }
        $builder->limit($limit, $page * $limit);
        $data = [];
        foreach ($builder->get()->getResult() as $key => $value) {
            $data[] = $this->Mapper($value);
        }
        return [
            "page" => $page,
            "pages" => ceil($builder->countAllResults()/$limit),
            "limit" => $limit,
            "data" => $data,
        ];
    }
    public function Get($filter)
    {
        $builder = $this->db->table($this->table);
        $builder->where($filter);
        $data = [];
        foreach ($builder->get()->getResult() as $key => $value) {
            $data = $this->Mapper($value);
            break;
        }
        return $data;
    }

    public function Add($entity): bool
    {
        unset($entity->Id);
        $entity->CreatedAt=date('Y-m-d H:i:sa');
        return $this->db->table($this->table)->insert((array)$entity);
    }
    public function Update($entity): bool
    {
        $id = $entity->Id;
        unset($entity->Id);
        unset($entity->CreatedAt);
        unset($entity->CreatedUser);
        $entity->UpdatedAt=date('Y-m-d H:i:sa');
        return $this->db->table($this->table)->set((array)$entity)->where("Id", $id)->update();
    }
    public function Delete($Id): bool
    {
        return $this->db->table($this->table)->delete(["Id" => $Id]);
    }
    private function Mapper($data)
    {
        $data = (array) $data;
        $map = new $this->class;
        foreach ($data as $key => $value) {
            try {
                $map->{$key} = $value;
            } catch (\Exception $e) {
                $this->errors[] = $e->getMessage();
            }
        }
        return $map;
    }
}
