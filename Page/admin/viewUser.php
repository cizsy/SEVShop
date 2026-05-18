<?php
require_once '../../config/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

$sql = "SELECT id_user, nama_user, email_user, no_hp FROM user ORDER BY id_user ASC";
$result = $conn->query($sql);

$title = "Data User";
ob_start();
?>

<div class="card">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title fw-semibold mb-0">Data User</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID User</th>
                        <th>Nama User</th>
                        <th>Email</th>
                        <th>No HP</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id_user']; ?></td>

                                <td>
                                    <?= htmlspecialchars($row['nama_user'], ENT_QUOTES); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['email_user'], ENT_QUOTES); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['no_hp'], ENT_QUOTES); ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">
                                Data user masih kosong
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
?>