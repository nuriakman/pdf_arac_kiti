<?php 
    
    require_once('kitaplik.php');

    if(isset($_POST["gonder"])) {
        echo "<pre>";
        // print_r($_POST);
        // print_r($_FILES);

        if( isset($_POST["YeniRapor"]) ) {
            $KOMUT = "rm -f ./upload/*.pdf";
            $cevap = shell_exec($KOMUT);
        }


        $arrSayfaSayisi = array();
        
        if(isset($_POST['1haritaONCEKI']))       $arrSayfaSayisi['1harita'] = 0;
        if(isset($_POST['2nufusONCEKI']))        $arrSayfaSayisi['2nufus'] = 0;
        if(isset($_POST['3protokolONCEKI']))     $arrSayfaSayisi['3protokol'] = 0;
        if(isset($_POST['4teskilatONCEKI']))     $arrSayfaSayisi['4teskilat'] = 0;
        if(isset($_POST['5milletvekiliONCEKI'])) $arrSayfaSayisi['5milletvekili'] = 0;
        if(isset($_POST['6ilcelerONCEKI']))      $arrSayfaSayisi['6ilceler'] = 0;
        if(isset($_POST['7secimlerONCEKI']))     $arrSayfaSayisi['7secimler'] = 0;
        if(isset($_POST['8f1ONCEKI']))           $arrSayfaSayisi['8f1'] = 0;
        if(isset($_POST['8f2ONCEKI']))           $arrSayfaSayisi['8f2'] = 0;
        if(isset($_POST['8f3ONCEKI']))           $arrSayfaSayisi['8f3'] = 0;
        if(isset($_POST['8f4ONCEKI']))           $arrSayfaSayisi['8f4'] = 0;
        if(isset($_POST['8f5ONCEKI']))           $arrSayfaSayisi['8f5'] = 0;
        if(isset($_POST['8f6ONCEKI']))           $arrSayfaSayisi['8f6'] = 0;
        if(isset($_POST['8f7ONCEKI']))           $arrSayfaSayisi['8f7'] = 0;
        if(isset($_POST['8f8ONCEKI']))           $arrSayfaSayisi['8f8'] = 0;
        if(isset($_POST['8f9ONCEKI']))           $arrSayfaSayisi['8f9'] = 0;

// echo "<pre>"; print_r($_FILES);



        foreach ($_FILES["8f7"]["name"] as $key => $FILE) {
            // echo "<pre><hr>$key -- $FILE<br>";
            // print_r($_FILES["8f7"]["name"][$key]);

            if( $_FILES["8f7"]["type"][$key] == "application/pdf" ) {
                $KONUM = "./upload/8f7temp.pdf";
                if(move_uploaded_file($_FILES["8f7"]["tmp_name"][$key], $KONUM)) {
                    YataySayfalariCevir("8f7temp");
                    if($key == 0) {
                        $KOMUT = "cp ./upload/8f7temp.pdf ./upload/8f7.pdf";
                        $cevap = shell_exec($KOMUT);
                    } else {
                        SayfaEkle("8f7temp", "8f7");
                    }
                    // echo "$key <span style='color: green;'>Yüklendi</span><br>";
                } else {
                    echo $_FILES["8f7"]["name"][$key] . " <span style='color: red;'>Yüklenemedi</span><br>";
                }
            }
        }
        TempDosyaSil("8f7temp");
        if( $_FILES["8f7"]["name"][0] <> "" ) $arrSayfaSayisi["8f7"] = 0;
        unset($_FILES["8f7"]); // Yukarıda gereklenler yapıldı




        foreach ($_FILES as $key => $FILE) {
            if( $FILE["type"] == "application/pdf" ) {
                $KONUM = "./upload/" . $key . ".pdf";
                if(move_uploaded_file($FILE['tmp_name'], $KONUM)) {
                    // echo "$key <span style='color: green;'>Yüklendi</span><br>";
                    $arrSayfaSayisi[$key] = 0;
                } else {
                    echo "$key <span style='color: red;'>Yüklenemedi</span><br>";
                }
            }
        }

        // Sadece File Upload sonrasında YATAY sayfaları düzeltme işlemi uyguluyoruz
        if( $_FILES["8f1"]["name"]       <> "" ) YataySayfalariCevir("8f1");
        if( $_FILES["8f2"]["name"]       <> "" ) YataySayfalariCevir("8f2");
        if( $_FILES["8f3"]["name"]       <> "" ) YataySayfalariCevir("8f3");
        if( $_FILES["8f4"]["name"]       <> "" ) YataySayfalariCevir("8f4");
        if( $_FILES["8f5"]["name"]       <> "" ) YataySayfalariCevir("8f5");
        if( $_FILES["8f6"]["name"]       <> "" ) YataySayfalariCevir("8f6");
        if( $_FILES["8f7"]["name"][0]    <> "" ) YataySayfalariCevir("8f7"); // Çoklu yükleme olduğu için
        if( $_FILES["8f8"]["name"]       <> "" ) YataySayfalariCevir("8f8");
        if( $_FILES["8f9"]["name"]       <> "" ) YataySayfalariCevir("8f9");
        if( $_FILES["7secimler"]["name"] <> "" ) YataySayfalariCevir("7secimler");

        // echo "<pre>"; print_r($arrSayfaSayisi);

        include("birlestirme.php");
    
    } // Form Posted
