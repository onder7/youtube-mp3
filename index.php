<?php
require_once 'MusicManager.php';
$manager = new MusicManager();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Müzik İndirici ve Arşiv</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- İndirme Formu -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">YouTube'dan MP3 İndir</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" id="downloadForm">
                            <div class="input-group mb-3">
                                <input type="text" name="url" class="form-control" 
                                       placeholder="YouTube URL'si yapıştırın" required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-download"></i> İndir
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- İndirilen Şarkılar Listesi -->
                <div class="card shadow">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Müzik Arşivi</h4>
                        <span class="badge bg-light text-dark">
                            <?php echo count($manager->getDownloadedSongs()); ?> Şarkı
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <?php foreach ($manager->getDownloadedSongs() as $song): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1"><?php echo htmlspecialchars($song['title']); ?></h5>
                                        <small class="text-muted">
                                            İndirilme: <?php echo $song['download_count']; ?> |
                                            Süre: <?php echo $song['duration']; ?> |
                                            Tarih: <?php echo date('d.m.Y H:i', strtotime($song['download_date'])); ?>
                                        </small>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary" 
                                                onclick="showLyrics(<?php echo $song['id']; ?>)">
                                            <i class="bi bi-file-text"></i> Sözler
                                        </button>
                                        <a href="download.php?id=<?php echo $song['id']; ?>" 
                                           class="btn btn-sm btn-success">
                                            <i class="bi bi-download"></i> İndir
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Şarkı Sözleri (Gizli) -->
                                <div id="lyrics-<?php echo $song['id']; ?>" class="mt-3" style="display: none;">
                                    <pre class="bg-light p-3 rounded">
                                        <?php echo htmlspecialchars($song['lyrics_text'] ?? 'Şarkı sözü bulunamadı.'); ?>
                                    </pre>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
document.getElementById('downloadForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const form = e.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const url = form.querySelector('input[name="url"]').value;
    
    // Butonu devre dışı bırak
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="bi bi-hourglass"></i> İndiriliyor...';
    
    try {
        const response = await fetch('download.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `url=${encodeURIComponent(url)}`
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        
        if (result.success) {
            // Başarılı mesajı göster
            alert(result.message || 'İndirme başarılı!');
            // Sayfayı yenile
            location.reload();
        } else {
            alert('Hata: ' + (result.error || 'Bilinmeyen bir hata oluştu'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Bir hata oluştu: ' + error.message);
    } finally {
        // Butonu tekrar aktif et
        submitButton.disabled = false;
        submitButton.innerHTML = '<i class="bi bi-download"></i> İndir';
    }
});

function showLyrics(id) {
    const lyricsDiv = document.getElementById(`lyrics-${id}`);
    if (lyricsDiv) {
        lyricsDiv.style.display = lyricsDiv.style.display === 'none' ? 'block' : 'none';
    }
}
</script>
</body>
</html>