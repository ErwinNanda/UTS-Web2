<?php
namespace Models;

use PDO;

class BaseModel {
    protected $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=localhost;dbname=perpustakaan", "root", "");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}