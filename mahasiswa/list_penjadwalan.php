<?php
// Koneksi ke database
require '../config/database.php';

// Mendapatkan data dari database dengan ID ganjil
$stmt = $pdo->query("SELECT * FROM jadwal_lab WHERE id % 2 <> 0");
$jadwals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include '../component/header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>Daftar Jadwal Lab</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-buttons a {
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .edit-button {
            background-color: #4CAF50;
            color: white;
        }

        .delete-button {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>

<body>
    <h1>Daftar Jadwal Lab</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Waktu</th>
                <th>Kegiatan</th>
                <th>Angkatan</th>
                <th>Prodi</th>
                <th>Ruangan 1</th>
                <th>Ruangan 2</th>
                <th>Kelas 1</th>
                <th>Kelas 2</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jadwals as $index => $jadwal): ?>
                <tr>
                    <td><?= $index + 1; ?></td>
                    <td><?= htmlspecialchars($jadwal['hari']); ?></td>
                    <td><?= htmlspecialchars($jadwal['waktu']); ?></td>
                    <td><?= htmlspecialchars($jadwal['kegiatan']); ?></td>
                    <td><?= htmlspecialchars($jadwal['angkatan']); ?></td>
                    <td><?= htmlspecialchars($jadwal['prodi']); ?></td>
                    <td><?= htmlspecialchars($jadwal['ruangan1']); ?></td>
                    <td><?= htmlspecialchars($jadwal['ruangan2']); ?></td>
                    <td><?= htmlspecialchars($jadwal['kelas1']); ?></td>
                    <td><?= htmlspecialchars($jadwal['kelas2']); ?></td>
                    <td class="action-buttons">
                        <a href="delete_jadwal.php?id=<?= $jadwal['id']; ?>" class="delete-button" data-id="<?= $jadwal['id']; ?>">Delete</a>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        document.querySelectorAll('.delete-button').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah link melakukan tindakan default (redirect)

                var href = this.getAttribute('href'); // Ambil link href (URL untuk delete)

                // SweetAlert2 untuk konfirmasi penghapusan
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user mengonfirmasi penghapusan, redirect ke URL penghapusan
                        window.location.href = href;
                    }
                });
            });
        });
        // Fungsi untuk mendapatkan parameter dari URL
        function getParameterByName(name) {
            name = name.replace(/[\[\]]/g, '\\$&');
            const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(window.location.href);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        // Ambil status dan pesan dari URL
        const status = getParameterByName('status');
        const message = getParameterByName('message');

        if (status && message) {
            if (status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: message,
                    confirmButtonText: 'OK'
                });
            } else if (status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: message,
                    confirmButtonText: 'OK'
                });
            }
        }
    </script>
</body>

</html>


<?php include '../component/footer.php'; ?>