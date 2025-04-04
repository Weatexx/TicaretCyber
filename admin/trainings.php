<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

$query = "SELECT * FROM trainings"; // Eğitimler tablosundan tüm verileri çek
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "<h4 class='text-center text-danger'>Veritabanı hatası: " . mysqli_error($conn) . "</h4>";
    exit; // Hata durumunda işlemi durdur
}

echo "<h4>Eğitimler Listesi</h4>";
echo "<button class='btn btn-success mb-3' onclick='showAddTrainingForm()'>Eğitim Ekle</button>"; // Eğitim Ekle butonu

if (mysqli_num_rows($result) > 0) {
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>ID</th><th>Başlık</th><th>Açıklama</th><th>Tarih</th><th>Oluşturulma Tarihi</th><th>Header</th><th>Fotoğraf</th><th>İşlemler</th></tr></thead>";
    echo "<tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . htmlspecialchars(substr($row['description'], 0, 50)) . (strlen($row['description']) > 50 ? '...' : '') . "</td>";
        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
        echo "<td>" . htmlspecialchars($row['header']) . "</td>";
        
        // Fotoğraf görüntüleme kısmı
        if (!empty($row['photo'])) {
            echo "<td><img src='" . htmlspecialchars($row['photo']) . "' alt='Eğitim Fotoğrafı' style='width: 50px; height: auto;'></td>";
        } else {
            echo "<td>Fotoğraf yok</td>";
        }
        
        echo "<td>
                <button class='btn btn-warning btn-sm' onclick='editTraining(" . $row['id'] . ")'>Düzenle</button>
                <button class='btn btn-danger btn-sm' onclick='deleteTraining(" . $row['id'] . ")'>Sil</button>
              </td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<div class='alert alert-info'>Henüz eğitim bulunmamaktadır. Yukarıdaki 'Eğitim Ekle' butonunu kullanarak yeni eğitim ekleyebilirsiniz.</div>";
}
?>

<script>
function editTraining(id) {
    // AJAX ile düzenleme formunu yükle
    $.ajax({
        url: 'edit_training.php', // Düzenleme formu için dosya
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

function deleteTraining(id) {
    if (confirm('Bu eğitimi silmek istediğinize emin misiniz?')) {
        $.ajax({
            url: 'delete_training.php', // Silme işlemi için dosya
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

function showAddTrainingForm() {
    const formHtml = `
        <h4>Eğitim Ekle</h4>
        <form id="addTrainingForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Başlık</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Açıklama</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Tarih</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="header" class="form-label">Header</label>
                <input type="text" class="form-control" id="header" name="header">
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Fotoğraf Yükle</label>
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
                <small class="form-text text-muted">Lütfen JPG, JPEG, PNG veya GIF formatında bir resim seçin.</small>
            </div>
            <button type="submit" class="btn btn-primary">Ekle</button>
            <button type="button" class="btn btn-secondary" onclick="hideAddTrainingForm()">İptal</button>
        </form>
    `;
    $('#content-area').html(formHtml); // Formu içerik alanına ekle

    // Formun gönderilme işlemi
    document.getElementById('addTrainingForm').onsubmit = function(event) {
        event.preventDefault(); // Varsayılan gönderimi engelle
        var formData = new FormData(this);
        
        // Dosya seçilip seçilmediğini kontrol et
        if (document.getElementById('photo').files.length === 0) {
            alert('Lütfen bir fotoğraf seçin.');
            return;
        }
        
        $.ajax({
            url: 'add_training.php', // Eğitim ekleme işlemi için dosya
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#content-area').html(response); // İçeriği güncelle
            },
            error: function() {
                $('#content-area').html('<h4 class="text-center text-danger">Eğitim ekleme işlemi gerçekleştirilemedi.</h4>');
            }
        });
    };
}

function hideAddTrainingForm() {
    loadContent('trainings'); // Eğitimler listesini tekrar yükle
}
</script>
