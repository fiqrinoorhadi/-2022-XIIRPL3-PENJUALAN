<?php
//Memanggil script code koneksi database dari file koneksi.php
include('koneksi.php');

//Variabel kosong, untuk menghindari error karena variable $status digunakan tanpa ada deklarasi variable sebelumnya 
$status = '';

//Struktur kontrol "if" untuk mengeksekusi baris program didalamnya, ketika tombol submit form input di tekan
if (isset($_POST['simpan'])) 
{

    //pengambilan data dengan mothod POST yang selanjutnya disimpan sementara kedalam variable $nb, $hb, $sb, $sp
    //isi dari variable super global $_POST[''] berasal dari atribut "name" pada tag <input name=""> form html
    $nb = $_POST['nama_barang'];
    $hb = $_POST['harga_barang'];
    $sb = $_POST['stok_barang'];
    $sp = $_POST['supplier'];

    //Alternatif query SQL untuk insert data, dengan menyebutkan nama kolom dari tabel barang
    // $sql = "INSERT INTO barang (nama_barang,harga_barang,stok_barang,supplier)
    //         VALUES ('$nb','$hb','$sb','$sp')";

    //Alternatif query SQL untuk insert data, tanpa menyebutkan nama kolom dari tabel barang
    $sql = "INSERT INTO barang VALUES ('','$nb','$hb','$sb','$sp')";

    //Perintah untuk mengeksekusi query sql yang sebelumnya dibuat di baris program sebelumnya
    $insert = mysqli_query($koneksi,$sql);

    //Struktur kontrol "if" untuk pengecekan keberhasilan eksekusi query sql, apakah gagal atau berhasil
    if (!$insert) 
    {
        $status = 'gagal';
    }
    else
    {
        $status = 'sukses';
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan Barang</title>
    <link rel="stylesheet" href="bootstrap-5.2.0-dist/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <!-- start baris 1 -->
        <div class="row">
            <div class="col-2"></div> <!-- kolom 1 --> 
            <div class="col-8"><!-- start kolom 2 -->
            <?php
                    //struktur kontrol "if" untuk pengecekan isi $status yang sebelumnya kosong (lihat $status di barus program paling atas)
                    //isi $status akan berubah ketika proses dari insert data berhasil(lihat kembali baris program eksekusi query slq insert data)
                    if ($status == 'sukses' ) 
                    {
                    ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Data Berhasil Disimpan</strong> Mudah-mudahan datanya tersimpan di database.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    }
                    if ($status == 'gagal' ) 
                    {
                    ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Data Gagal Disimpan</strong> Silahkan periksa kembali program anda.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    <?php
                    }
                    ?>

            </div><!-- end of kolom 2 -->
            <div class="col-2"></div> <!-- kolom 3 -->
        </div>
        <!-- end of baris 1 -->
        <!-- start baris 2 -->
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="card mt-2">
                    <div class="card-header">
                        Data Barang
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-floating mb-2">
                                <input class="form-control" type="text" name="nama_barang" id="nama_barang" placeholder="komputer" required>
                                <label class="form-label" for="nama_barang">Nama Barang</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input class="form-control" type="text" name="harga_barang" id="harga_barang" placeholder="1000000" required>
                                <label class="form-label" for="harga_barang">Harga Barang</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input class="form-control" type="text" name="stok_barang" id="stok_barang" placeholder="100" required>
                                <label class="form-label" for="stok_barang">Stok Barang</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input class="form-control" type="text" name="supplier" id="supplier" placeholder="PT. Jaya Abadi" required>
                                <label class="form-label" for="supplier">Supplier</label>
                            </div>
                            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                        </form>
                    </div>
                </div>
            </div> <!-- ini tutup div col2 row1 -->
            <div class="col-3"></div>
        </div>

        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <table class="table">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Harga Barang</th>
                        <th>Stok Barang</th>
                        <th>Suplier</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Komputer</td>
                        <td>20000000</td>
                        <td>50</td>
                        <td>Agres.id</td>
                    </tr>
                    
                </table>
            </div>
            <div class="col-2"></div>
        </div>

    </div><!-- ini adalah tutup div container -->
    <script src="bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    </body>
</html>