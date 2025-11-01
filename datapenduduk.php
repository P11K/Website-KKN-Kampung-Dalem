<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
include 'admin/koneksi.php';

$response = [];

if (isset($_GET['year'])) {
    $year = intval($_GET['year']);

    // Ambil data penduduk berdasarkan tahun
    $sql = "SELECT total_penduduk, total_balita, total_lansia, total_ibu_hamil, total_laki, total_perempuan 
            FROM data_penduduk WHERE data_tahun = ? ORDER BY updated_at DESC LIMIT 1";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $response = $result->fetch_assoc();
            $response["year"] = $year; // Tambahkan informasi tahun
        } else {
            $response["error"] = "Data tidak ditemukan untuk tahun $year";
        }
        
        $stmt->close();
    } else {
        $response["error"] = "Query gagal: " . $conn->error;
    }
} else {
    $response["error"] = "Parameter tahun tidak diberikan";
}

// Ambil daftar tahun yang tersedia dari tabel data_penduduk
$year_sql = "SELECT DISTINCT data_tahun FROM data_penduduk ORDER BY data_tahun ASC";
$year_result = $conn->query($year_sql);

$years = [];
if ($year_result) {
    while ($row = $year_result->fetch_assoc()) {
        $years[] = $row['data_tahun'];
    }
} else {
    $response["error"] = "Gagal mengambil daftar tahun: " . $conn->error;
}

// Tambahkan daftar tahun ke dalam respons
$response['available_years'] = $years;

// Jika tidak ada data tahun yang dipilih, kirim tahun terbaru
if (!isset($response['year']) && count($years) > 0) {
    $response['year'] = end($years); // Ambil tahun terbaru
}

echo json_encode($response);

$conn->close();
?>
