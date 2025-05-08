<?php
session_start();

require_once "controllers/AnggotaController.php";
use Controllers\AnggotaController;

$controller = new AnggotaController();
$search = $_GET['search'] ?? '';

if (isset($_GET['hapus'])) {
    $controller->delete($_GET['hapus']);
    header("Location: anggota.php");
    exit;
}

if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    foreach ($controller->index($search) as $a) {
        if ($a['id'] == $edit_id) {
            $_SESSION['edit'] = $a;
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $controller->update($_POST['id'], $_POST);
    } else {
        $controller->store($_POST);
    }
    unset($_SESSION['edit']);
    header("Location: anggota.php");
    exit;
}

$data = $controller->index($search);
$edit = $_SESSION['edit'] ?? null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Anggota</title>
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

<h1>Data Anggota</h1>

<form method="get" style="margin-bottom: 10px;">
    <input type="text" name="search" placeholder="Cari nama/alamat..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Cari</button>
    <?php if ($search): ?>
        <a href="anggota.php">Reset</a>
    <?php endif; ?>
</form>

<form method="post">
    <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <?php endif; ?>
    <input type="text" name="nama" placeholder="Nama" value="<?= $edit['nama'] ?? '' ?>" required>
    <input type="text" name="alamat" placeholder="Alamat" value="<?= $edit['alamat'] ?? '' ?>" required>
    <button type="submit"><?= $edit ? 'Update' : 'Simpan' ?></button>
</form>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($data as $i => $a): ?>
        <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($a['nama']) ?></td>
            <td><?= htmlspecialchars($a['alamat']) ?></td>
            <td>
                <a href="?edit=<?= $a['id'] ?>&search=<?= urlencode($search) ?>">Edit</a> |
                <a href="?hapus=<?= $a['id'] ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
