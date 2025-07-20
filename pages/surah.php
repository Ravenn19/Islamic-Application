<?php
// Error reporting for development (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$page_title = "Al-Qur'an | Al-Huda";

// Validate and sanitize input
$surah_number = isset($_GET['nomor']) ? (int)$_GET['nomor'] : 1;
$surah_number = max(1, min(114, $surah_number)); // Ensure between 1-114

// Juz data for all surahs
$juz_data = [
    1 => [1], 
    2 => [1, 2, 3], 
    3 => [4], 
    4 => [4, 5, 6], 
    5 => [6, 7], 
    6 => [7, 8], 
    7 => [8, 9], 
    8 => [9, 10], 
    9 => [10, 11], 
    10 => [11], 
    11 => [11, 12], 
    12 => [12, 13], 
    13 => [13], 
    14 => [13, 14, 15], 
    15 => [14, 15], 
    16 => [15], 
    17 => [15, 16], 
    18 => [16, 17], 
    19 => [17], 
    20 => [17, 18], 
    21 => [17, 18], 
    22 => [17, 18], 
    23 => [18], 
    24 => [18, 19], 
    25 => [19], 
    26 => [19], 
    27 => [19, 20], 
    28 => [20], 
    29 => [20, 21], 
    30 => [21], 
    31 => [21], 
    32 => [21], 
    33 => [21, 22], 
    34 => [22], 
    35 => [22], 
    36 => [22, 23], 
    37 => [23], 
    38 => [23], 
    39 => [23, 24], 
    40 => [24], 
    41 => [24, 25], 
    42 => [25], 
    43 => [25], 
    44 => [25], 
    45 => [25, 26], 
    46 => [26], 
    47 => [26], 
    48 => [26], 
    49 => [26], 
    50 => [26], 
    51 => [26, 27], 
    52 => [27], 
    53 => [27], 
    54 => [27], 
    55 => [27], 
    56 => [27], 
    57 => [27, 28], 
    58 => [28], 
    59 => [28], 
    60 => [28], 
    61 => [28], 
    62 => [28], 
    63 => [28], 
    64 => [28], 
    65 => [28], 
    66 => [28], 
    67 => [29], 
    68 => [29], 
    69 => [29], 
    70 => [29], 
    71 => [29], 
    72 => [29], 
    73 => [29], 
    74 => [29], 
    75 => [29], 
    76 => [29], 
    77 => [29], 
    78 => [30], 
    79 => [30], 
    80 => [30], 
    81 => [30], 
    82 => [30], 
    83 => [30], 
    84 => [30], 
    85 => [30], 
    86 => [30], 
    87 => [30], 
    88 => [30], 
    89 => [30], 
    90 => [30], 
    91 => [30], 
    92 => [30], 
    93 => [30], 
    94 => [30], 
    95 => [30], 
    96 => [30], 
    97 => [30], 
    98 => [30], 
    99 => [30], 
    100 => [30], 
    101 => [30], 
    102 => [30], 
    103 => [30], 
    104 => [30], 
    105 => [30], 
    106 => [30], 
    107 => [30], 
    108 => [30], 
    109 => [30], 
    110 => [30], 
    111 => [30], 
    112 => [30], 
    113 => [30], 
    114 => [30]
];

// Function to fetch API data with error handling
function fetchApiData($url) {
    $context = stream_context_create([
        'http' => ['timeout' => 5]
    ]);
    
    $response = @file_get_contents($url, false, $context);
    
    if ($response === FALSE) {
        return null;
    }
    
    return json_decode($response, true);
}

// Fetch data from primary API
$surah_data = fetchApiData("https://api.alquran.cloud/v1/surah/$surah_number/ar.alafasy");
$translation_data = fetchApiData("https://api.alquran.cloud/v1/surah/$surah_number/id.indonesian");

// Fallback to secondary API if primary fails
if (!$surah_data || !$translation_data || $surah_data['code'] != 200 || $translation_data['code'] != 200) {
    $surah_data = fetchApiData("https://equran.id/api/surat/$surah_number");
    $ayat_data = fetchApiData("https://equran.id/api/ayat/$surah_number");
    
    if ($surah_data && $ayat_data) {
        $surah_normalized = $surah_data;
        $ayat_normalized = $ayat_data['ayat'] ?? [];
    }
} else {
    // Normalize data from alquran.cloud API
    $surah_info = $surah_data['data'];
    $translation_info = $translation_data['data'];
    
    $surah_normalized = [
        'nama_latin' => $surah_info['englishName'],
        'arti' => $surah_info['englishNameTranslation'],
        'jumlah_ayat' => $surah_info['numberOfAyahs'],
        'tempat_turun' => ucfirst($surah_info['revelationType']),
        'nama' => $surah_info['name'],
        'juz' => $juz_data[$surah_number] ?? []
    ];
    
    $ayat_normalized = [];
    foreach ($surah_info['ayahs'] as $index => $ayah) {
        $translation = $translation_info['ayahs'][$index]['text'] ?? '';
        $ayat_normalized[] = [
            'nomor' => $ayah['numberInSurah'],
            'teks_arab' => $ayah['text'],
            'teks_indonesia' => $translation,
            'audio' => $ayah['audio'] ?? ''
        ];
    }
}

// Handle API failures
if (empty($surah_normalized) || empty($ayat_normalized)) {
    echo '<div class="error-message">
            <h3>Gangguan Sementara</h3>
            <p>Maaf, kami mengalami kesalahan saat mengambil data. Silakan coba beberapa saat lagi.</p>
            <a href="alquran.php" class="btn">Kembali ke Daftar Surah</a>
          </div>';
    include 'includes/footer.php';
    exit;
}

// Handle juz data
$juz_display = !empty($surah_normalized['juz']) ? implode(', ', array_unique($surah_normalized['juz'])) : 'Tidak tersedia';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #4ca1af;
            --accent: #e74c3c;
            --light: #f8f9fa;
            --dark: #343a40;
            --text: #333;
            --text-light: #6c757d;
            --gold: #f1c40f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .surah-detail {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .surah-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .surah-header::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .surah-header::after {
            content: "";
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 100px;
            height: 100px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .surah-title {
            font-size: 2.2rem;
            font-weight: 600;
            z-index: 1;
        }

        .surah-translation {
            font-style: italic;
            margin: 5px 0 15px;
            font-weight: 300;
            position: relative;
            z-index: 1;
        }

        .surah-meta {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            background: rgba(255,255,255,0.2);
            padding: 5px 12px;
            border-radius: 20px;
            backdrop-filter: blur(5px);
        }

        .surah-arabic-title {
            font-size: 3rem;
            margin-top: 50px;
            font-family: 'Amiri', serif;
            color: white;
            text-shadow: 0 2px 5px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
            word-wrap: break-word;
        }

        .bismillah {
            text-align: center;
            font-size: 2.5rem;
            margin: 30px 0;
            font-family: 'Amiri', serif;
            color: var(--primary);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .ayat-container {
            margin-top: 30px;
        }

        .ayat-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 25px;
            margin-bottom: 25px;
            position: relative;
            transition: transform 0.3s, box-shadow 0.3s;
            border-left: 5px solid var(--secondary);
        }

        .ayat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .ayat-number {
            position: absolute;
            left: -15px;
            top: -15px;
            background: var(--secondary);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }

        .arabic-text {
            font-size: 2rem;
            text-align: right;
            font-family: 'Amiri', serif;
            line-height: 2;
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border-right: 3px solid var(--gold);
            direction: rtl;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .translation {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text);
            margin: 20px 0;
            padding-left: 15px;
            border-left: 3px solid var(--secondary);
        }

        .ayat-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 15px;
            border-top: 1px dashed #eee;
            padding-top: 15px;
        }

        .play-ayat, .bookmark-ayat, .copy-ayat {
            background: var(--primary);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .play-ayat:hover, .bookmark-ayat:hover, .copy-ayat:hover {
            background: var(--secondary);
            transform: scale(1.1);
        }

        .surah-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .nav-button {
            padding: 12px 25px;
            background: var(--primary);
            color: white;
            border-radius: 30px;
            text-decoration: none;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .nav-button:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .audio-player {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--primary);
            color: white;
            padding: 15px 20px;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.2);
            transform: translateY(100%);
            transition: transform 0.3s;
            z-index: 1000;
        }

        .audio-player.active {
            transform: translateY(0);
        }

        .player-controls {
            display: flex;
            align-items: center;
            max-width: 800px;
            margin: 0 auto;
            gap: 20px;
        }

        #play-pause-btn {
            background: var(--accent);
            border: none;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s;
        }

        #play-pause-btn:hover {
            transform: scale(1.1);
        }

        .progress-container {
            flex-grow: 1;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        #progress-bar {
            flex-grow: 1;
            height: 6px;
            cursor: pointer;
            -webkit-appearance: none;
            appearance: none;
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
            outline: none;
        }

        #progress-bar::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 15px;
            height: 15px;
            background: var(--accent);
            border-radius: 50%;
            cursor: pointer;
        }

        .time-display {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.8);
            min-width: 40px;
            text-align: center;
        }

        .surah-info {
            margin-left: 15px;
            font-size: 0.95rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .no-ayat {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .no-ayat i {
            font-size: 2rem;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .no-ayat p {
            color: var(--text-light);
        }

        @media (max-width: 768px) {
            .surah-header {
                padding: 20px 15px;
            }
            
            .surah-title {
                font-size: 2rem;
            }
            
            .surah-arabic-title {
                font-size: 2.5rem;
            }
            
            .bismillah {
                font-size: 2rem;
                padding: 15px;
            }
            
            .arabic-text {
                font-size: 1.8rem;
                padding: 10px;
            }
            
            .player-controls {
                gap: 10px;
            }
            
            .surah-info {
                display: none;
            }
            
            .surah-meta {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
        }

        /* Animation for ayat cards */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .ayat-card {
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
        }

        /* Delay animations for each card */
        .ayat-card:nth-child(1) { animation-delay: 0.1s; }
        .ayat-card:nth-child(2) { animation-delay: 0.2s; }
        .ayat-card:nth-child(3) { animation-delay: 0.3s; }
        /* Continue as needed... */
    </style>
</head>
<body>
    <section class="surah-detail">
        <div class="surah-header">
            <div class="surah-info" style="max-width:1000px; display: flex; flex-direction: column;
            justify-content: center;">
                <h1 class="surah-title"><?= htmlspecialchars($surah_normalized['nama_latin']) ?></h1>
                <p class="surah-translation"><?= htmlspecialchars($surah_normalized['arti']) ?></p>
                <div class="surah-meta">
                    <span class="meta-item"><i class="fas fa-list-ol"></i> <?= $surah_normalized['jumlah_ayat'] ?> Ayat</span>
                    <span class="meta-item"><i class="fas fa-map-marker-alt"></i> <?= $surah_normalized['tempat_turun'] ?></span>
                    <span class="meta-item"><i class="fas fa-quran"></i> Juz <?= $juz_display ?></span>
                </div>
            </div>
            <div class="surah-arabic-title">
                <p><?= htmlspecialchars($surah_normalized['nama']) ?></p>
            </div>
        </div>

        <div class="bismillah">
            <p>بِسْمِ ٱللَّهِ ٱلرَّحْمَـٰنِ ٱلرَّحِيمِ</p>
        </div>

        <div class="ayat-container">
            <?php if (empty($ayat_normalized)): ?>
                <div class="no-ayat">
                    <i class="fas fa-info-circle"></i>
                    <p>Data ayat tidak tersedia saat ini</p>
                </div>
            <?php else: ?>
                <?php foreach ($ayat_normalized as $ayat): ?>
                    <div class="ayat-card" id="ayat-<?= $ayat['nomor'] ?>">
                        <div class="ayat-number">
                            <span><?= $ayat['nomor'] ?></span>
                        </div>
                        <div class="ayat-content">
                            <p class="arabic-text"><?= $ayat['teks_arab'] ?></p>
                            <?php if (!empty($ayat['teks_indonesia'])): ?>
                                <p class="translation"><?= htmlspecialchars($ayat['teks_indonesia']) ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="ayat-actions">
                            <?php if (!empty($ayat['audio'])): ?>
                                <button class="play-ayat" data-surah="<?= $surah_number ?>" data-ayat="<?= $ayat['nomor'] ?>" data-audio="<?= htmlspecialchars($ayat['audio']) ?>">
                                    <i class="fas fa-play"></i>
                                </button>
                            <?php endif; ?>
                            <button class="bookmark-ayat" data-surah="<?= $surah_number ?>" data-ayat="<?= $ayat['nomor'] ?>">
                                <i class="far fa-bookmark"></i>
                            </button>
                            <button class="copy-ayat" data-text="<?= htmlspecialchars($ayat['teks_arab'] . ' - ' . $ayat['teks_indonesia']) ?>">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="surah-navigation">
            <?php if ($surah_number > 1): ?>
                <a href="surah.php?nomor=<?= $surah_number - 1 ?>" class="nav-button prev">
                    <i class="fas fa-arrow-left"></i> Surah Sebelumnya
                </a>
            <?php endif; ?>
            
            <?php if ($surah_number < 114): ?>
                <a href="surah.php?nomor=<?= $surah_number + 1 ?>" class="nav-button next">
                    Surah Berikutnya <i class="fas fa-arrow-right"></i>
                </a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Audio Player -->
    <div class="audio-player" id="audio-player">
        <audio id="audio-element"></audio>
        <div class="player-controls">
            <button id="play-pause-btn"><i class="fas fa-play"></i></button>
            <div class="progress-container">
                <span class="time-display" id="current-time">0:00</span>
                <input type="range" id="progress-bar" value="0">
                <span class="time-display" id="duration">0:00</span>
            </div>
            <div class="surah-info">
                <span id="now-playing"></span>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const audioElement = document.getElementById('audio-element');
        const audioPlayer = document.getElementById('audio-player');
        const playPauseBtn = document.getElementById('play-pause-btn');
        const progressBar = document.getElementById('progress-bar');
        const currentTimeEl = document.getElementById('current-time');
        const durationEl = document.getElementById('duration');
        const nowPlayingEl = document.getElementById('now-playing');
        
        // Show audio player when an ayah is played
        function showAudioPlayer() {
            audioPlayer.classList.add('active');
        }
        
        // Hide audio player
        function hideAudioPlayer() {
            audioPlayer.classList.remove('active');
        }
        
        // Play specific ayah
        document.querySelectorAll('.play-ayat').forEach(btn => {
            btn.addEventListener('click', function() {
                const audioUrl = this.dataset.audio;
                const surahName = '<?= htmlspecialchars($surah_normalized['nama_latin']) ?>';
                const ayahNumber = this.dataset.ayat;
                
                if (audioUrl) {
                    showAudioPlayer();
                    audioElement.src = audioUrl;
                    nowPlayingEl.textContent = `Surah ${surahName} - Ayat ${ayahNumber}`;
                    
                    audioElement.play()
                        .then(() => {
                            playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
                        })
                        .catch(error => {
                            console.error('Error playing audio:', error);
                            alert('Tidak dapat memutar audio. Silakan coba lagi.');
                        });
                }
            });
        });
        
        // Update progress bar
        audioElement.addEventListener('timeupdate', function() {
            const currentTime = audioElement.currentTime;
            const duration = audioElement.duration;
            
            if (!isNaN(duration)) {
                progressBar.value = (currentTime / duration) * 100;
                
                // Update time displays
                currentTimeEl.textContent = formatTime(currentTime);
                durationEl.textContent = formatTime(duration);
            }
        });
        
        // Seek functionality
        progressBar.addEventListener('input', function() {
            const seekTime = (progressBar.value / 100) * audioElement.duration;
            audioElement.currentTime = seekTime;
        });
        
        // Play/pause toggle
        playPauseBtn.addEventListener('click', function() {
            if (audioElement.paused) {
                audioElement.play();
                this.innerHTML = '<i class="fas fa-pause"></i>';
            } else {
                audioElement.pause();
                this.innerHTML = '<i class="fas fa-play"></i>';
            }
        });
        
        // When audio ends
        audioElement.addEventListener('ended', function() {
            playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
        });
        
        // Format time as MM:SS
        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
        }
        
        // Bookmark functionality
        document.querySelectorAll('.bookmark-ayat').forEach(btn => {
            btn.addEventListener('click', function() {
                const surah = this.dataset.surah;
                const ayah = this.dataset.ayat;
                const icon = this.querySelector('i');
                
                // Toggle bookmark
                if (icon.classList.contains('far')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    // Save to localStorage
                    saveBookmark(surah, ayah);
                    showToast('Ayat ditandai');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    // Remove from localStorage
                    removeBookmark(surah, ayah);
                    showToast('Ayat dihapus dari tanda');
                }
            });
        });
        
        // Copy functionality
        document.querySelectorAll('.copy-ayat').forEach(btn => {
            btn.addEventListener('click', function() {
                const textToCopy = this.dataset.text;
                navigator.clipboard.writeText(textToCopy)
                    .then(() => showToast('Teks disalin!'))
                    .catch(err => console.error('Gagal menyalin:', err));
            });
        });
        
        // Check and set bookmarked ayahs on load
        checkBookmarks();
        
        function saveBookmark(surah, ayah) {
            let bookmarks = JSON.parse(localStorage.getItem('quranBookmarks') || '[]');
            const bookmark = { 
                surah, 
                ayah, 
                surahName: '<?= htmlspecialchars($surah_normalized['nama_latin']) ?>',
                timestamp: new Date().toISOString() 
            };
            
            // Cek apakah bookmark sudah ada
            if (!bookmarks.some(b => b.surah == surah && b.ayah == ayah)) {
                bookmarks.push(bookmark);
                localStorage.setItem('quranBookmarks', JSON.stringify(bookmarks));
            }
        }

        function removeBookmark(surah, ayah) {
            let bookmarks = JSON.parse(localStorage.getItem('quranBookmarks') || '[]');
            bookmarks = bookmarks.filter(b => !(b.surah == surah && b.ayah == ayah));
            localStorage.setItem('quranBookmarks', JSON.stringify(bookmarks));
        }

        
        function checkBookmarks() {
            const bookmarks = JSON.parse(localStorage.getItem('quranBookmarks')) || [];
            bookmarks.forEach(bookmark => {
                if (bookmark.surah == <?= $surah_number ?>) {
                    const btn = document.querySelector(`.bookmark-ayat[data-ayah="${bookmark.ayah}"]`);
                    if (btn) {
                        const icon = btn.querySelector('i');
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                    }
                }
            });
        }
        
        function showToast(message) {
            const toast = document.createElement('div');
            toast.textContent = message;
            toast.style.position = 'fixed';
            toast.style.bottom = '20px';
            toast.style.left = '50%';
            toast.style.transform = 'translateX(-50%)';
            toast.style.backgroundColor = 'var(--primary)';
            toast.style.color = 'white';
            toast.style.padding = '12px 24px';
            toast.style.borderRadius = '30px';
            toast.style.zIndex = '1000';
            toast.style.boxShadow = '0 3px 10px rgba(0,0,0,0.2)';
            toast.style.animation = 'fadeInOut 2.5s ease-in-out';
            document.body.appendChild(toast);
            
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 2500);
        }
        
        // Add animation for toast
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInOut {
                0% { opacity: 0; transform: translateX(-50%) translateY(20px); }
                10% { opacity: 1; transform: translateX(-50%) translateY(0); }
                90% { opacity: 1; transform: translateX(-50%) translateY(0); }
                100% { opacity: 0; transform: translateX(-50%) translateY(20px); }
            }
        `;
        document.head.appendChild(style);
    });
    </script>
</body>
</html>