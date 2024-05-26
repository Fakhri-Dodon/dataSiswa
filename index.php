<?php
session_start();

function data($nama, $nis, $rayon){
    foreach ($_SESSION['dataSiswa'] as $siswa) {
        if($siswa['nama'] == $nama && $siswa['nis'] == $nis && $siswa['rayon'] == $rayon) {
            return true;
        }
    }
    return false;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-submit"])) {
    $nama = $_POST["nama"];
    $nis = $_POST["nis"];
    $rayon = $_POST["rayon"];

    $nis_exist = false;
    foreach($_SESSION['dataSiswa'] as $siswa) {
        if($siswa['nis'] == $nis) {
            $nis_exist = true;
            break;
        }
    }
    if(data($nama, $nis, $rayon)) {
        $_SESSION['error_message'] = "Data sudah ada. Tidak boleh menduplikat";
    }elseif($siswa['nis'] === $nis) {
        $_SESSION['error_message'] = "NIS sudah ada. Tidak boleh menduplikat";
    }else {
        $_SESSION["dataSiswa"][] = array(
            'nama' => $nama,
            'nis' => $nis,
            'rayon' => $rayon,
        );
        $_SESSION['success_message'] = "Data berhasil ditambahkan";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-delete"])) {
    $index = $_POST["delete-index"];
    unset($_SESSION['dataSiswa'][$index]);
    $_SESSION['dataSiswa'] = array_values($_SESSION['dataSiswa']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-edit"])) {
    $index = $_POST["edit-index"];
    header("Location: edit.php?index=$index");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-print-all"])) {
    header("Location: cetak.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-delete-all"])) {
    unset($_SESSION['dataSiswa']);
    $_SESSION['dataSiswa'] = array();
    $_SESSION['success_message'] = "Semua data berhasil dihapus";
    header("location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <h3 class="text-center mb-4 py-2 text-white bg-primary">Masukan Data Siswa</h3>
    <div class="container">
        <div class="form-container">
            <div class="d-flex justify-content-center border border-bottom-0 border-info rounded-top py-3 mb-3">
                <form method="post" class="add-data d-flex justify-content-center flex-column mb-2">
                    <div class="input-container d-flex gap-3 mb-2">
                        <input class="form-control border-info" type="text" placeholder="Nama Siswa" style="text-align: center;" name="nama" required>
                        <input class="form-control border-info" type="number" placeholder="NIS" style="text-align: center;" name="nis" required>
                        <input class="form-control border-info" type="text" placeholder="Rayon" style="text-align: center;" name="rayon" required>
                    </div>
                    <button type="submit" class="btn btn-primary align-right" name="btn-submit">Tambah</button>
                </form>
            </div>
        </div>

        <?php
            if(isset($_SESSION["success_message"])) {
                echo "<div class='alert alert-success d-flex justify-content-between' role='alert'>";
                echo $_SESSION['success_message'];
                echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                echo '</div>';
                unset($_SESSION['success_message']);
            }

            if(isset($_SESSION["error_message"])) {
                echo "<div class='alert alert-danger d-flex justify-content-between' role='alert'>";
                echo $_SESSION['error_message'];
                echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                echo '</div>';
                unset($_SESSION['error_message']);
            }
        ?>

        <div>
            <table class="table table-bordered border-info">
                <?php if(isset($_SESSION['dataSiswa']) && !empty($_SESSION['dataSiswa'])) { ?>
                <div class="d-flex btn-collapse mt-2 mb-2 gap-2">
                    <form action="" method="post">
                        <button type="submit" class="btn btn-danger btn-sm" name="btn-delete-all">
                            <i class="fa-solid fa-trash"></i> All
                        </button>
                        <button type="submit" class="btn btn-warning btn-sm" name="btn-print-all">
                            <i class="fa-solid fa-print"></i> Cetak
                        </button>
                    </form>
                </div>
                <?php } ?>
                <thead>
                    <tr class="table-container table-primary border-info" style="text-align: center;">
                        <th scope="col">No</th>
                        <th scope="col">Nama Siswa</th>
                        <th scope="col">NIS</th>
                        <th scope="col">Rayon</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (isset($_SESSION['dataSiswa']) && !empty($_SESSION['dataSiswa'])) {
                            $nomor = 1;
                            foreach ($_SESSION['dataSiswa'] as $key => $siswa) {?>
                                <tr style="text-align: center;">
                                <td><?php echo $nomor; ?></td>
                                <td><?php echo $siswa['nama']; ?></td>
                                <td><?php echo $siswa['nis']; ?></td>
                                <td><?php echo $siswa['rayon']; ?></td>
                                <td>
                                    <form method="post" class="d-inline-block">
                                        <input type='hidden' name='edit-index' value='<?php echo $key ?>'>
                                        <button type='submit' class='btn btn-warning btn-sm' name='btn-edit'><i class='fa-solid fa-pencil'></i> </button>
                                    </form>
                                    <form method='post' class='d-inline-block'>
                                        <input type='hidden' name='delete-index' value='<?php echo $key ?>'>
                                        <button type='submit' class='btn btn-danger btn-sm' name='btn-delete'><i class='fa-solid fa-trash'></i> </button>
                                    </form>
                                    </td>
                                </tr>
                            <?php    $nomor++;
                            }
                        } else {
                            echo "<tr class='table-active fw-bold'>
                                    <td colspan='5' class='text-danger' style='text-align: center;'>Belum Ditambahkan</td>
                                </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>