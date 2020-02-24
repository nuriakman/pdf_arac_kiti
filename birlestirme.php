<?php 

    require_once('kitaplik.php');

    // upload klasörüne boş sayfayı kopyalayalım...
    $KOMUT = "cp 0bossayfa.pdf ./upload/";
    $cevap = shell_exec($KOMUT);

    $Hata = 0;

    if(!isset($arrSayfaSayisi['1harita']))       $Hata = 1;
    if(!isset($arrSayfaSayisi['2nufus']))        $Hata = 1;
    if(!isset($arrSayfaSayisi['3protokol']))     $Hata = 1;
    if(!isset($arrSayfaSayisi['4teskilat']))     $Hata = 1;
    if(!isset($arrSayfaSayisi['5milletvekili'])) $Hata = 1;
    if(!isset($arrSayfaSayisi['6ilceler']))      $Hata = 1;
    if(!isset($arrSayfaSayisi['7secimler']))     $Hata = 1;
    
    if( isset($arrSayfaSayisi['8f1']) or
        isset($arrSayfaSayisi['8f2']) or
        isset($arrSayfaSayisi['8f3']) or
        isset($arrSayfaSayisi['8f4']) or
        isset($arrSayfaSayisi['8f5']) or
        isset($arrSayfaSayisi['8f6']) or
        isset($arrSayfaSayisi['8f7']) or
        isset($arrSayfaSayisi['8f8']) or
        isset($arrSayfaSayisi['8f9'])) $Hata = 0; else $Hata = 1;
   
    asort($arrSayfaSayisi);

    if($Hata == 1) {
        echo "<h1>Eksik bölümler var...</h1>";
        echo "<p>Mevcut bölümler: </p>";
        echo "<ul>";
        foreach ($arrSayfaSayisi as $key => $value) {
            echo "<li>$key</li>";
        };
        echo "</ul>";
        echo "<p></p>";

        echo "<br>Bitti...<br><br><br>";
        echo "<a href='index.php'>Dosya yükleme ekranına git</a>";
        die();
    }

    $Hata = 0;
    foreach ($arrSayfaSayisi as $key => $value) {
        $arrSayfaSayisi[$key] = PDFDosyaSayfaSayisi($key);
        // echo "$key -- " . $arrSayfaSayisi[$key] . "<br>";
        if($arrSayfaSayisi[$key] == 0) {
            $Hata = 1;
            echo "<br><b>$key</b> Dosyasının sayfa sayısı tespit edilemedi";
        }
    };

    
    // echo "<h1>Sayfa Sayıları:</h1><pre>"; print_r($arrSayfaSayisi);
    $arrHata = array();






    $TOPLAMSAYFA = 0;
    $TOPLAMSAYFA = SayfaEkle(""); // Sonuç dosyasını oluşturmaya başlıyoruz. Var olan sonuç dosyasını silelim.

    // Burada yapılan kontroller SAYFA SAYISI içindir
    $TOPLAMSAYFA = SayfaEkle("1harita");

    $TOPLAMSAYFA = SiradakiSayfaSagdaOlsun($TOPLAMSAYFA);
    $TOPLAMSAYFA = SayfaEkle("2nufus");

    if($arrSayfaSayisi["3protokol"] > 1) {
        $TOPLAMSAYFA = SiradakiSayfaSagdaOlsun($TOPLAMSAYFA);
        $TOPLAMSAYFA = SayfaEkle("3protokol");
    }

    if($arrSayfaSayisi["3protokol"] == 1) {
        $TOPLAMSAYFA = SayfaEkle("3protokol");
    }


    $TeskilatSayfaAdedi = $arrSayfaSayisi["4teskilat"];
    SayfalariAyir("4teskilat", 1, 1, "ValiSayfasi");
    SayfalariAyir("4teskilat", $TeskilatSayfaAdedi, $TeskilatSayfaAdedi, "FaaliyetKapak");
    SayfalariAyir("4teskilat", $TeskilatSayfaAdedi-1, $TeskilatSayfaAdedi-1, "SecimKapak");
    SayfalariAyir("4teskilat", 2, $TeskilatSayfaAdedi-2, "TeskilatGorevlileri");
    SayfalariAyir("7secimler", 1, 3, "IlSecimSonucu");


    $TOPLAMSAYFA = SayfaEkle("ValiSayfasi");
    $TOPLAMSAYFA = SayfaEkle("5milletvekili");
    $TOPLAMSAYFA = SayfaEkle("TeskilatGorevlileri");
    $TOPLAMSAYFA = SiradakiSayfaSagdaOlsun($TOPLAMSAYFA);
    $TOPLAMSAYFA = SayfaEkle("SecimKapak");
    $TOPLAMSAYFA = SayfaEkle("IlSecimSonucu");
    
    for($i=1; $i <= $arrSayfaSayisi['6ilceler']; $i=$i+3) {
        SayfalariAyir("6ilceler",  $i, $i+2, "tempIlce");
        SayfalariAyir("7secimler", $i+3, $i+3+2, "tempSecim");
        $TOPLAMSAYFA = SayfaEkle("tempIlce");  // ILCE KAPAK
        $TOPLAMSAYFA = SayfaEkle("tempSecim"); // ILCE SECIM
        TempDosyaSil("tempIlce");
        TempDosyaSil("tempSecim");
    }

    $TOPLAMSAYFA = SiradakiSayfaSagdaOlsun($TOPLAMSAYFA);
    $TOPLAMSAYFA = SayfaEkle("FaaliyetKapak");


    TempDosyaSil("ValiSayfasi");
    TempDosyaSil("FaaliyetKapak");
    TempDosyaSil("TeskilatGorevlileri");
    TempDosyaSil("SecimKapak");
    TempDosyaSil("IlSecimSonucu");


    for($i=1; $i <= 9; $i++) {
        $Rapor = "8f" . trim("$i");
        if($arrSayfaSayisi[$Rapor] > 0) {
            $TOPLAMSAYFA = SiradakiSayfaSagdaOlsun($TOPLAMSAYFA);
            $TOPLAMSAYFA = SayfaEkle($Rapor);
        }
    }

    SayfalariAyir("SONUC", 3, $TOPLAMSAYFA, "ILRAPORU");
    TempDosyaSil("SONUC");

    echo "<p><a href='./upload/ILRAPORU.pdf' target='_blank'>İl Raporu ILRAPORU.pdf</a></p>";

echo "<h1>İl Raporu Hazırlama</h1>";
echo "<h3>İşlem tamamlandı.</h3>";
echo "<p><a href='pdfduzenle.php'>İl Raporunun Sayfalarını Düzenleyin</a></p>";
echo "<p><a href='./upload/ILRAPORU.pdf'>İl Raporunu İndir: <b>ILRAPORU.pdf</b></a></p>";
echo "<a href='index.php'>Ana Sayfaya Git</a>";
die();

