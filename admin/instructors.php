<?php
include '../db.php'; // Veritabanı bağlantısını dahil et

$query = "SELECT * FROM instructors"; // Eğitmenler tablosundan tüm verileri çek
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "<h4 class='text-center text-danger'>Veritabanı hatası: " . mysqli_error($conn) . "</h4>";
    exit; // Hata durumunda işlemi durdur
}
?>

<style>
    /* Responsive tablo stilleri */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    
    .action-buttons .btn {
        flex: 1;
        min-width: 70px;
    }
    
    @media (max-width: 768px) {
        .hide-on-mobile {
            display: none;
        }
        
        .table-image {
            width: 40px !important;
            height: 40px !important;
            object-fit: cover;
        }
        
        .action-buttons {
            flex-direction: column;
        }
    }
    
    /* Form stilleri */
    #addInstructorForm, #editInstructorForm {
        max-width: 600px;
        margin: 0 auto;
    }
    
    .form-container {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    
    .form-title {
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    
    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    
    @media (max-width: 576px) {
        .form-actions {
            flex-direction: column;
        }
        
        .form-actions .btn {
            margin-bottom: 10px;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Eğitmenler Listesi</h4>
    <button class='btn btn-success' onclick='showAddInstructorForm()'>
        <i class="bi bi-plus-circle me-1"></i> Eğitmen Ekle
    </button>
</div>

<?php
if (mysqli_num_rows($result) > 0) {
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered table-striped'>";
    echo "<thead class='table-dark'><tr>
            <th>ID</th>
            <th>İsim</th>
            <th>Uzmanlık</th>
            <th class='hide-on-mobile'>Profil URL</th>
            <th>Fotoğraf</th>
            <th>İşlemler</th>
          </tr></thead>";
    echo "<tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['expertise']) . "</td>";
        echo "<td class='hide-on-mobile'>" . htmlspecialchars($row['profile_url'] ?? '#') . "</td>";
        echo "<td><img src='" . htmlspecialchars($row['photo']) . "' alt='Eğitmen Fotoğrafı' class='table-image' style='width: 50px; height: 50px; border-radius: 50%; object-fit: cover;'></td>";
        echo "<td>
                <div class='action-buttons'>
                  <button class='btn btn-warning btn-sm' onclick='editInstructor(" . $row['id'] . ")'><i class='bi bi-pencil me-1'></i>Düzenle</button>
                  <button class='btn btn-danger btn-sm' onclick='deleteInstructor(" . $row['id'] . ")'><i class='bi bi-trash me-1'></i>Sil</button>
                </div>
              </td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
    echo "</div>";
} else {
    echo "<div class='alert alert-info'>Henüz eğitmen bulunmamaktadır. Eklemek için 'Eğitmen Ekle' butonunu kullanabilirsiniz.</div>";
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
            $('#content-area').html('<div class="alert alert-danger">Düzenleme formu yüklenemedi.</div>');
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
                $('#content-area').html('<div class="alert alert-danger">Silme işlemi gerçekleştirilemedi.</div>');
            }
        });
    }
}

function showAddInstructorForm() {
    const formHtml = `
        <div class="form-container">
            <h4 class="form-title">Eğitmen Ekle</h4>
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
                    <label for="profile_url" class="form-label">Profil URL'si</label>
                    <input type="url" class="form-control" id="profile_url" name="profile_url" placeholder="https://example.com/profile">
                    <small class="form-text text-muted">"Profili Görüntüle" butonuna tıklandığında açılacak URL'yi girin.</small>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Fotoğraf Yükle</label>
                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i>Ekle</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddInstructorForm()"><i class="bi bi-x-circle me-1"></i>İptal</button>
                </div>
            </form>
        </div>
    `;
    $('#content-area').html(formHtml); // Formu içerik alanına ekle

    // Formun gönderilme işlemi
    document.getElementById('addInstructorForm').onsubmit = function(event) {
        event.preventDefault(); // Varsayılan gönderimi engelle
        var formData = new FormData(this);
        
        // Yükleniyor göstergesi ekle
        $('#content-area').append('<div id="loading" class="text-center mt-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Yükleniyor...</span></div><p>Yükleniyor...</p></div>');
        
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
                $('#content-area').html('<div class="alert alert-danger">Eğitmen ekleme işlemi gerçekleştirilemedi.</div>');
            }
        });
    };
}

function hideAddInstructorForm() {
    loadContent('instructors'); // Eğitmenler listesini tekrar yükle
}
</script>
