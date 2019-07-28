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
?>

<div class="alert alert-success" role="alert">
  Deyim içinde geçen bir ifade veya kelimeyi yazınız
</div>

<div class="alert alert-info" role="alert">

  <?php

    // Gösterim sayacını artır..
    $rows  = mysqli_query($db, "UPDATE deyimler_sayac SET gosterim=gosterim+1 WHERE id=1");

  
    // Veri tabanındaki DEYİMADI alanınının İLK HARFİNİ -TEKİL- olarak al, Sırala
    $SQL   = "SELECT DISTINCT left(deyim_adi, 1) as HARF FROM deyimler ORDER BY 1";
    $rows  = mysqli_query($db, $SQL);

    while($row = mysqli_fetch_assoc($rows)) { // Kayıt adedince döner
        // Her bir harf için linkleri hazırla
        echo sprintf("<a style='width: 2em; margin: 2px;' class='btn btn-primary btn-sm badge' href='index.php?harf=%s'>%s</a>", $row["HARF"], $row["HARF"] );
    }
  ?>

</div>

<form method="get" autocomplete="off">
  Aranılan sözcük: <input type="text" name="aranansozcuk" placeholder="Aranan Sözcük" value="<?php echo $_GET["aranansozcuk"];?>">
  <input class="btn btn-success" type="submit" value="Ara !">
</form>


<?php if( (isset( $_GET["aranansozcuk"] ) and trim($_GET["aranansozcuk"]) <> "") or
          (isset( $_GET["harf"] )         and trim($_GET["harf"])         <> "")    ){  // Arama formu gönderilmiş VEYA bir harfe tıklanmış! ?>

  <h1 class="mt-5">Arama Sonucu</h1>

  <table class="table table-hover text-left">
      <tr class="table-success">
        <th scope="col">Açıklaması</th>
      </tr>

    <?php

    // Arama sayacını artır...
    $rows  = mysqli_query($db, "UPDATE deyimler_sayac SET arama=arama+1 WHERE id=1");


    if(isset( $_GET["aranansozcuk"] )){
      $SQL   = "SELECT deyim_adi, deyim_aciklama FROM deyimler WHERE deyim_adi LIKE '%{$_GET["aranansozcuk"]}%' ORDER BY deyim_adi";
    }
    if(isset( $_GET["harf"] )){
      $SQL   = "SELECT deyim_adi, deyim_aciklama FROM deyimler WHERE deyim_adi LIKE '{$_GET["harf"]}%' ORDER BY deyim_adi";
    }

    $rows  = mysqli_query($db, $SQL);

    while($row = mysqli_fetch_assoc($rows)) { // Kayıt adedince döner
        echo sprintf("
          <tr>
            <td>
            <b style='font-size: 1.4em;' class='text-success'>%s</b><br />
            %s
            </td>
          </tr>",
          $row["deyim_adi"], $row["deyim_aciklama"] );
    }

    ?>
  </table>
<?php } // Arama formu gönderilmiş VEYA bir harfe tıklanmış!  ?>


<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
