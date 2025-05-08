<?php
session_start();

require_once "controllers/BukuController.php";
use Controllers\BukuController;

$controller = new BukuController();

$search = $_GET['search'] ?? '';

if (isset($_GET['hapus'])) {
    $controller->delete($_GET['hapus']);
    header("Location: index.php");
    exit;
}

if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    foreach ($controller->index($search) as $b) {
        if ($b['id'] == $edit_id) {
            $_SESSION['edit'] = $b;
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
    header("Location: index.php");
    exit;
}

$data = $controller->index($search);
$edit = $_SESSION['edit'] ?? null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
    <nav>
  <ul class="navbar">
    <li><a href="index.php">Daftar Buku</a></li>
    <li><a href="anggota.php">Anggota</a></li>
    <li><a href="peminjaman.php">Peminjaman</a></li>
  </ul>
</nav>
</head>
<body>
    <h1>Data Buku</h1>

    <form method="get" style="margin-bottom: 10px;">
        <input type="text" name="search" placeholder="Cari judul/penulis..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Cari</button>
        <?php if ($search): ?>
            <a href="index.php">Reset</a>
        <?php endif; ?>
    </form>

    <form method="post">
        <?php if ($edit): ?>
            <input type="hidden" name="id" value="<?= $edit['id'] ?>">
        <?php endif; ?>
        <input type="text" name="judul" placeholder="Judul" value="<?= $edit['judul'] ?? '' ?>" required>
        <input type="text" name="penulis" placeholder="Penulis" value="<?= $edit['penulis'] ?? '' ?>" required>
        <input type="number" name="tahun" placeholder="Tahun" value="<?= $edit['tahun'] ?? '' ?>" required>
        <button type="submit"><?= $edit ? 'Update' : 'Simpan' ?></button>
    </form>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Tahun</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($data as $i => $b): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($b['judul']) ?></td>
                <td><?= htmlspecialchars($b['penulis']) ?></td>
                <td><?= htmlspecialchars($b['tahun']) ?></td>
                <td>
                    <a href="?edit=<?= $b['id'] ?>&search=<?= urlencode($search) ?>">Edit</a> |
                    <a href="?hapus=<?= $b['id'] ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
