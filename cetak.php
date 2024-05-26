<?php
session_start();

if (!isset($_SESSION['dataSiswa']) || empty($_SESSION['dataSiswa'])) {
    $_SESSION['error_print_message'] = 'Tidak ada data yang dapat dicetak.';
    header('Location: index.php');
    exit;
}

$dataSiswa = $_SESSION['dataSiswa'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <div class="container">
        <h3 class="text-center mt-4">Data Siswa</h3>
        <table class="table table-bordered border-info mt-4">
            <thead>
                <tr class="table-container table-primary border-info" style="text-align: center;">
                    <th scope="col">No</th>
                    <th scope="col">Nama Siswa</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Rayon</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php foreach ($dataSiswa as $key => $siswa) {
                    echo "<tr>";
                    echo "<td>". $key + 1 . "</td>";
                    echo "<td>".$siswa['nama']."</td>";
                    echo "<td>".$siswa['nis']."</td>";
                    echo "<td>".$siswa['rayon']."</td>";
                    echo "</tr>";
                }
                ?>
             </tbody>
        </table>
        <a href='index.php' class='btn btn-primary'>Kembali</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="cetak.js"></script>
</body>
</html>