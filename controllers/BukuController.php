<?php
namespace Controllers;

require_once "models/Buku.php";

use Models\Buku;

class BukuController {
    private $model;

    public function __construct() {
        $this->model = new Buku();
    }

    public function index($search = "") {
        return $this->model->getAll($search);
    }

    public function store($data) {
        return $this->model->insert($data);
    }

    public function delete($id) {
        return $this->model->delete($id);
    }

    public function update($id, $data) {
        return $this->model->update($id, $data);
    }
}