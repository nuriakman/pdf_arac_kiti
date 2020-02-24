<?php
    $Mesaj = 0;
    if( isset($_GET["islem"]) and $_GET["islem"] == "ResimOlustur" ) {
        $KOMUT = "convert -density 60 ILRAPORU.pdf -quality 80 pul/sayfa-%04d.jpg";
        $cevap = shell_exec($KOMUT);
        $Mesaj = 1;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>İl Raporu Sayfalarını Düzenleme</title>
</head>
<body >

    <form method="post" action="" enctype="multipart/form-data">

        <h1>İl Raporu Sayfalarını Düzenleme Hazırlama</h1>
        
        <?php if($Mesaj == 1) echo "<h3 style='color:green;'>İşlem başarılı</h3>"; ?>
        <p><a href='?islem=ResimOlustur'>Sayfa Önizlemeyi Hazırla</a> Bu işlem 1 dk kadar sürebilir, sabırlı olunuz.</p>
        <p><a href='?islem=ResimGoster'>Sayfaların Pul Görüntülerini Göster</a></p>

    <style>
        body {
            background-color:  lightgrey;
        }
        img {
            margin: 5px;
            border: 1px solid grey;
            height: 100px;
        }
    </style>

        <?php 
            if( isset($_GET["islem"]) and $_GET["islem"] == "ResimGoster") {
                chdir("./pul/");
                $Resimler = glob("sayfa*.jpg");
                chdir("..");
                foreach ($Resimler as $Resim) {
                    echo "<img src='pul/$Resim'>";
                }
            }
        ?>


        <p><input type="submit" name="gonder" value="Gönder"></p>

        <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>


    </form>
    </body>
</html>