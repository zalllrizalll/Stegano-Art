<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $encryption_key = $_POST['encryption_key'];

    // Prepare data for the request
    $postData = [
        'image' => new CURLFile($_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name']),
        'encryption_key' => $encryption_key
    ];

    // Set the appropriate headers
    $headers = ['Content-Type: multipart/form-data'];

    // Use cURL to send a POST request to decode API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:5001/decode');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }

    curl_close($ch);

    // Decode the JSON response
    $responseData = json_decode($response, true);

    if ($responseData['status'] === 'success') {
        // Display the decrypted information
        $decrypted_owner_name = $responseData['message']['decrypted_owner_name'];
        $decrypted_creation_year = $responseData['message']['decrypted_creation_year'];
        $decrypted_email = $responseData['message']['decrypted_email'];
        $decrypted_social_media_url = $responseData['message']['decrypted_social_media_url'];

        echo "Decrypted Owner Name: $decrypted_owner_name<br>";
        echo "Decrypted Creation Year: $decrypted_creation_year<br>";
        echo "Decrypted Email: $decrypted_email<br>";
        echo "Decrypted Social Media URL: $decrypted_social_media_url<br>";
    } else {
        // Display the error message
        echo "Decryption failed. Error: " . $responseData['message'];
    }
}
?>

<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi</title>
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
                            <li><a class="dropdown-item" href="./verifikasi.php">Verifikasi</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="./akun.php">Akun</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="fs-2 mt-3">Verifikasi</h3>
                <p class="">Cocokan gambar Anda disini</p>
                <form action="verifikasi.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3" style="width: 500px;">
                        <label for="formFile" class="form-label">Upload Gambar</label>
                        <input class="form-control" type="file" id="formFile" name="image" required>
                    </div>
                    <div class="mb-3" style="width: 500px;">
                        <label for="text" class="form-label">Kunci Enkripsi</label>
                        <input class="form-control" type="text" id="formEnkripsi" name="encryption_key" required>
                    </div>
                    <div class="mb-3" style="width: 500px;">
                        <label for="text" class="form-label" id="respone"></label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Container to display response messages -->
    <div id="responseContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>