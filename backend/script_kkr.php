<?php
if ($_SESSION['jabatan'] == 3 || $_SESSION['jabatan'] == 4 || $_SESSION['jabatan'] == 5) {
    header('Location: unauthorized');
    exit;
}

if (isset($_POST["tambah"])) {
    $result = create_kas_kkr($_POST);
    if ($result > 0) {
        echo "<script>
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Data Kas Berhasil ditambahkan!',
                    icon: 'success',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'kkr';
                });
              </script>";
    } else if ($result == -1) {
        echo "<script>
                Swal.fire({
                    title: 'Oops...',
                    text: 'Jumlah Kas lebih besar dari sisa Kas yang ada!',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'kkr';
                });
              </script>";
    } else if ($result == -2) {
        echo "<script>
                Swal.fire({
                    title: 'Oops...',
                    text: 'Jumlah harus berupa angka yang valid dan lebih besar dari 0!',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'kkr';
                });
              </script>";
    } else if ($result == -3) {
        echo "<script>
                Swal.fire({
                    title: 'Oops...',
                    text: 'Tipe kas tidak valid!',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'kkr';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Oops...',
                    text: 'Data Kas Gagal Ditambahkan',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'kkr';
                });
              </script>";
    }
}

if (isset($_POST["ubah"])) {
    $result = update_kas_kkr($_POST);
    if ($result > 0) {
        echo "<script>
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Data Kas Berhasil diubah!',
                    icon: 'success',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'kkr';
                });
              </script>";
    } else if ($result == -1) {
        echo "<script>
                Swal.fire({
                    title: 'Oops...',
                    text: 'Jumlah Kas lebih besar dari total Pemasukan yang ada!',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'kkr';
                });
              </script>";
    } else if ($result == -2) {
        echo "<script>
                Swal.fire({
                    title: 'Oops...',
                    text: 'Jumlah harus berupa angka yang valid dan lebih besar dari 0!',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'kkr';
                });
              </script>";
    } else if ($result == -3) {
        echo "<script>
                Swal.fire({
                    title: 'Oops...',
                    text: 'Jumlah baru tidak boleh lebih kecil dari jumlah sebelumnya untuk tipe kas pemasukan!',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'kkr';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Oops...',
                    text: 'Data Kas Gagal Diubah',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'kkr';
                });
              </script>";
    }
}

// script hapus
if (isset($_POST["hapus"])) {
    $id_kas_kkr = (int)$_POST['id_kas_kkr'];
    $result = delete_kas_kkr($id_kas_kkr);
    if ($result > 0) {
        echo "<script>
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Data Kas Berhasil dihapus!',
                    icon: 'success',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'kkr';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Oops...',
                    text: 'Data Kas Gagal Dihapus',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'kkr';
                });
              </script>";
    }
}
