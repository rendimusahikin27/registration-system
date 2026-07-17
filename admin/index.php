<?php
session_start();
require_once __DIR__ . "/../config.php";

if (empty($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit;
}

$conn = getDbConnection();
$result = $conn->query("SELECT * FROM peserta ORDER BY waktu_daftar DESC");
$total = $result->num_rows;

$acaraCount = $conn->query("SELECT acara, COUNT(*) as jumlah FROM peserta GROUp BY acara ORDER BY jumlah DESC LIMIT 1");
$acaraTop = $acaraCount->num_rows ? $acaraCount->fetch_assoc() : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — Registration System</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="admin-wrap">
        <div class="admin-head">
            <h1>Daftar Peserta</h1>
            <a href="logout.php" class="admin-logout">Keluar</a>
        </div>

        <div class="admin-stats">
            <div class="stat-card">
                <div class="stat-num"><?php echo $total; ?></div>
                <div class="stat-label">Total Pendaftar</div>
            </div>
            <?php if ($acaraTop): ?>
            <div class="stat-card">
                <div class="stat-num"><?php echo $acaraTop["jumlah"]; ?></div>
                <div class="stat-label">Peminat Terbanyak: <?php echo htmlspecialchars($acaraTop["acara"]); ?></div>
            </div>
            <?php endif; ?>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>WhatsApp</th>
                        <th>Acara</th>
                        <th>Catatan</th>
                        <th>Waktu Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($total === 0): ?>
                    <tr>
                        <td colspan="6">Belum ada peserta yang mendaftar.</td>
                    </tr>
                    <?php else: ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row["nama"]); ?></td>
                                <td><?php echo htmlspecialchars($row["email"]); ?></td>
                                <td><?php echo htmlspecialchars($row["whatsapp"]); ?></td>
                                <td><?php echo htmlspecialchars($row["acara"]); ?></td>
                                <td><?php echo htmlspecialchars($row["catatan"]); ?></td>
                                <td><?php echo htmlspecialchars($row["waktu_daftar"]); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>