<?php
namespace Controllers;

require_once "models/Peminjaman.php";
use Models\Peminjaman;

class PeminjamanController {
    private $model;

    public function __construct() {
        $this->model = new Peminjaman();
    }

    // Ambil data peminjaman, dengan atau tanpa pencarian
    public function index($search = "") {
        return $this->model->getAll($search);
    }

    // Tambah data peminjaman
    public function store($data) {
        return $this->model->insert($data);
    }

    // Update data peminjaman
    public function update($id, $data) {
        return $this->model->update($id, $data);
    }

    // Hapus data peminjaman
    public function delete($id) {
        return $this->model->delete($id);
    }
}
