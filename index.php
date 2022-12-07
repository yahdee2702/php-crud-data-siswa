<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "datasiswa";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Tidak terhubung ke database");
}

$nis = "";
$nama = "";
$alamat = "";
$kelas = "";
$error = "";
$sukses = "";

$op = "";

$op = $_GET['op'] ?? "";

if ($op == "edit") {
    $id = $_GET['id'];
    $crud1 = "select * from siswa where id = '$id'";
    $c1 = mysqli_query($koneksi, $crud1);
    $r1 = mysqli_fetch_array($c1);

    $nis = $r1['nis'];
    $nama = $r1['nama'];
    $alamat = $r1['alamat'];
    $kelas = $r1['kelas'];

    if ($nis == '') {
        $error = "Data Tidak Ditemukan";
    }
}

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "delete from siswa where id = '$id'";
    try {
        $q1 = mysqli_query($koneksi, $sql1);

        if ($q1) {
            $sukses = "Berhasil menghapus data";
        } else {
            $error = "Gagal menghapus data";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Untuk Create Data

if (isset($_POST['simpan'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kelas = $_POST['kelas'];

    if ($nis && $nama && $alamat && $kelas) {
        if ($op == "edit") {
            $crud1 = "update siswa set nis='$nis', nama='$nama', alamat='$alamat', kelas='$kelas' where id='$id'";

            try {
                $cr1 = mysqli_query($koneksi, $crud1);

                if ($cr1) {
                    $sukses = "Berhasil mengupdate data";
                } else {
                    $error = "Gagal mengupdate data";
                }
            } catch (Exception $e) {
                $e->getMessage();

                $error = $e->getMessage();
            }
        } else {
            $crud1 = "insert into siswa(nis, nama, alamat, kelas) value ('$nis', '$nama', '$alamat', '$kelas')";

            try {
                $c1 = mysqli_query($koneksi, $crud1);

                if ($c1) {
                    $sukses = "Berhasil memasukkan data";
                } else {
                    $error = "Gagal memasukkan data";
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
    } else {
        $error = "Ada beberapa form yang belum terisi";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- Craete User Data -->

        <div class="card">
            <div class="card-header">
                Create / Edit
            </div>

            <div class="card-body">
                <?php
                if ($error) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error ?>
                </div>
                <?php
                header("refresh:3;url = index.php");
                }
                ?>

                <?php
                if ($sukses) {
                ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $sukses ?>
                </div>
                <?php
                header("refresh:3;url = index.php");
                }
                ?>

                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nis" class="col-sm-2 col-form-label">NIS</label>
                        <div class="col-sm-10">
                            <input type="text" required class="form-control" id="nis" name="nis"
                                value="<?php echo $nis ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" required class="form-control" id="nama" name="nama"
                                value="<?php echo $nama ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" required class="form-control" id="alamat" name="alamat"
                                value="<?php echo $alamat ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kelas" name="kelas" required>
                                <option value="" <?php if ($kelas == "") {echo "selected";}?>>--- Pilih Kelas ---</option>
                                <option value="Kelas X" <?php if ($kelas=="Kelas X") { echo "selected"; } ?>>Kelas X
                                </option>
                                <option value="Kelas XI" <?php if ($kelas=="Kelas XI") { echo "selected"; } ?>>Kelas XI
                                </option>
                                <option value="Kelas XII" <?php if ($kelas=="Kelas XII") { echo "selected"; } ?>>Kelas
                                    XII
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>

        <!-- Read User Data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Siswa
            </div>

            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">NIS</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">ALAMAT</th>
                            <th scope="col">KELAS</th>
                            <th scope="col">AKSI</th>
                        </tr>

                    <TBody>
                        <?php
                        $crud2 = "select * from siswa order by id desc";
                        $c2 = mysqli_query($koneksi, $crud2);
                        $urut = 1;

                        while ($r2 = mysqli_fetch_array($c2)) {
                            $id = $r2['id'];
                            $nis = $r2['nis'];
                            $nama = $r2['nama'];
                            $alamat = $r2['alamat'];
                            $kelas = $r2['kelas'];
                        ?>
                        <tr>
                            <td scope="row">
                                <?php echo $urut++ ?>
                            </td>
                            <td scope="row">
                                <?php echo $nis ?>
                            </td>
                            <td scope="row">
                                <?php echo $nama ?>
                            </td>
                            <td scope="row">
                                <?php echo $alamat ?>
                            </td>
                            <td scope="row">
                                <?php echo $kelas ?>
                            </td>
                            <td scope="row">
                                <a href="index.php?op=edit&id=<?php echo $id; ?>">
                                    <button type="button" class="btn btn-warning">Edit</button>
                                </a>
                                <a href="index.php?op=delete&id=<?php echo $id; ?>"
                                    onclick="return confirm('Yakin mau mengahapus')"><button type="button"
                                        class="btn btn-danger">Delete</button></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </TBody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>

</html>