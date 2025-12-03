<?php
echo "=== TEST KONEKSI DATABASE ===<br><br>";

// Test 1: Cek file database.php
echo "1. Cek file database.php...<br>";
$db_file = __DIR__ . '/../../../config/database.php';
echo "Path: $db_file<br>";

if (file_exists($db_file)) {
    echo "✅ File ditemukan!<br><br>";
    include $db_file;
} else {
    die("❌ File tidak ditemukan!<br>");
}

// Test 2: Cek class Database
echo "2. Cek class Database...<br>";
if (class_exists('Database')) {
    echo "✅ Class Database ada!<br><br>";
} else {
    die("❌ Class Database tidak ditemukan!<br>");
}

// Test 3: Buat instance dan koneksi
echo "3. Test koneksi...<br>";
$db = new Database();
$conn = $db->getConnection();

echo "Hasil getConnection(): ";
var_dump($conn);
echo "<br><br>";

if ($conn === null) {
    die("❌ Koneksi NULL!<br>");
}

// Test 4: Test query
echo "4. Test query database...<br>";
$result = $conn->query("SHOW TABLES");

if ($result) {
    echo "✅ Query berhasil!<br>";
    echo "Tabel yang ada:<br>";
    while ($row = $result->fetch_array()) {
        echo "- " . $row[0] . "<br>";
    }
} else {
    echo "❌ Query gagal: " . $conn->error . "<br>";
}

$conn->close();
echo "<br>✅ Semua test selesai!";
?>