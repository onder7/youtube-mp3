<?php
// download.php
header('Content-Type: application/json');
require_once 'MusicManager.php';

try {
    $manager = new MusicManager();

    // İndirme isteği
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
        $result = $manager->downloadMusic($_POST['url']);
        echo json_encode($result);
        exit;
    }

    // Dosya indirme isteği
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $song = $manager->getSongById($id);

        if ($song) {
            $filePath = __DIR__ . '/downloads/' . $song['file_path'];
            
            if (file_exists($filePath)) {
                $manager->incrementDownloadCount($id);
                
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
                header('Content-Length: ' . filesize($filePath));
                
                readfile($filePath);
                exit;
            }
        }
    }

    // Hatalı istek
    echo json_encode([
        'success' => false,
        'error' => 'Geçersiz istek'
    ]);

} 
catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>