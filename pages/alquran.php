<?php 
// Ambil data surah dari API
$surah_list = json_decode(file_get_contents('https://equran.id/api/surat'), true);
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Etrain</title>
    <link rel="icon" href="../assets/img/logoislam.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- animate CSS -->
    <link rel="stylesheet" href="../assets/css/animate.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <!-- themify CSS -->
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="../assets/css/flaticon.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="../assets/css/magnific-popup.css">
    <!-- swiper CSS -->
    <link rel="stylesheet" href="../assets/css/slick.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/quran.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>

        .nav-link {
        color: white;
        }

        .nav-item.active .nav-link {
        color: #02140bff;
        background-color: #0c452aff;
        border-radius: 5px;
        font-weight: bold;
        }

        /* Hero Section - Green Version */
        .hero {
            position: relative;
            padding: 100px 0 120px;
            color: white;
            overflow: hidden;
        }

        .hero-content {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 40px;
            position: relative;
            z-index: 2;
        }

        .greeting {
            flex: 1;
            min-width: 300px;
            text-align: left;
        }

        .as-salam {
            font-family: 'Amiri Quran', serif;
            font-size: 2.2rem;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.9);
        }

        .hero h1 {
            font-size: 2.8rem;
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .hero h1 span {
            color: #F8DE7E; /* Soft gold for highlight */
        }

        .subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .cta-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .cta-primary, .cta-secondary {
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .cta-primary {
            background: white;
            color: #5D9C59;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .cta-primary:hover {
            background: #f0f0f0;
            transform: translateY(-3px);
        }

        .cta-secondary {
            border: 2px solid white;
            color: white;
        }

        .cta-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }

        /* Verse Card */
        .verse-of-the-day {
            flex: 1;
            min-width: 300px;
        }

        .verse-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            color: #333;
        }

        .verse-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            color: #5D9C59;
        }

        .verse-header i {
            font-size: 1.5rem;
        }

        .verse-header h3 {
            font-size: 1.2rem;
            margin: 0;
        }

        .arabic-text {
            font-family: 'Amiri Quran', serif;
            font-size: 1.8rem;
            line-height: 1.8;
            text-align: right;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .translation {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 10px;
            color: #555;
            border-right: 3px solid #5D9C59;
            padding-right: 15px;
        }

        .reference {
            color: #5D9C59;
            font-weight: 600;
            font-style: italic;
        }

        /* Mosque Silhouette Decoration */
        .mosque-silhouette {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="%23ffffff"></path><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="%23ffffff"></path><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="%23ffffff"></path></svg>');
            background-size: cover;
            z-index: 1;
        }

        :root {
            --primary-color: #5D9C59;
            --secondary-color: #C7B299;
            --accent-color: #D4A373;
            --light-color: #F8F1E9;
            --dark-color: #333333;
            --text-color: #555555;
        }

        /* Hero Section */
        .hero {
            position: relative;
            padding: 120px 0;
            color: white;
            text-align: center;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
        }

        .as-salam {
            font-family: 'Amiri Quran', serif;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .hero h1 span {
            color: var(--accent-color);
        }

        .subtitle {
            font-size: 1.2rem;
            margin-bottom: 40px;
        }

        .verse-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 8px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            color: var(--dark-color);
        }

        .arabic-text {
            font-family: 'Amiri Quran', serif;
            font-size: 1.8rem;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .translation {
            font-size: 1.1rem;
            font-style: italic;
            margin-bottom: 5px;
        }

        .reference {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
            background: var(--light-color);
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-subtitle {
            color: var(--primary-color);
            font-weight: 500;
            margin-bottom: 10px;
        }

        .section-header h2 {
            font-size: 2.2rem;
            color: var(--dark-color);
            margin-bottom: 15px;
        }

        .decorative-line {
            width: 80px;
            height: 3px;
            background: var(--accent-color);
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-item {
            background: white;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .icon-wrapper {
            width: 80px;
            height: 80px;
            background: rgba(93, 156, 89, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--primary-color);
            font-size: 1.8rem;
        }

        .feature-item h3 {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        .feature-item p {
            color: var(--text-color);
            margin-bottom: 20px;
        }

        .feature-link {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }

        /* Content Section */
        .content-section {
            padding: 80px 0;
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .content-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .content-card:hover {
            transform: translateY(-5px);
        }

        .card-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .category-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .card-body {
            padding: 20px;
        }

        .meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: var(--text-color);
        }

        .content-card h3 {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        .content-card p {
            color: var(--text-color);
            margin-bottom: 20px;
        }

        .read-more {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }

        /* CTA Section */
        .cta-section {
            padding: 60px 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, #478540 100%);
            color: white;
            text-align: center;
        }

        .cta-box {
            max-width: 800px;
            margin: 0 auto;
        }

        .cta-box h2 {
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .cta-box p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .cta-primary, .cta-secondary {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .cta-primary {
            background: white;
            color: var(--primary-color);
        }

        .cta-primary:hover {
            background: var(--light-color);
            transform: translateY(-3px);
        }

        .cta-secondary {
            border: 2px solid white;
            color: white;
        }

        .cta-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }

        /* Footer Styles */
        .islamic-footer {
            position: relative;
            background: #2a5a2a; /* Deep Islamic green */
            color: #fff;
            padding: 60px 0 0;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 50px;
        }

        .footer-section {
            margin-bottom: 30px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .footer-logo i {
            font-size: 2rem;
            margin-right: 10px;
            color: #f8de7e; /* Gold color */
        }

        .footer-description {
            opacity: 0.8;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: #fff;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: #5D9C59;
            transform: translateY(-3px);
        }

        .footer-title {
            font-size: 1.3rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
            color: #f8de7e; /* Gold color */
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background: #5D9C59;
        }

        .footer-links li {
            margin-bottom: 12px;
            list-style: none;
        }

        .footer-links a {
            color: #fff;
            opacity: 0.8;
            text-decoration: none;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }

        .footer-links a i {
            margin-right: 8px;
            font-size: 0.9rem;
        }

        .footer-links a:hover {
            opacity: 1;
            color: #f8de7e;
            padding-left: 5px;
        }

        .contact-info li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            opacity: 0.8;
            line-height: 1.5;
        }

        .contact-info i {
            margin-right: 10px;
            color: #f8de7e;
            font-size: 1.1rem;
            min-width: 20px;
        }

        .newsletter-form {
            margin-top: 20px;
        }

        .newsletter-form input {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .newsletter-form input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .subscribe-btn {
            width: 100%;
            padding: 12px;
            background: #5D9C59;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .subscribe-btn:hover {
            background: #4a8c46;
            transform: translateY(-2px);
        }

        .quran-verse {
            text-align: center;
            padding: 30px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin: 40px 0;
        }

        .quran-verse .arabic {
            font-family: 'Amiri Quran', serif;
            font-size: 1.8rem;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .quran-verse .translation {
            font-style: italic;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .quran-verse .reference {
            color: #f8de7e;
            font-weight: 600;
        }

        .copyright {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            opacity: 0.7;
            font-size: 0.9rem;
        }

        .footer-menu {
            display: flex;
            gap: 20px;
        }

        .footer-menu a {
            color: #fff;
            text-decoration: none;
            transition: all 0.3s;
        }

        .footer-menu a:hover {
            color: #f8de7e;
        }

        /* Decorative Elements */
        .footer-pattern {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><path fill="%235D9C59" fill-opacity="0.05" d="M30,10L50,30L70,10L90,30L70,50L90,70L70,90L50,70L30,90L10,70L30,50L10,30L30,10Z"></path></svg>');
            background-size: 200px;
            opacity: 0.3;
            z-index: 1;
        }

    </style>

</head>

<body>
    <!--::header part start::-->
    <header class="main_menu home_menu" style="max-height:100px; background: linear-gradient(135deg, #5D9C59 0%, #8BBF88 100%); display: flex; align-items: center; word-spacing: -2px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="index.php"> <img style="width:20%" src="../assets/img/logoislam.png" alt="logo"> </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse main-menu-item justify-content-end"
                            id="navbarSupportedContent">
                            <ul class="navbar-nav align-items-center">
                                <li class="nav-item">
                                    <a class="nav-link" style="color:white" href="../index.php">Home</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" style="color:white" href="../pages/alquran.php">Al-Qur'an</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" style="color:white" href="../pages/hadits.php">Hadits</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" style="color:white" href="../pages/jadwal_sholat.php">Jadwal Sholat</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" style="color:white" href="../pages/artikel.php">Artikel</a>
                                </li>
                                <!-- <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="blog.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Pages
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="../pages/single-blog.php">Single blog</a>
                                        <a class="dropdown-item" href="../pages/elements.php">Elements</a>
                                    </div>
                                </li> -->
                                
                                <!-- <li class="d-none d-lg-block">
                                    <a class="btn_1" href="../pages/index.php">Let's play games!</a>
                                </li> -->
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header part end-->

    <!-- Main Page -->

        <section class="quran-container" style="margin-top: 100px;">
            <div class="search-container">
                <input type="text" id="search-surah" placeholder="Cari surah..." class="search-input">
                <i class="fas fa-search search-icon"></i>
            </div>

            <div class="surah-grid">
                <?php foreach ($surah_list as $surah): ?>
                    <a href="surah.php?nomor=<?= $surah['nomor'] ?>" class="surah-card">
                        <div class="surah-number"><?= $surah['nomor'] ?></div>
                        <div class="surah-details">
                            <h3><?= $surah['nama_latin'] ?></h3>
                            <p class="surah-meta">
                                <span class="ayat"><?= $surah['jumlah_ayat'] ?> ayat</span> | 
                                <span class="type"><?= $surah['tempat_turun'] ?></span>
                            </p>
                            <p class="surah-name-arabic"><?= $surah['nama'] ?></p>
                        </div>
                        <div class="surah-play">
                            <i class="fas fa-play-circle"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

    <!-- End Main Page -->

    <!-- footer part start-->
    <footer class="islamic-footer">
        <div class="footer-container">
            <!-- Main Footer Content -->
            <div class="footer-grid">
                <!-- About Section -->
                <div class="footer-section">
                    <div class="footer-logo">
                        <i class="fas fa-mosque"></i>
                        <span>Al-Huda</span>
                    </div>
                    <p class="footer-description" style="color: white;">
                        Portal Islami yang menyajikan Al-Qur'an, Hadits, dan kajian-kajian ilmiah untuk menebar manfaat kepada ummat.
                    </p>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h3 class="footer-title">Tautan Cepat</h3>
                    <ul class="footer-links">
                        <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                        <li><a href="alquran.php"><i class="fas fa-quran"></i> Al-Qur'an</a></li>
                        <li><a href="hadits.php"><i class="fas fa-book-open"></i> Hadits</a></li>
                        <li><a href="jadwal_sholat.php"><i class="fas fa-pray"></i> Jadwal Sholat</a></li>
                        <li><a href="artikel.php"><i class="fas fa-newspaper"></i> Artikel</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="footer-section">
                    <h3 class="footer-title">Hubungi Kami</h3>
                    <ul class="contact-info">
                        <li><i class="fas fa-map-marker-alt"></i> Jl. Ilmu No. 1, Kota Barokah</li>
                        <li><i class="fas fa-envelope"></i> info@alhuda.example</li>
                        <li><i class="fas fa-phone-alt"></i> +62 123 4567 890</li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="footer-section">
                    <h3 class="footer-title">Buletin Islami</h3>
                    <p style="color: white;">Berlangganan untuk mendapatkan konten terbaru via email</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Alamat Email Anda" required>
                        <button type="submit" class="subscribe-btn">
                            <i class="fas fa-paper-plane"></i> Berlangganan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Decorative Quranic Verse -->
            <div class="quran-verse">
                <p class="arabic" style="color: white;">وَمَنْ أَحْسَنُ قَوْلًا مِّمَّن دَعَا إِلَى اللَّهِ وَعَمِلَ صَالِحًا وَقَالَ إِنَّنِي مِنَ الْمُسْلِمِينَ</p>
                <p class="translation" style="color: white;">"Dan siapakah yang lebih baik perkataannya daripada orang yang menyeru kepada Allah, mengerjakan amal yang saleh, dan berkata: 'Sesungguhnya aku termasuk orang-orang yang menyerah diri?'"</p>
                <p class="reference">QS. Fussilat: 33</p>
            </div>

            <!-- Copyright -->
            <div class="copyright" style="color: white;">
                <p style="color: white;">&copy; <span id="current-year"></span> Al-Huda. All Rights Reserved.</p>
                <div class="footer-menu">
                    <a href="privacy.php">Kebijakan Privasi</a>
                    <a href="terms.php">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="footer-pattern"></div>
    </footer>
    <!-- footer part end-->

    <!-- jquery plugins here-->
    <!-- jquery -->
    <script src="../assets/js/jquery-1.12.1.min.js"></script>
    <!-- popper js -->
    <script src="../assets/js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- easing js -->
    <script src="../assets/js/jquery.magnific-popup.js"></script>
    <!-- swiper js -->
    <script src="../assets/js/swiper.min.js"></script>
    <!-- swiper js -->
    <script src="../assets/js/masonry.pkgd.js"></script>
    <!-- particles js -->
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/jquery.nice-select.min.js"></script>
    <!-- swiper js -->
    <script src="../assets/js/slick.min.js"></script>
    <script src="../assets/js/jquery.counterup.min.js"></script>
    <script src="../assets/js/waypoints.min.js"></script>
    <!-- custom js -->
    <script src="../assets/js/custom.js"></script>

    <script>
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>

    <script>
        // Fitur pencarian surah
        document.getElementById('search-surah').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const surahCards = document.querySelectorAll('.surah-card');
            
            surahCards.forEach(card => {
                const surahName = card.querySelector('h3').textContent.toLowerCase();
                const surahArabic = card.querySelector('.surah-name-arabic').textContent.toLowerCase();
                if (surahName.includes(searchTerm) || surahArabic.includes(searchTerm)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>


</body>

</html>