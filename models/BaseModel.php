<?php
namespace Models;
class BaseModel {
    protected $db;
    public function __construct() {
        $this->db = new \PDO("mysql:host=localhost;dbname=perpustakaan", "root", "");
    }
}