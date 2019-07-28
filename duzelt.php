<?php
$servername = "localhost";
$username   = "root";
$password   = "root";
$dbname     = "bilgiler";

// Veritabanı bağlantısının oluşturulması
$db = mysqli_connect($servername, $username, $password, $dbname);
// Varsa, bağlantı hatasının ekrana yazdırılarak programın sonlandırılması
if (!$db) { die("Hata oluştu: " . mysqli_connect_error()); }
//echo "Bağlantı tamam!";

// Oluşabilecek Türkçe karakter gösterimi sorunlarını giderelim...
mysqli_query($db, "set names 'utf8'");

    $SQL   = "SELECT * FROM bulmaca -- limit 10";
    $rows  = mysqli_query($db, $SQL);

    while($row = mysqli_fetch_assoc($rows)) { // Kayıt adedince döner
      $soru  = $row["soru"];
      $cevap = $row["cevap"];

      $arrKelimeler = explode(",", $cevap);

      foreach ($arrKelimeler as $key => $value) {
        $value = trim($value);
        $SQL1 = "INSERT INTO bulmaca_son SET soru='$soru', cevap='$value'";
        echo "$SQL1 <br>";
        $temp  = mysqli_query($db, $SQL1);
      }

    }
