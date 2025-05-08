<?php
require_once "controllers/PeminjamanController.php";
require_once "controllers/AnggotaController.php";
require_once "controllers/BukuController.php";
use Controllers\{PeminjamanController, AnggotaController, BukuController};

$ctrl = new PeminjamanController();
$anggota = (new AnggotaController())->index();
$buku = (new BukuController())->index();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ctrl->store([
        'anggota_id' => $_POST['anggota_id'],
        'buku_id' => $_POST['buku_id'],
        'tanggal_pinjam' => $_POST['tanggal_pinjam']
    ]);
    header("Location: peminjaman.php"); exit;
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css">
<title>Tambah Peminjaman</title></head>
<body>
<h1>Tambah Peminjaman</h1>
<form method="post">
    Anggota:
    <select name="anggota_id">
        <?php foreach ($anggota as $a): ?><option value="<?= $a['id'] ?>"><?= $a['nama'] ?></option><?php endforeach; ?>
    </select><br>
    Buku:
    <select name="buku_id">
        <?php foreach ($buku as $b): ?><option value="<?= $b['id'] ?>"><?= $b['judul'] ?></option><?php endforeach; ?>
    </select><br>
    Tanggal: <input type="date" name="tanggal_pinjam"><br>
    <button type="submit">Simpan</button>
</form></body></html>
