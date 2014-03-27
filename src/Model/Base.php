<?php
namespace Model;

class Base
{
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }
}
