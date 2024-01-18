<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<style>
    .custom-image {
        max-width: 80%;
        height: auto;
        margin-top: 0.3cm;
        margin-left: 1cm;
        margin-bottom: 5cm;
    }

    .teks {
        padding-left: 0;
        padding-right: 1cm;
        padding-top: 2cm;
    }

    @media (max-width: 768px) {

        /* Gunakan padding yang lebih kecil untuk tampilan responsif */
        .teks {
            padding-right: 0.5cm;
        }
    }
</style>


<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand">Stegano Art</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Tools
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./stegano.php">Steganografi</a></li>
                            <li><a class="dropdown-item" href="./verifikasi.php">Verifikasi</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="./akun.php">Akun</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <?php
                    session_start();

                    // Check if user is logged in
                    if (isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                        echo "Hi, $username";
                    } else {
                        echo '<a class="btn btn-outline-success" onclick="redirect()">Login</a>';
                    }
                    ?>
                </form>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <!-- Content -->
    <div class="container-fluid">
        <div class="row align-items-center mt-5">
            <div class="col-md-6" style='margin-left:150px'>
                <h2>Steganography Art</h2>
                <p>Steganography adalah seni atau teknik menyembunyikan informasi atau data dalam media yang tidak mencurigakan. Steganography Art mengacu pada penggunaan seni atau karya seni sebagai media untuk menyembunyikan pesan atau informasi rahasia. Tujuan utama dari steganography art adalah menyembunyikan pesan dalam karya seni tanpa menarik perhatian.Penting untuk dicatat bahwa steganography art dapat digunakan untuk berbagai tujuan, termasuk komunikasi rahasia, penyimpanan data rahasia, atau bahkan sebagai bentuk seni digital yang inovatif. Meskipun mungkin tidak sepopuler steganography dalam konteks keamanan komputer, steganography art menawarkan cara kreatif dan estetis untuk menyampaikan atau menyembunyikan pesan.</p>
                <a href="./stegano.php" class="btn btn-outline-success">Get Started</a>
            </div>
            <div class="col-md-4 mt-4" style="padding-left:50px">
                <img src="./assets/dist/img/logo.png" alt="Image Content" class="img-fluid" style="width: 50rem;">
            </div>
        </div>
        <!-- Content Service  -->
        <div class="container text-center" style="padding-top: 50px">
            <div class="text-center">
                <h3>Our Service</h3>
                <p>Kami memberikan pelayanan terbaik untuk Anda. Dengan Steganography Art, jadikan seni digital Anda lebih dari sekadar ekspresi kreatif, tetapi juga sebagai sarana untuk berkomunikasi secara eksklusif dan penuh misteri.</p>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4" style="padding-top:20px; margin-bottom:20px">
                <div class="col">
                    <div class="card" style="width: 25rem;">
                        <img src="./assets/dist/img/logo2.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Stegano Art menggunakan teknologi pixel terkini, termasuk manipulasi LSB, untuk menyematkan pesan rahasia secara tidak terlihat pada setiap piksel gambar Anda. Pesan tersebut dapat diekstraksi kembali dengan menggunakan kunci yang sesuai.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card" style="width: 25rem;">
                        <img src="./assets/dist/img/logo3.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Layanan ini memberikan Anda kebebasan untuk menyesuaikan bagaimana pesan Anda akan disematkan. Anda dapat memilih elemen karya seni yang akan dimanipulasi, seperti warna, tekstur, atau elemen-elemen lainnya. Layanan ini mendukung berbagai format gambar dan seni digital.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card" style="width: 25rem;">
                        <img src="./assets/dist/img/logo4.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Stegano Art memberikan prioritas tinggi pada keamanan pesan yang disematkan. Data sensitif Anda akan dilindungi dengan enkripsi tingkat tinggi dan memastikan bahwa pesan Anda aman dan hanya dapat diakses oleh penerima yang ditentukan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Product -->
    <div class="container" style="padding-top:20px; margin-bottom:20px">
        <div class="row mt-3">
            <div class="col-md-6">
                <img src="./assets/dist/img/logo5.png" alt="" style="width:35rem; padding-left:50px; margin-left:20px">
            </div>
            <div class="col-md-6" style="padding-top:30px; padding-right: 50px">
                <h2>Confidentiality is key</h2>
                <p>Steganography art verification adalah proses untuk memastikan apakah sebuah karya seni atau media digital telah dimanipulasi atau tidak, khususnya apakah terdapat pesan tersembunyi di dalamnya. Pada umumnya, verifikasi steganografi art dilakukan dengan tujuan memverifikasi keaslian dan integritas dari karya seni tersebut. Beberapa algoritma deteksi perubahan dapat digunakan untuk membandingkan dua versi dari karya seni, yaitu versi yang asli dan versi yang mungkin dimanipulasi. Perubahan yang signifikan dapat menunjukkan adanya steganografi.</p>
                <a href="./verifikasi.php" class="btn btn-outline-success">Learn more</a>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container text-left text-md-left">
            <div class="row text-center text-md-left">
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-warning">University</h5>
                    <p>Universitas Dian Nuswantoro</p>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Products</h5>
                    <p>
                        <a href="./stegano.php" class="text-white" style="text-decoration: none;">Steganography</a>
                    </p>
                    <p>
                        <a href="./verifikasi.php" class="text-white" style="text-decoration: none;">Verification</a>
                    </p>
                </div>
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Support</h5>
                    <p>
                        <a href="./akun.php" class="text-white" style="text-decoration: none;">Account</a>
                    </p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Contact</h5>
                    <p>
                        <i class="fas fa-home mr-3"></i>207 Imam Bonjol Street
                    </p>
                    <p>
                        <i class="fas fa-envelope mr-3"></i>sekretariat@dinus.ac.id
                    </p>
                    <p>
                        <i class="fas fa-phone mr-3"></i>(024) 3517261
                    </p>
                    <p>
                        <i class="fas fa-fax mr-3"></i>+01 335 633 77
                    </p>
                </div>
            </div>
            <hr class="mb-4">
            <div class="row align-items-center">
                <div class="col-md-7 col-lg-8">
                    <p> Copyright &copy; All rights reserved by
                        <a href="https://portal.dinus.ac.id/" style="text-decoration:none">
                            <strong class="text-warning">Universitas Dian Nuswantoro</strong>
                        </a>
                    </p>
                </div>
                <div class="col-md-5 col-lg-4">
                    <div class="text-center text-md-right">
                        <ul class="list-unstyled list-inline">
                            <li class="list-inline-item">
                                <a href="https://www.facebook.com/univ.dian.nuswantoro/" class="btn-floating btn-sm text-white" style="font-size:23px"><i class="fab fa-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://twitter.com/udinusofficial" class="btn-floating btn-sm text-white" style="font-size:23px"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://www.instagram.com/udinusofficial/" class="btn-floating btn-sm text-white" style="font-size:23px"><i class="fab fa-instagram"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://www.linkedin.com/school/universitas-dian-nuswantoro/?originalSubdomain=id" class="btn-floating btn-sm text-white" style="font-size:23px"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://www.youtube.com/@tvkuch49udinus" class="btn-floating btn-sm text-white" style="font-size:23px"><i class="fab fa-youtube"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Script -->
    <script>
        function redirect() {
            window.location.href = "login.php";
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

<!-- Footer -->
<footer class="bg-body-tertiary text-center py-3">
    <p class="mb-0">© 2024 Stegano-Art by Kelompok Kripto. All rights reserved.</p>
</footer>

</html>

</html>