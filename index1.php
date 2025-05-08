<?php
require_once "controllers/BukuController.php";
use Controllers\BukuController;

$bukuCtrl = new BukuController();
$search = $_GET['search'] ?? "";
$buku = $bukuCtrl->index($search);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">    
    <title>Perpustakaan</title>
</head>
<body>
<h1>Daftar Buku</h1>
<nav>
  <ul class="navbar">
    <li><a href="index.php">Daftar Buku</a></li>
    <li><a href="anggota.php">Anggota</a></li>
    <li><a href="peminjaman.php">Peminjaman</a></li>
  </ul>
</nav>

<form method="get">
    <input type="text" name="search" placeholder="Cari buku..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Cari</button>
</form>

<a href="tambah_buku.php">+ Tambah Buku</a>

<table border="1">
<tr>
    <th>No</th>
    <th>Judul</th>
    <th>Penulis</th>
    <th>Tahun</th>
    <th>Aksi</th>
</tr>
<?php foreach ($buku as $i => $b): ?>
<tr>
    <td><?= $i + 1 ?></td>
    <td><?= htmlspecialchars($b['judul']) ?></td>
    <td><?= htmlspecialchars($b['penulis']) ?></td>
    <td><?= htmlspecialchars($b['tahun']) ?></td>
    <td>
        <a href="edit_buku.php?id=<?= $b['id'] ?>">Edit</a> |
        <a href="hapus_buku.php?id=<?= $b['id'] ?>" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
