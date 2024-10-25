# YouTube MP3 & Lyrics Manager

![Version](https://img.shields.io/badge/versiyon-1.0.0-blue)
![PHP](https://img.shields.io/badge/PHP-7.4+-green)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange)
![License](https://img.shields.io/badge/lisans-MIT-red)

<div align="center">

![YouTube MP3 & Lyrics Manager](images/screenshot.png)

*Müzik ve Şarkı Sözleri Yönetim Sistemi*

</div>

## ⚠️ Önemli Not
> [!WARNING]
> YouTube'dan video indirirken telif hakları konusunda dikkatli olun ve sadece izin verilen içerikleri indirin.

## 📋 Genel Bakış
Bu uygulama, müzik indirme ve şarkı sözleri yönetimi için geliştirilmiş kapsamlı bir sistemdir. YouTube'dan müzik indirme, şarkı sözleri toplama ve müzik dosyası yönetimi özelliklerini tek bir platformda birleştirir.

## ✨ Temel Özellikler
- ✅ YouTube'dan MP3 dönüşümü
- ✅ Otomatik şarkı sözü toplama
- ✅ Müzik dosyası yönetimi
- ✅ Şarkı sözü veritabanı
- ✅ Gelişmiş arama
- ✅ Çoklu dil desteği

## 🚀 Kurulum Adımları

### 1️⃣ Sistem Gereksinimleri
```plaintext
- PHP 7.4+
- MySQL 5.7+
- Apache/Nginx
- FFmpeg
- yt-dlp
```

### 2️⃣ Composer Paketleri
```bash
composer require norkunas/youtube-dl-php
```

### 3️⃣ Gerekli Yazılımların Kurulumu

#### yt-dlp Kurulumu (Windows)
1. [yt-dlp.exe'yi indirin](https://github.com/yt-dlp/yt-dlp/releases)
2. `C:\Windows\System32` klasörüne kopyalayın
3. Kontrol:
```bash
yt-dlp --version
```

#### FFmpeg Kurulumu (Windows)
1. [FFmpeg'i indirin](https://www.gyan.dev/ffmpeg/builds/)
2. Zip'i açın
3. Şu dosyaları `C:\Windows\System32`'ye kopyalayın:
   - ffmpeg.exe
   - ffprobe.exe
   - ffplay.exe

### 4️⃣ Veritabanı Kurulumu

```sql
-- Veritabanı oluşturma
CREATE DATABASE music_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- İndirmeler tablosu
CREATE TABLE downloads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    artist VARCHAR(255),
    youtube_url VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    download_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    file_size INT,
    duration VARCHAR(10),
    download_count INT DEFAULT 0
);

-- Şarkı sözleri tablosu
CREATE TABLE lyrics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    download_id INT,
    lyrics_text TEXT,
    language VARCHAR(50),
    source VARCHAR(255),
    added_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (download_id) REFERENCES downloads(id) ON DELETE CASCADE
);

-- İndeksler
CREATE INDEX idx_youtube_url ON downloads(youtube_url);
CREATE INDEX idx_download_id ON lyrics(download_id);
```

## 📦 Proje Yapısı

```plaintext
youtube-mp3/
├── src/
│   ├── LyricsScraper.php
│   ├── MusicManager.php
│   └── download.php
├── config/
│   ├── database.php
│   └── config.php
├── public/
│   ├── index.php
│   └── assets/
└── templates/
    └── views/
```

## 💻 Kullanım Örnekleri

### Müzik İndirme
```php
$manager = new MusicManager();
$result = $manager->downloadFromYoutube('https://www.youtube.com/watch?v=VIDEO_ID');
```

### Şarkı Sözü Toplama
```php
$scraper = new LyricsScraper();
$lyrics = $scraper->scrapeLyrics($songTitle, $artist);
```

## 🛡️ Güvenlik Önlemleri

> [!IMPORTANT]
> ### Uygulanan Kontroller
> - Dosya boyutu limitleri
> - Mime type kontrolü
> - URL doğrulaması
> - Rate limiting
> - SQL injection koruması
> - XSS koruması

## 🔧 Yapılandırma

### config.php
```php
return [
    'download_path' => '/downloads',
    'max_file_size' => 20 * 1024 * 1024, // 20MB
    'allowed_formats' => ['mp3', 'wav'],
    'rate_limit' => 10 // requests per minute
];
```

## 📊 Veritabanı Şeması

### Downloads Tablosu
| Alan          | Tür      | Açıklama                    |
|---------------|----------|----------------------------|
| id            | INT      | Otomatik artan birincil anahtar |
| title         | VARCHAR  | Şarkı başlığı               |
| artist        | VARCHAR  | Sanatçı adı                 |
| youtube_url   | VARCHAR  | YouTube video URL'si        |

### Lyrics Tablosu
| Alan          | Tür      | Açıklama                    |
|---------------|----------|----------------------------|
| id            | INT      | Otomatik artan birincil anahtar |
| download_id   | INT      | İndirme referansı           |
| lyrics_text   | TEXT     | Şarkı sözleri               |
| language      | VARCHAR  | Dil bilgisi                 |

## 🐛 Sorun Giderme

### Sık Karşılaşılan Hatalar

1. **FFmpeg Hatası**
```bash
# FFmpeg kurulumunu kontrol edin
ffmpeg -version
```

2. **Veritabanı Bağlantı Hatası**
```php
// PDO bağlantısını test edin
try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo $e->getMessage();
}
```

## 📱 İletişim ve Destek
- 📧 E-posta: [onder7@gmail.com]
- 🌐 GitHub: [github.com/onder7]
- 💬 Discord: [discord.gg/musicmanager]

## ⚖️ Lisans
Bu proje MIT lisansı altında lisanslanmıştır.

## 🤝 Katkıda Bulunma
1. Fork edin
2. Feature branch oluşturun
3. Değişikliklerinizi commit edin
4. Branch'inizi push edin
5. Pull Request oluşturun

---

<div align="center">

**..:: Onder Monder ::..**

*Profesyonel IT Çözümleri*

</div>
