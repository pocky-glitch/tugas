<?php
// Fungsi untuk menghitung diskon berdasarkan total belanja.
function hitungDiskon($totalBelanja) {
    $diskon = 0;

    if ($totalBelanja >= 100000) {
        $diskon = 0.10 * $totalBelanja;
    } elseif ($totalBelanja >= 50000) {
        $diskon = 0.05 * $totalBelanja;
    }

    return $diskon;
}

// Fungsi untuk menampilkan angka dalam format Rupiah.
function rupiah($angka) {
    return "Rp " . number_format($angka, 0, ",", ".");
}

$totalBelanja = 0;
$diskon = 0;
$totalBayar = 0;
$persentase = 0;
$sudahDihitung = false;
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = $_POST["totalBelanja"] ?? "";

    if ($input === "" || !is_numeric($input) || (float)$input < 0) {
        $error = "Masukkan jumlah belanja yang valid!";
    } else {
        $totalBelanja = (float)$input;
        $diskon = hitungDiskon($totalBelanja);
        $totalBayar = $totalBelanja - $diskon;

        if ($totalBelanja >= 100000) {
            $persentase = 10;
        } elseif ($totalBelanja >= 50000) {
            $persentase = 5;
        }

        $sudahDihitung = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Diskon</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main class="container">
        <header class="header">
            <div class="icon">%</div>
            <h1>Kalkulator Diskon</h1>
            <p>Hitung diskon belanja dengan mudah dan cepat</p>
        </header>

        <form method="POST" action="">
            <div class="form-group">
                <label for="totalBelanja">Masukkan Total Belanja (Rupiah)</label>
                <input
                    type="number"
                    id="totalBelanja"
                    name="totalBelanja"
                    placeholder="Contoh: 120000"
                    min="0"
                    step="any"
                    value="<?= isset($_POST['totalBelanja']) ? htmlspecialchars($_POST['totalBelanja']) : '' ?>"
                    required
                >
            </div>
            <button type="submit">Hitung Diskon</button>
        </form>

        <?php if ($error !== ""): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($sudahDihitung): ?>
            <section class="result" aria-live="polite">
                <h2>Hasil Perhitungan</h2>
                <div class="row">
                    <span>Total Belanja</span>
                    <strong><?= rupiah($totalBelanja) ?></strong>
                </div>
                <div class="row">
                    <span>Persentase Diskon</span>
                    <strong class="discount"><?= $persentase ?>%</strong>
                </div>
                <div class="row">
                    <span>Jumlah Diskon</span>
                    <strong class="discount">- <?= rupiah($diskon) ?></strong>
                </div>
                <div class="row total">
                    <span>Total Bayar</span>
                    <strong><?= rupiah($totalBayar) ?></strong>
                </div>
            </section>
        <?php endif; ?>

        <section class="rules">
            <h2>Ketentuan Diskon</h2>
            <p>Belanja ≥ Rp100.000: diskon 10%</p>
            <p>Belanja ≥ Rp50.000: diskon 5%</p>
            <p>Belanja di bawah Rp50.000: tidak ada diskon</p>
        </section>

        <footer class="footer">
            Program PHP - Menghitung Diskon Belanja
        </footer>
    </main>
</body>
</html>
