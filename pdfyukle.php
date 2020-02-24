<?php

    if(isset($_POST["gonder"])) {
        require_once("upload.php");
    }

    chdir("./upload/");
    $arrMevcutlar = glob("*.pdf");
    chdir("..");
    function OncesiVarMi($Dosya) {
        global $arrMevcutlar;
        if(in_array($Dosya . ".pdf", $arrMevcutlar)) echo "checked";
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>İl Raporu Hazırlama</title>
</head>
<body >

    <form method="post" enctype="multipart/form-data">
    <h1>İl Raporu Hazırlama</h1>
    <p><a href='index.php'>Ana Sayfaya Git</a></p>
    <p>PDF Dosyalarınızı yükleyiniz...</p>

<!--    <p><a href='sayfalariduzenle.php'>Sayfaları Düzenle</a></p> -->

    <p><label><input type="checkbox" name="YeniRapor"> Yeni bir İL RAPORU'na başlıyoruz. Eski dosyalar silinsin.</label></p>
    <p><input type="submit" name="gonder" value="Gönder"></p>

    <table border="1" cellpadding="10" cellpadding="0">
        <tr>
            <td>1-Harita</td>
            <td><input type="file" name="1harita"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("1harita"); ?> name="1haritaONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>2-Nüfus</td>
            <td><input type="file" name="2nufus"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("2nufus"); ?> name="2nufusONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>3-Protokol</td>
            <td><input type="file" name="3protokol"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("3protokol"); ?> name="3protokolONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>4-Teşkilat</td>
            <td><input type="file" name="4teskilat"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("4teskilat"); ?> name="4teskilatONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>5-Milletvekili</td>
            <td><input type="file" name="5milletvekili"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("5milletvekili"); ?> name="5milletvekiliONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>6-İlçeler</td>
            <td><input type="file" name="6ilceler"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("6ilceler"); ?> name="6ilcelerONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>7-Seçimler</td>
            <td><input type="file" name="7secimler"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("7secimler"); ?> name="7secimlerONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>8-Faaliyet Raporu 1</td>
            <td><input type="file" name="8f1"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("8f1"); ?> name="8f1ONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>8-Faaliyet Raporu 2</td>
            <td><input type="file" name="8f2"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("8f2"); ?> name="8f2ONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>8-Faaliyet Raporu 3</td>
            <td><input type="file" name="8f3"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("8f3"); ?> name="8f3ONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>8-Faaliyet Raporu 4</td>
            <td><input type="file" name="8f4"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("8f4"); ?> name="8f4ONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>8-Faaliyet Raporu 5</td>
            <td><input type="file" name="8f5"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("8f5"); ?> name="8f5ONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>8-Faaliyet Raporu 6</td>
            <td><input type="file" checked name="8f6"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("8f6"); ?> name="8f6ONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>8-Faaliyet Raporu 7 (Çoklu Seçim)</td>
            <td><input type="file" multiple name="8f7[]"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("8f7"); ?> name="8f7ONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>8-Faaliyet Raporu 8</td>
            <td><input type="file" name="8f8"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("8f8"); ?> name="8f8ONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
        <tr>
            <td>8-Faaliyet Raporu 9</td>
            <td><input type="file" name="8f9"></td>
            <td><label><input type="checkbox" <?php OncesiVarMi("8f9"); ?> name="8f9ONCEKI"> Son yükleneni kulllan</label></td>
        </tr>
    </table>

    <p>&nbsp;</p>

    <p><input type="submit" name="gonder" value="Gönder"></p>

    <p>Aynı anda hem dosya seçilir, hem de "Son yükleneni kullan" işaretlenirse, yüklenen dosya kullanılır</p>
    <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>


    </form>
    </body>
</html>