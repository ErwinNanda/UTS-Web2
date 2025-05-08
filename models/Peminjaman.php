<?php
namespace Models;

require_once "models/BaseModel.php";

class Peminjaman extends BaseModel {
    private $table = "peminjaman";

    // Ambil semua data peminjaman, dengan relasi ke anggota dan buku
    public function getAll($search = "") {
        $sql = "SELECT p.*, a.nama, b.judul 
                FROM $this->table p
                JOIN anggota a ON p.anggota_id = a.id 
                JOIN buku b ON p.buku_id = b.id";

        if ($search) {
            $sql .= " WHERE a.nama LIKE :search OR b.judul LIKE :search";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['search' => "%$search%"]);
        } else {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Tambah data peminjaman
    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO $this->table (anggota_id, buku_id, tanggal_pinjam) VALUES (?, ?, ?)");
        return $stmt->execute([$data['anggota_id'], $data['buku_id'], $data['tanggal_pinjam']]);
    }

    // Update data peminjaman
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE $this->table SET anggota_id = ?, buku_id = ?, tanggal_pinjam = ? WHERE id = ?");
        return $stmt->execute([$data['anggota_id'], $data['buku_id'], $data['tanggal_pinjam'], $id]);
    }

    // Hapus data peminjaman
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM $this->table WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
