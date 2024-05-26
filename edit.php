<?php

session_start();

function data($nama, $nis, $rayon, $exclude_index = null) {
    foreach ($_SESSION['datasiswa'] as $index => $siswa) {
        if ($index != $exclude_index && $siswa['nis'] == $nis) {
            return true;
        }
    }
    return false;
}

if (!isset($_GET["index"]) || !isset($_SESSION['dataSiswa'][$_GET["index"]])) {
    header("Location: index.php");
    exit;
}

$index = $_GET["index"];
$siswa = $_SESSION['dataSiswa'][$index];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-update"])) {
    $nama = $_POST["nama"];
    $nis = $_POST["nis"];
    $rayon = $_POST["rayon"];

    if (data($nama, $nis, $rayon, $index)) {
        $_SESSION['error_message'] = "Data dengan NIS ini sudah ada. Tidak boleh menduplikat.";
    } else {
        $_SESSION['dataSiswa'][$index] = array(
            'nama' => $nama,
            'nis' => $nis,
            'rayon' => $rayon
        );
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container-lg px-0">
        <h3 class="text-center mt-4">Edit Data Siswa</h3>
        <?php
            if(isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']);
            }
        ?>
        <form method="post">
            <div class="d-flex mb-2">
                <input class="form-control col-4 border-info" type="text" placeholder="Nama" style="text-align: center;" name="nama" value="<?php echo htmlspecialchars($siswa['nama']); ?>" required>
                <input class="form-control col-4 border-info mx-2" type="number" placeholder="NIS" style="text-align: center;" name="nis" value="<?php echo htmlspecialchars($siswa['nis']); ?>" required>
                <input class="form-control col-4 border-info" type="text" placeholder="Rayon" style="text-align: center;" name="rayon" value="<?php echo htmlspecialchars($siswa['rayon']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="btn-update">Update</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>   
</body>
</html>