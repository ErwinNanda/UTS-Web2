<?php
namespace Controllers;

require_once "models/Anggota.php";
use Models\Anggota;

class AnggotaController {
    private $model;

    public function __construct() {
        $this->model = new Anggota();
    }

    // Ambil semua data anggota, bisa dengan pencarian
    public function index($search = "") {
        return $this->model->getAll($search);
    }

    // Tambah data anggota
    public function store($data) {
        return $this->model->insert($data);
    }

    // Update data anggota
    public function update($id, $data) {
        return $this->model->update($id, $data);
    }

    // Hapus data anggota
    public function delete($id) {
        return $this->model->delete($id);
    }
}
