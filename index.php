<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

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
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="fs-2 mt-2">Home</h3>
                <p class="">di isikan contentnya apa saja.</p>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        function redirect() {
            window.location.href = "login.php";
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>

</html>