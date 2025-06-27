<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pengelolaan Data Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Pengelolaan Data Mahasiswa</h1>

        <?php
        include 'koneksi.php';

        if (isset($_GET['hapus'])) {
            $nim_hapus = $_GET['hapus'];
            $query = "DELETE FROM mahasiswa WHERE nim='$nim_hapus'";
            if (mysqli_query($koneksi, $query)) {
                echo "<p class='text-green-500'>Data berhasil dihapus!</p>";
            } else {
                echo "<p class='text-red-500'>Error: " . mysqli_error($koneksi) . "</p>";
            }
            header("Location: index.php");
            exit();
        }

        if (isset($_POST['simpan'])) {
            $nim = $_POST['nim'];
            $nama = $_POST['nama'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $jurusan = $_POST['jurusan'];
            $alamat = $_POST['alamat'];
            $aksi = $_POST['aksi'];

            if ($aksi == "tambah") {
                $query = "INSERT INTO mahasiswa (nim, nama, jenis_kelamin, jurusan, alamat) VALUES ('$nim', '$nama', '$jenis_kelamin', '$jurusan', '$alamat')";
            } else {
                $query = "UPDATE mahasiswa SET nama='$nama', jenis_kelamin='$jenis_kelamin', jurusan='$jurusan', alamat='$alamat' WHERE nim='$nim'";
            }

            if (mysqli_query($koneksi, $query)) {
                echo "<p class='text-green-500'>Data berhasil disimpan!</p>";
            } else {
                echo "<p class='text-red-500'>Error: " . mysqli_error($koneksi) . "</p>";
            }
            header("Location: index.php");
            exit();
        }

        $page = isset($_GET['page']) ? $_GET['page'] : 'list';

        if ($page == 'tambah' || $page == 'edit') {
            $nim = "";
            $nama = "";
            $jenis_kelamin = "";
            $jurusan = "";
            $alamat = "";
            $aksi = "tambah";

            if ($page == 'edit' && isset($_GET['nim'])) {
                $nim_edit = $_GET['nim'];
                $query = "SELECT * FROM mahasiswa WHERE nim='$nim_edit'";
                $hasil = mysqli_query($koneksi, $query);
                $data = mysqli_fetch_assoc($hasil);

                if ($data) {
                    $nim = $data['nim'];
                    $nama = $data['nama'];
                    $jenis_kelamin = $data['jenis_kelamin'];
                    $jurusan = $data['jurusan'];
                    $alamat = $data['alamat'];
                    $aksi = "edit";
                }
            }
        ?>

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-2xl font-semibold mb-4"><?php echo $aksi == "tambah" ? "Tambah Mahasiswa" : "Edit Mahasiswa"; ?></h2>
            <form action="" method="POST" class="space-y-4">
                <input type="hidden" name="aksi" value="<?php echo $aksi; ?>">
                <div>
                    <label for="nim" class="block text-sm font-medium">NIM</label>
                    <!-- bagian NIM sengaja saya kunci, karena di database NIM adalah primary key, bu -->
                    <input type="text" name="nim" id="nim" value="<?php echo $nim; ?>" class="mt-1 p-2 w-full border rounded-md" <?php echo $aksi == "edit" ? "readonly" : "required"; ?>>
                </div>
                <div>
                    <label for="nama" class="block text-sm font-medium">Nama</label>
                    <input type="text" name="nama" id="nama" value="<?php echo $nama; ?>" class="mt-1 p-2 w-full border rounded-md" required>
                </div>
                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 p-2 w-full border rounded-md" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" <?php echo $jenis_kelamin == "Laki-laki" ? "selected" : ""; ?>>Laki-laki</option>
                        <option value="Perempuan" <?php echo $jenis_kelamin == "Perempuan" ? "selected" : ""; ?>>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label for="jurusan" class="block text-sm font-medium">Jurusan</label>
                    <input type="text" name="jurusan" id="jurusan" value="<?php echo $jurusan; ?>" class="mt-1 p-2 w-full border rounded-md" required>
                </div>
                <div>
                    <label for="alamat" class="block text-sm font-medium">Alamat</label>
                    <textarea name="alamat" id="alamat" class="mt-1 p-2 w-full border rounded-md" required><?php echo $alamat; ?></textarea>
                </div>
                <button type="submit" name="simpan" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Simpan</button>
                <a href="index.php" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Kembali</a>
            </form>
        </div>

        <?php
        } else {
        ?>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Daftar Mahasiswa</h2>
            <a href="?page=tambah" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 mb-4 inline-block">Tambah Mahasiswa</a>
            <table class="w-full border-collapse table-auto">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="border p-3 text-left">NIM</th>
                        <th class="border p-3 text-left">Nama</th>
                        <th class="border p-3 text-left">Jenis Kelamin</th>
                        <th class="border p-3 text-left">Jurusan</th>
                        <th class="border p-3 text-left">Alamat</th>
                        <th class="border p-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM mahasiswa";
                    $hasil = mysqli_query($koneksi, $query);
                    while ($data = mysqli_fetch_assoc($hasil)) {
                        echo "<tr class='hover:bg-gray-100'>";
                        echo "<td class='border p-3'>" . $data['nim'] . "</td>";
                        echo "<td class='border p-3'>" . $data['nama'] . "</td>";
                        echo "<td class='border p-3'>" . $data['jenis_kelamin'] . "</td>";
                        echo "<td class='border p-3'>" . $data['jurusan'] . "</td>";
                        echo "<td class='border p-3'>" . $data['alamat'] . "</td>";
                        echo "<td class='border p-3'>";
                        echo "<a href='?page=edit&nim=" . $data['nim'] . "' class='text-blue-600 hover:underline'>Edit</a> | ";
                        echo "<a href='?hapus=" . $data['nim'] . "' class='text-red-600 hover:underline' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php } ?>
    </div>
</body>
</html>
<?php
mysqli_close($koneksi);
?>