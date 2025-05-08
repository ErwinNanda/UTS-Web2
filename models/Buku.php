<?php
namespace Models;

require_once "models/BaseModel.php";

class Buku extends BaseModel {
    private $table = "buku";

    public function getAll($search = "") {
        $sql = "SELECT * FROM $this->table";
        if ($search) $sql .= " WHERE judul LIKE ?";
        $stmt = $this->db->prepare($sql);
        $search ? $stmt->execute(["%$search%"]) : $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO $this->table (judul, penulis, tahun) VALUES (?, ?, ?)");
        return $stmt->execute([$data['judul'], $data['penulis'], $data['tahun']]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE $this->table SET judul = ?, penulis = ?, tahun = ? WHERE id = ?");
        return $stmt->execute([$data['judul'], $data['penulis'], $data['tahun'], $id]);
    }
}