<?php
session_start();

// Restrict access based on jabatan
if ($_SESSION['jabatan'] == 3 || $_SESSION['jabatan'] == 5 || $_SESSION['jabatan'] == 6) {
    header('Location: unauthorized'); // Redirect to an unauthorized access page
    exit;
}

require('../vendor/setasign/fpdf/fpdf.php');
require '../config/database.php'; // Ensure this file contains the database connection

date_default_timezone_set('Asia/Jakarta'); // Change to your timezone

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('../assets/img/logo.png', 10, 6, 30); // Adjust the path and size as needed
        // Arial bold 15
        $this->SetFont('Times', 'B', 14);
        // Title
        $this->Cell(0, 10, 'SMA MAITREYAWIRA TANJUNGPINANG', 0, 1, 'C');
        $this->Cell(0, 10, 'Jl. Ir. Sutami No.66, Tj. Pinang Timur, Kec. Bukit Bestari', 0, 1, 'C');
        $this->Cell(0, 10, 'Kota Tanjung Pinang, Kepulauan Riau 29122', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        // Draw line
        $this->Line(10, 40, 200, 40);
        $this->Ln(3);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 10);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Create instance of PDF class
$pdf = new PDF();
$pdf->AddPage();

// Get current date
$tanggal_cetak = date('d/m/Y H:i:s');
$nama_pencetak = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';

// Set default bulan dan tahun ke bulan dan tahun saat ini
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$tipe_kas = isset($_GET['tipe_kas']) ? $_GET['tipe_kas'] : 'semua';
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

// Array nama bulan
$nama_bulan = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];

// Prepare query for PDF report (no LIMIT and OFFSET)
$query = "
    SELECT kas_pramuka.*, users.nama 
    FROM kas_pramuka 
    JOIN users ON kas_pramuka.id_user = users.id_user 
    WHERE MONTH(kas_pramuka.created_at) = ? 
    AND YEAR(kas_pramuka.created_at) = ?";

$params = [$bulan, $tahun];

if ($tipe_kas != 'semua') {
    $query .= " AND kas_pramuka.tipe_kas = ?";
    $params[] = $tipe_kas;
}
if (!empty($cari)) {
    $query .= " AND (kas_pramuka.keterangan LIKE ? OR kas_pramuka.jumlah LIKE ?)";
    $params[] = "%$cari%";
    $params[] = "%$cari%";
}

$query .= " ORDER BY kas_pramuka.created_at DESC";

// Prepare statement
$stmt = $conn->prepare($query);

// Bind parameters dynamically
$types = str_repeat('s', count($params));
$stmt->bind_param($types, ...$params);

$stmt->execute();
$result = $stmt->get_result();
$data_pramuka = $result->fetch_all(MYSQLI_ASSOC);

// Calculate monthly totals
$total_pemasukan = 0;
$total_pengeluaran = 0;

// Sort data by oldest first
usort($data_pramuka, function ($a, $b) {
    return strtotime($a['created_at']) - strtotime($b['created_at']);
});

foreach ($data_pramuka as $pramuka) {
    if ($pramuka['tipe_kas'] == 'pemasukan') {
        $total_pemasukan += $pramuka['jumlah'];
    } else if ($pramuka['tipe_kas'] == 'pengeluaran') {
        $total_pengeluaran += $pramuka['jumlah'];
    }
}

// Calculate universal totals
$query_universal_pemasukan = "SELECT SUM(jumlah) as total_pemasukan FROM kas_pramuka WHERE tipe_kas='pemasukan'";
$query_universal_pengeluaran = "SELECT SUM(jumlah) as total_pengeluaran FROM kas_pramuka WHERE tipe_kas='pengeluaran'";

$stmt_universal_pemasukan = $conn->prepare($query_universal_pemasukan);
$stmt_universal_pemasukan->execute();
$result_universal_pemasukan = $stmt_universal_pemasukan->get_result();
$data_universal_pemasukan = $result_universal_pemasukan->fetch_assoc();
$universal_pemasukan_pramuka = $data_universal_pemasukan['total_pemasukan'] ?? 0;

$stmt_universal_pengeluaran = $conn->prepare($query_universal_pengeluaran);
$stmt_universal_pengeluaran->execute();
$result_universal_pengeluaran = $stmt_universal_pengeluaran->get_result();
$data_universal_pengeluaran = $result_universal_pengeluaran->fetch_assoc();
$universal_pengeluaran_pramuka = $data_universal_pengeluaran['total_pengeluaran'] ?? 0;

$universal_total_kas_pramuka = $universal_pemasukan_pramuka - $universal_pengeluaran_pramuka;

// Output the results (example)
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 10, 'LAPORAN KAS Pramuka', 0, 1, 'C');

$bulan_int = (int)$bulan;
$pdf->SetFont('Times', 'I', 12);
$pdf->Cell(0, 10, 'Dicetak oleh: ' . $nama_pencetak, 0, 1);
$pdf->Ln(0);

$pdf->SetFont('Times', 'I', 12);
$pdf->Cell(0, 10, 'Tanggal Cetak: ' . $tanggal_cetak, 0, 1);
$pdf->Ln(2);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(0, 10, 'Bulan: ' . $nama_bulan[$bulan_int] . ' ' . $tahun, 0, 1);
$pdf->Ln(2);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(60, 10, 'Total Pemasukan Bulan Ini:', 0, 0, 'L');
$pdf->Cell(30, 10, 'Rp ' . number_format($total_pemasukan, 0, ',', '.'), 0, 1, 'R');

$pdf->Cell(60, 10, 'Total Pengeluaran Bulan Ini:', 0, 0, 'L');
$pdf->Cell(30, 10, 'Rp ' . number_format($total_pengeluaran, 0, ',', '.'), 0, 1, 'R');

$pdf->Cell(60, 10, 'Sisa Kas (Universal):', 0, 0, 'L');
$pdf->Cell(30, 10, 'Rp ' . number_format($universal_total_kas_pramuka, 0, ',', '.'), 0, 1, 'R');
$pdf->Ln(4);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(10, 10, 'No', 1);
$pdf->Cell(40, 10, 'Tanggal Kas', 1);
$pdf->Cell(40, 10, 'Tipe Kas', 1);
$pdf->Cell(40, 10, 'Jumlah Kas', 1);
$pdf->Cell(60, 10, 'Keterangan', 1);
$pdf->Ln();

$pdf->SetFont('Times', '', 12);
$no = 1;
foreach ($data_pramuka as $pramuka) {
    $pdf->Cell(10, 10, $no++, 1);
    $pdf->Cell(40, 10, date('d/m/Y H:i', strtotime($pramuka['created_at'])), 1);

    // Set color for tipe_kas
    if ($pramuka['tipe_kas'] == 'pemasukan') {
        $pdf->SetTextColor(0, 0, 255); // Set color to blue
    } else {
        $pdf->SetTextColor(255, 0, 0); // Set color to red
    }
    $pdf->Cell(40, 10, htmlspecialchars($pramuka['tipe_kas']), 1);

    // Reset to default color (black) for the rest of the cells
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(40, 10, 'Rp ' . number_format($pramuka['jumlah'], 0, ',', '.'), 1);
    $pdf->Cell(60, 10, htmlspecialchars($pramuka['keterangan']), 1);
    $pdf->Ln();
}
$pdf->Ln(4);
// Format tanggal saat ini
$tanggalPrint = date('d F Y');  // Misalnya: 20 Oktober 2024
// Menampilkan lokasi dan tanggal print di kanan
$pdf->Cell(0, 10, "Tanjungpinang, $tanggalPrint", 0, 1, 'R');
// Memberi ruang untuk tanda tangan
$pdf->Ln(20);
// Menampilkan garis tanda tangan
$pdf->Cell(0, 10, '__________________________', 0, 1, 'R');
// Label "Penanggung Jawab"
$pdf->Cell(0, 10, $_SESSION['nama'], 0, 1, 'R');
// Output the PDF
$pdf->Output('D', 'Laporan Kas PRAMUKA Bulan ' . $bulan . ' Tahun ' . $tahun . '.pdf');
