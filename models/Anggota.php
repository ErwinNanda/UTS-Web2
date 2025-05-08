<?php
namespace Models;

require_once "models/BaseModel.php";

class Anggota extends BaseModel {
    private $table = "anggota";

    // Ambil semua data, bisa dengan pencarian
    public function getAll($search = "") {
        if ($search) {
            $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE nama LIKE ?");
            $stmt->execute(["%$search%"]);
        } else {
            $stmt = $this->db->query("SELECT * FROM $this->table");
        }
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Tambah data anggota
    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO $this->table (nama, alamat) VALUES (?, ?)");
        return $stmt->execute([$data['nama'], $data['alamat']]);
    }

    // Update data anggota
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE $this->table SET nama = ?, alamat = ? WHERE id = ?");
        return $stmt->execute([$data['nama'], $data['alamat'], $id]);
    }

    // Hapus data anggota
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
