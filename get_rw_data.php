<?php
require 'admin/koneksi.php';

if (isset($_GET['lkk_id'])) {
    $lkk_id = intval($_GET['lkk_id']); // Pastikan input aman dari SQL Injection

    $query_rw = "
        SELECT 'rw' AS kategori, nama, alamat, jabatan, no_hp, foto 
        FROM rw 
        WHERE lkk_id = $lkk_id AND nama IS NOT NULL
    ";

    $result_rw = $conn->query($query_rw);
    $rw_data = [];

    if ($result_rw->num_rows > 0) {
        while ($row = $result_rw->fetch_assoc()) {
            $rw_data[] = $row;
        }
    }

    echo json_encode($rw_data);
}

?>
