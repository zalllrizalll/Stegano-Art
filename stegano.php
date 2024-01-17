<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $owner_name = $_POST['owner_name'];
    $creation_year = $_POST['creation_year'];
    $email = $_POST['email'];
    $social_media_url = $_POST['social_media_url'];

    // Prepare data for the request
    $postData = [
        'image' => new CURLFile($_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name']),
        'owner_name' => $owner_name,
        'creation_year' => $creation_year,
        'email' => $email,
        'social_media_url' => $social_media_url,
    ];

    // Set the appropriate headers
    $headers = ['Content-Type: multipart/form-data'];

    // Use cURL to send a POST request to encodeapi.py
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5000/encode');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    var_dump($response); // Add this line


    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }

    curl_close($ch);

    // Decode the JSON response
    $responseData = json_decode($response, true);
    var_dump($responseData); // Add this line

    if ($responseData['status'] === 'success') {
        // Update the database with the image path and encryption key
        $username = $_SESSION['username'];

        // Connect to your database and perform the necessary operations
        $conn = mysqli_connect("localhost", "root", "", "stegano");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if table exists, create if not
        $tableName = $username . "Stegano";
        $checkTableExists = "SHOW TABLES LIKE '$tableName'";
        $result = $conn->query($checkTableExists);

        if ($result->num_rows == 0) {
            $createTableQuery = "CREATE TABLE $tableName (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                pathImg VARCHAR(255) NOT NULL,
                key_enkripsi VARCHAR(32) NOT NULL
            )";

            $conn->query($createTableQuery);

            if (!$conn->query($createTableQuery)) {
                echo "Error creating table: " . $conn->error;
            }
        }

        // Insert data into the table
        $insertQuery = "INSERT INTO $tableName (pathImg, key_enkripsi) VALUES ('{$responseData['path']}', '{$responseData['encryption_key w/ HEX']}')";
        $conn->query($insertQuery);

        // Close the database connection
        $conn->close();

        echo '<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Success!</strong> Berhasil membuat steganografi.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>Error!</strong> Gagal dalam pembuatan steganografi.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}
?>

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
            <a class="navbar-brand" href="./index.php">Nama App</a>
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
                            <li><a class="dropdown-item" href="#">Verifikasi</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="./akun.php">Akun</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <?php
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
                <h3 class="fs-2 mt-3">Steganografi</h3>
                <p class="">Pembuatan Steganografi pada sebuah gambar.</p>
                <form action="stegano.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3" style="width: 500px;">
                        <label for="formFile" class="form-label">Upload Gambar</label>
                        <input class="form-control" type="file" id="formFile" name="image" required>
                    </div>
                    <div class="mb-3" style="width: 500px;">
                        <label for="text" class="form-label">Nama Pemilik</label>
                        <input class="form-control" type="text" id="formNamaPemilik" name="owner_name" required>
                    </div>
                    <div class="mb-3" style="width: 500px;">
                        <label for="text" class="form-label">Tahun Pembuatan</label>
                        <input class="form-control" type="text" id="formTahunPembuatan" name="creation_year" required>
                    </div>
                    <div class="mb-3" style="width: 500px;">
                        <label for="text" class="form-label">Email</label>
                        <input class="form-control" type="text" id="formEmail" name="email" required>
                    </div>
                    <div class="mb-3" style="width: 500px;">
                        <label for="text" class="form-label">Sosial Media URL</label>
                        <input class="form-control" type="text" id="formSosialMedia" name="social_media_url" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Container to display response messages -->
    <div id="responseContainer"></div>

    <!-- Script -->
    <script>
        function redirect() {
            window.location.href = "login.php";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>