<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

$query = "SELECT * FROM instructors"; // Eğitmenler tablosundan tüm verileri çek
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "<h4 class='text-center text-danger'>Veritabanı hatası: " . mysqli_error($conn) . "</h4>";
    exit; // Hata durumunda işlemi durdur
}

if (mysqli_num_rows($result) > 0) {
    echo "<h4>Eğitmenler Listesi</h4>";
    echo "<button class='btn btn-success mb-3' onclick='showAddInstructorForm()'>Eğitmen Ekle</button>"; // Eğitmen Ekle butonu
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>ID</th><th>İsim</th><th>Uzmanlık</th><th>Fotoğraf</th><th>İşlemler</th></tr></thead>";
    echo "<tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['expertise']) . "</td>";
        echo "<td><img src='" . htmlspecialchars($row['photo']) . "' alt='Eğitmen Fotoğrafı' style='width: 50px; height: auto;'></td>";
        echo "<td>
                <button class='btn btn-warning btn-sm' onclick='editInstructor(" . $row['id'] . ")'>Düzenle</button>
                <button class='btn btn-danger btn-sm' onclick='deleteInstructor(" . $row['id'] . ")'>Sil</button>
              </td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<h4 class='text-center text-danger'>Eğitmen bulunamadı.</h4>";
}
?>

<script>
function editInstructor(id) {
    // AJAX ile düzenleme formunu yükle
    $.ajax({
        url: 'edit_instructor.php', // Düzenleme formu için dosya
        method: 'GET',
        data: { id: id },
        success: function(data) {
            $('#content-area').html(data); // İçeriği güncelle
        },
        error: function() {
            $('#content-area').html('<h4 class="text-center text-danger">Düzenleme formu yüklenemedi.</h4>');
        }
    });
}

function deleteInstructor(id) {
    if (confirm('Bu eğitmeni silmek istediğinize emin misiniz?')) {
        $.ajax({
            url: 'delete_instructor.php', // Silme işlemi için dosya
            method: 'POST',
            data: { id: id },
            success: function(response) {
                $('#content-area').html(response); // İçeriği güncelle
            },
            error: function() {
                $('#content-area').html('<h4 class="text-center text-danger">Silme işlemi gerçekleştirilemedi.</h4>');
            }
        });
    }
}

function showAddInstructorForm() {
    const formHtml = `
        <h4>Eğitmen Ekle</h4>
        <form id="addInstructorForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">İsim</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="expertise" class="form-label">Uzmanlık</label>
                <input type="text" class="form-control" id="expertise" name="expertise" required>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Fotoğraf Yükle</label>
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Ekle</button>
            <button type="button" class="btn btn-secondary" onclick="hideAddInstructorForm()">İptal</button>
        </form>
    `;
    $('#content-area').html(formHtml); // Formu içerik alanına ekle

    // Formun gönderilme işlemi
    document.getElementById('addInstructorForm').onsubmit = function(event) {
        event.preventDefault(); // Varsayılan gönderimi engelle
        var formData = new FormData(this);
        $.ajax({
            url: 'add_instructor.php', // Eğitmen ekleme işlemi için dosya
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#content-area').html(response); // İçeriği güncelle
            },
            error: function() {
                $('#content-area').html('<h4 class="text-center text-danger">Eğitmen ekleme işlemi gerçekleştirilemedi.</h4>');
            }
        });
    };
}

function hideAddInstructorForm() {
    loadContent('instructors'); // Eğitmenler listesini tekrar yükle
}
</script>
