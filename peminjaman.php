<?php
session_start();
require_once "controllers/PeminjamanController.php";
require_once "controllers/BukuController.php";
require_once "controllers/AnggotaController.php";

use Controllers\PeminjamanController;
use Controllers\BukuController;
use Controllers\AnggotaController;

$peminjamanCtrl = new PeminjamanController();
$bukuCtrl = new BukuController();
$anggotaCtrl = new AnggotaController();

$search = $_GET['search'] ?? '';

if (isset($_GET['hapus'])) {
    $peminjamanCtrl->delete($_GET['hapus']);
    header("Location: peminjaman.php");
    exit;
}

if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    foreach ($peminjamanCtrl->index($search) as $p) {
        if ($p['id'] == $edit_id) {
            $_SESSION['edit'] = $p;
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $peminjamanCtrl->update($_POST['id'], $_POST);
    } else {
        $peminjamanCtrl->store($_POST);
    }
    unset($_SESSION['edit']);
    header("Location: peminjaman.php");
    exit;
}

$data = $peminjamanCtrl->index($search);
$edit = $_SESSION['edit'] ?? null;
$bukuList = $bukuCtrl->index();
$anggotaList = $anggotaCtrl->index();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Peminjaman</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
  <ul class="navbar">
    <li><a href="index.php">Daftar Buku</a></li>
    <li><a href="anggota.php">Anggota</a></li>
    <li><a href="peminjaman.php">Peminjaman</a></li>
  </ul>
</nav>

<h1>Data Peminjaman</h1>

<form method="get">
    <input type="text" name="search" placeholder="Cari anggota/buku..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Cari</button>
    <?php if ($search): ?>
        <a href="peminjaman.php">Reset</a>
    <?php endif; ?>
</form>

<form method="post">
    <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <?php endif; ?>
    <select name="anggota_id" required>
        <option value="">-- Pilih Anggota --</option>
        <?php foreach ($anggotaList as $a): ?>
            <option value="<?= $a['id'] ?>" <?= isset($edit['anggota_id']) && $edit['anggota_id'] == $a['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($a['nama']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="buku_id" required>
        <option value="">-- Pilih Buku --</option>
        <?php foreach ($bukuList as $b): ?>
            <option value="<?= $b['id'] ?>" <?= isset($edit['buku_id']) && $edit['buku_id'] == $b['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($b['judul']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="date" name="tanggal_pinjam" value="<?= $edit['tanggal_pinjam'] ?? '' ?>" required>
    <button type="submit"><?= $edit ? 'Update' : 'Simpan' ?></button>
</form>

<table border="1" cellpadding="10" cellspacing="0">
<tr>
    <th>No</th>
    <th>Anggota</th>
    <th>Buku</th>
    <th>Tgl Pinjam</th>
    <th>Aksi</th>
</tr>
<?php foreach ($data as $i => $p): ?>
<tr>
    <td><?= $i + 1 ?></td>
    <td><?= htmlspecialchars($p['nama']) ?></td>
    <td><?= htmlspecialchars($p['judul']) ?></td>
    <td><?= $p['tanggal_pinjam'] ?></td>
    <td>
        <a href="?edit=<?= $p['id'] ?>&search=<?= urlencode($search) ?>">Edit</a> |
        <a href="?hapus=<?= $p['id'] ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
