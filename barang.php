<?php
//Memanggil script code koneksi database dari file koneksi.php
include('koneksi.php');

//Variabel kosong, untuk menghindari error karena variable $status dan variable dibawahnya($nb,$hb,$sb,$sp) digunakan tanpa ada deklarasi variable sebelumnya 
$status = '';
$nb = '';
$hb = '';
$sb = '';
$sp = '';

//struktur kontrol 'if' mengecek keberadaan index 'proses' diurl browser, jika ada maka jalankan program di dalamnya
if (isset($_GET['proses'])) 
{
    //struktur kontrol 'if' mengecek isi dari index 'proses'. Jika isinya adalah 'delete', maka jalankan program didalammnya
    if ($_GET['proses']=='delete') 
    {
        //menggunakan method GET, ambil data index 'id' di url browser dan simpan pada variable $id
        $id = $_GET['id'];

        //simpan sebuah query delete kedalam variable baru yaitu variable $sql 
        $sql = "DELETE FROM barang WHERE id = '$id'";

        //jalankan perintah eksekusi query menggunakan mysqli_query dan simpan pada variable baru yaitu $delete
        $delete = mysqli_query($koneksi,$sql);

        //struktur kontrol 'if' mengecek keberhasilan eksekusi query di variable $delete, apakah berhasil atau tidak
        if (!$delete) 
        {
            $status = 'delete';
            $pesan1 = 'Data GAGAL di DELETE';
            $pesan2 = 'Cek lagi, mungkin ada kode program yang salah !!!';
        }
        else
        {
            $status = 'sukses';
            $pesan1 = 'Data BERHASIL di DELETE';
            $pesan2 = 'Mudah-mudahan datanya terhapus di DATABASE !!!';

        }

    }

    if ($_GET['proses']=='edit') 
    {
        $id = $_GET['id'];
        $sql = "SELECT * FROM barang WHERE id = '$id'";
        $select = mysqli_query($koneksi,$sql);
        $data = mysqli_fetch_assoc($select);
        $nb = $data['nama_barang'];
        $hb = $data['harga_barang'];
        $sb = $data['stok_barang'];
        $sp = $data['supplier'];
    }
}

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
    if (isset($_GET['proses'])) 
    {
        if ($_GET['proses']=='edit') {
            $id = $_GET['id'];
            $sql = "UPDATE barang SET nama_barang = '$nb',
            harga_barang =  '$hb', stok_barang = '$sb', supplier = '$sp'
            WHERE id = '$id' ";
            $update = mysqli_query($koneksi,$sql);
            if (!$update) {
                $status = 'gagal';
                $pesan1 = 'Data Gagal di UPDATE';
                $pesan2 = 'Cek lagi program anda';
            }
            else
            {
                $status = 'sukses';
                $pesan1 = 'Data Berhasil di UPDATE';
                $pesan2 = 'Alhamdulillah berhasil di update';
            }
        }
    }
    else
    {
        //Alternatif query SQL untuk insert data, tanpa menyebutkan nama kolom dari tabel barang
        $sql = "INSERT INTO barang VALUES ('','$nb','$hb','$sb','$sp')";

        //Perintah untuk mengeksekusi query sql yang sebelumnya dibuat di baris program sebelumnya
        $insert = mysqli_query($koneksi,$sql);

        //Struktur kontrol "if" untuk pengecekan keberhasilan eksekusi query sql, apakah gagal atau berhasil
        if (!$insert) 
        {
            $status = 'gagal';
            $pesan1 = 'Data GAGAL di SIMPAN';
            $pesan2 = 'Cek lagi, mungkin ada kode program yang salah !!!';
        }
        else
        {
            $status = 'sukses';
            $pesan1 = 'Data BERHASIL di SIMPAN';
            $pesan2 = 'Selamat, data anda sudah tersimpan di DATABASE !!!';
        }
    } //ini
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
                            <strong><?php echo $pesan1 ?></strong> <?php echo $pesan2 ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <script type="text/JavaScript">
                            setTimeout("location.href = 'http://localhost/01-penjualan-fiqri/barang.php';", 1500);
                        </script>
                        <?php
                    }
                    if ($status == 'gagal' ) 
                    {
                        ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><?php echo $pesan1 ?></strong> <?php echo $pesan2 ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <script type="text/JavaScript">
                            setTimeout("location.href = 'http://localhost/01-penjualan-fiqri/barang.php';", 1500);
                        </script>
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
                                <input value="<?php echo $nb ?>" class="form-control" type="text" name="nama_barang" id="nama_barang" placeholder="komputer" required>
                                <label class="form-label" for="nama_barang">Nama Barang</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input value="<?php echo $hb ?>" class="form-control" type="text" name="harga_barang" id="harga_barang" placeholder="1000000" required>
                                <label class="form-label" for="harga_barang">Harga Barang</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input value="<?php echo $sb ?>" class="form-control" type="text" name="stok_barang" id="stok_barang" placeholder="100" required>
                                <label class="form-label" for="stok_barang">Stok Barang</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input value="<?php echo $sp ?>" class="form-control" type="text" name="supplier" id="supplier" placeholder="PT. Jaya Abadi" required>
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
                    <?php
                    $sql = "SELECT * FROM barang";
                    $select = mysqli_query($koneksi,$sql);

                    //variabel untuk nilai awal nomor urut tabel
                    $urut = 1;

                    // convert hasil query ke variable data array  
                    while($data = mysqli_fetch_assoc($select))
                    {
                    ?>
                    <tr>
                        <td><?php echo $urut ?></td>
                        <td><?php echo $data['nama_barang']; ?></td>
                        <td><?php echo $data['harga_barang']; ?></td>
                        <td><?php echo $data['stok_barang']; ?></td>
                        <td><?php echo $data['supplier']; ?></td>
                        <td>
                            <a href="?proses=edit&id=<?php echo $data['id'] ?>"><button class="btn btn-warning">edit</button></a>
                            <a href="?proses=delete&id=<?php echo $data['id'] ?>"><button class="btn btn-danger">delete</button></a>
                        </td>
                    </tr>
                    <?php

                    //increment variable $urut, sehingga nilainya bertambah 1 setiap kali looping
                    $urut++;

                    }
                    ?>
                </table>
            </div>
            <div class="col-2"></div>
        </div>
    </div><!-- ini adalah tutup div container -->
    <script src="bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    </body>
</html>
