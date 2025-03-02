<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

$query = "SELECT * FROM trainings"; // Eğitimler tablosundan tüm verileri çek
$result = mysqli_query($conn, $query);
?>

<h4 class="text-center">Eğitimler</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Başlık</th>
            <th>Açıklama</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td>
                    <a href="edit_training.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Düzenle</a>
                    <a href="delete_training.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Sil</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
