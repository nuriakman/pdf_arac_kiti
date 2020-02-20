<?php

    // KAYNAK: https://www.pdflabs.com/docs/pdftk-man-page/

/*

pdftk A=rapor.pdf B=bos.pdf cat B1 A3-7 B1 A9-10 B1 A9 output SONUC.pdf

pdftk A=rapor.pdf B=bos.pdf cat A1 A1left A1right  A3-7 B1 A9-10 B1 A9 output SONUC.pdf


Otomatik tum sayfalari ayri pdf yap
Otomatik her x sayfayi bir pdf yap
Her pdf yi booklet formatina getirerek (toplam sayfa sayisi 4 un kati) birlestir
N tane pdf dosyasi birlestirilebilsin
Her dosyanin birlesim on arayizunde ayri ayri sayfa sayilari ve toplam sayfa sayisi gorunsun.
Pdf korumasi ekleme
Korumayi kaldirma


*/

    if( isset($_POST["toplamsayfa"]) ) {
        echo "<pre>";
        print_r($_POST);
        print_r($_FILES);
        echo "</pre>";
    }

/*

Array
(
    [BosSayfalar] => 1,2,3
    [YeniPDF_Baslama] => 50
    [YeniPDF_Sayfalar] => 1,2,3,50-60
    [gonder] => Gönder
    [toplamsayfa] => 116
)
Array
(
    [YeniPDF] => Array
        (
            [name] => Array
                (
                    [1] => Karbon Grup DNA.pdf
                )

            [type] => Array
                (
                    [1] => application/pdf
                )

            [tmp_name] => Array
                (
                    [1] => /tmp/phpkd9d2V
                )

            [error] => Array
                (
                    [1] => 0
                )

            [size] => Array
                (
                    [1] => 3255536
                )

        )

)




*/    

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PDF Araç Kiti</title>
</head>
<body >

    <form id="form1" method="post" action="" enctype="multipart/form-data">

        <h1>PDF Araç Kiti</h1>

        <!-- <p><a href='index.php'>Ana Sayfaya Git</a></p> -->

<fieldset style='width:50%'>
    <legend><b style='color: darkred;'>PDF Dosyanız:</b></legend>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <td nowrap="nowrap">
                Üzerinde çalışacağınız dosya
            </td>
            <td nowrap="nowrap">
                <input type='file' name='AnaDosya' multiple>
            </td>
        </tr>
    </table>
</fieldset>

<br><br>

<fieldset style='width:50%'>
    <legend><b style='color: darkred;'>Çoklu PDF Dosya İşlemleri</b></legend>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <td nowrap="nowrap">
                Tümün birleştir (Çoklu dosya seçiniz)
            </td>
            <td nowrap="nowrap">
                <input type='file' name='TopluPDF[]' multiple>
            </td>
        </tr>
        <tr>
            <td nowrap="nowrap">
                Birleştirmeler sağ sayfadan başlasın
            </td>
            <td nowrap="nowrap">
                <input type="checkbox" name="SagSayfadaBirlestir">
            </td>
        </tr>
        <tr>
            <td nowrap="nowrap">
                Bitince özet göster
            </td>
            <td nowrap="nowrap">
                <input type="checkbox" name="BitinceOzetGoster">
            </td>
        </tr>
    </table>
</fieldset>

<br><br>

<fieldset style='width:50%'>
    <legend><b style='color: darkred;'>Yapılacak İş Seçimi:</b></legend>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <td nowrap="nowrap">
                PDF'in her biri X sayfalık kitapçık (booklet) yap
            </td>
            <td nowrap="nowrap">
                <input type="text" name="BookletSayfaAdedi" placeholder="Örnek: 60" style="width: 250px;">
            </td>
        </tr>
        <tr>
            <td nowrap="nowrap">
                Her sayfayı ayrı PDF yap
            </td>
            <td nowrap="nowrap">
                <input type="checkbox" name="TumunuPDFYap">
            </td>
        </tr>
        <tr>
            <td nowrap="nowrap">
                Her X sayfayı sayfaları ayrı PDF yap
            </td>
            <td nowrap="nowrap">
                <input type="text" name="HerXSayfadanBol" placeholder="Örnek: 4" style="width: 250px;">
            </td>
        </tr>
    </table>
</fieldset>

<br><br>

<fieldset style='width:50%'>
    <legend><b style='color: darkred;'>Sayfa Ekle / Sil:</b></legend>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <td nowrap="nowrap">
                Hangi sayfalardan sonra boş sayfa eklensin?
            </td>
            <td nowrap="nowrap">
                <input type="text" name="BosSayfalar" placeholder="Örnek: 6,18,27,33" style="width: 250px;">
            </td>
        </tr>
        <tr>
            <td nowrap="nowrap">
                Hangi sayfalar silinsin?
            </td>
            <td nowrap="nowrap">
                <input type="text" name="SilSayfalar" placeholder="Örnek: 6,18,27,33-40" style="width: 250px;">
            </td>
        </tr>
    </table>
</fieldset>

<br><br>

<fieldset style='width:50%'>
    <legend><b style='color: darkred;'>PDF Dosyayı Bölme:</b></legend>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <td nowrap="nowrap">
                Hangi sayfalardan itibaren bölünsün?
            </td>
            <td nowrap="nowrap">
                <input type="text" name="Bol1Sayfalar" placeholder="Örnek: 6,18,27,33" style="width: 250px;">
            </td>
        </tr>
        <tr>
            <td nowrap="nowrap">
                Özel böl (Her noktalıvirgül ayrımı ayrı PDF olacak)
            </td>
            <td nowrap="nowrap">
                <input type="text" name="Bol2Sayfalar" placeholder="Örnek: 1-15;18-30,35-40" style="width: 250px;">
            </td>
        </tr>
    </table>
</fieldset>

<br><br>

<fieldset style='width:50%'>
    <legend><b style='color: darkred;'>PDF Dosya Ekle:</b></legend>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <td nowrap="nowrap">
                Dosya
            </td>
            <td nowrap="nowrap">
                Hangi sayfadan sonra eklensin?
            </td>
            <td nowrap="nowrap">
                Eklenecek PDF dosyayı seçiniz:
            </td>
            <td nowrap="nowrap">
                Bu dosyanın hangi sayfaları eklensin?
            </td>
        </tr>
        <?php for($i=0;$i<4;$i++) {
            $Harf = chr($i+65);
            echo "
                <tr>
                    <td nowrap='nowrap'>
                        <span style='font-size: 30px;'>$Harf</span>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='YeniPDF_Baslama[$i]' placeholder='Örnek: 18' style='width: 250px;'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='file' name='YeniPDF[$i]'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='YeniPDF_Sayfalar[$i]' placeholder='1,3,5,15-27  (Tamamı için boş bırakın)' style='width: 250px;'>
                    </td>
                </tr>";
        } // for($i=0;$i<4;$i++) { ?>
    </table>
</fieldset>

<p><input type="submit" name="gonder" value="Gönder"></p>

    <style>
        body {
            background-color:  lightgrey;
        }
        img {
            margin: 5px;
            border: 1px solid grey;
            height: 150px;
        }
        div {
            width: 200px;
            height: 230px;
            text-align: center;
            float:  left;
            overflow: hidden;
            border-bottom: 1px solid darkgrey;
            border-right: 1px solid darkgrey;
            padding: 5px;
        }
        .LabelA {font-size: 30px; margin-right: 15px; background-color: #A5D6A7 !important; margin: 2px; display: inline-block; border-radius: 5px; border: 1px solid #33691E;}
        .LabelB {font-size: 30px; margin-left:  15px; background-color: #A5D6A7 !important; margin: 2px; display: inline-block; border-radius: 5px; border: 1px solid #33691E;}
        
        .SOL {transform: rotate(-90deg);}
        .SAG {transform: rotate( 90deg);}
        .NORMAL {transform: rotate( 0deg);}

    </style>

<script>
    function Cevir(ResimNo, ResimYon) {
        // console.log(ResimNo, ResimYon, DEGER)
        document.getElementById(ResimNo).className = 'NORMAL';
        if(document.getElementById(ResimYon + ResimNo).checked == true) {
            document.getElementById(ResimNo).className = ResimYon;
        }

    }
</script>

        <div>
                        <img id='1' src='pul/sayfa-0000.jpg'><br>
                        <label class='LabelA'>
                            <input type='checkbox' id='SOL1' name='sol[1]' onclick="Cevir(1, 'SOL', this.value)">&#8630;
                        </label>
                        1
                        <label class='LabelB'>
                            <input type='checkbox' id='SAG1' name='sag[1]' onclick="Cevir(1, 'SAG', this.value)">&#8631;
                        </label>
                      </div><div>
                        <img id='2' src='pul/sayfa-0001.jpg'><br>
                        <label class='LabelA'>
                            <input type='checkbox' id='SOL2' name='sol[2]' onclick="Cevir(2, 'SOL', this.value)">&#8630;
                        </label>
                        2
                        <label class='LabelB'>
                            <input type='checkbox' id='SAG2' name='sag[2]' onclick="Cevir(2, 'SAG', this.value)">&#8631;
                        </label>
                      </div><div>
                        <img id='3' src='pul/sayfa-0002.jpg'><br>
                        <label class='LabelA'>
                            <input type='checkbox' id='SOL3' name='sol[3]' onclick="Cevir(3, 'SOL', this.value)">&#8630;
                        </label>
                        3
                        <label class='LabelB'>
                            <input type='checkbox' id='SAG3' name='sag[3]' onclick="Cevir(3, 'SAG', this.value)">&#8631;
                        </label>
                      </div><div>
                        <img id='4' src='pul/sayfa-0003.jpg'><br>
                        <label class='LabelA'>
                            <input type='checkbox' id='SOL4' name='sol[4]' onclick="Cevir(4, 'SOL', this.value)">&#8630;
                        </label>
                        4
                        <label class='LabelB'>
                            <input type='checkbox' id='SAG4' name='sag[4]' onclick="Cevir(4, 'SAG', this.value)">&#8631;
                        </label>
                      </div><div>
                        <img src='pul/sayfa-0004.jpg'><br>
                        <label class='LabelA'>
                            <input type='checkbox' name='sol[5]'>&#8630;
                        </label>
                        5
                        <label class='LabelB'>
                            <input type='checkbox' name='sag[5]'>&#8631;
                        </label>
                      </div><div>
                        <img src='pul/sayfa-0005.jpg'><br>
                        <label class='LabelA'>
                            <input type='checkbox' name='sol[6]'>&#8630;
                        </label>
                        6
                        <label class='LabelB'>
                            <input type='checkbox' name='sag[6]'>&#8631;
                        </label>
                      </div><div>
                        <img src='pul/sayfa-0006.jpg'><br>
                        <label class='LabelA'>
                            <input type='checkbox' name='sol[7]'>&#8630;
                        </label>
                        7
                        <label class='LabelB'>
                            <input type='checkbox' name='sag[7]'>&#8631;
                        </label>
                      </div><div>
                        <img src='pul/sayfa-0007.jpg'><br>
                        <label class='LabelA'>
                            <input type='checkbox' name='sol[8]'>&#8630;
                        </label>
                        8
                        <label class='LabelB'>
                            <input type='checkbox' name='sag[8]'>&#8631;
                        </label>
                      </div><div>
                        <img src='pul/sayfa-0008.jpg'><br>
                        <label class='LabelA'>
                            <input type='checkbox' name='sol[9]'>&#8630;
                        </label>
                        9
                        <label class='LabelB'>
                            <input type='checkbox' name='sag[9]'>&#8631;
                        </label>
                      </div><div>
                        <img src='pul/sayfa-0009.jpg'><br>
                        <label class='LabelA'>
                            <input type='checkbox' name='sol[10]'>&#8630;
                        </label>
                        10
                        <label class='LabelB'>
                            <input type='checkbox' name='sag[10]'>&#8631;
                        </label>
                      </div><div>
                        <img src='pul/sayfa-0010.jpg'><br>
                        <label class='LabelA'>
                            <input type='checkbox' name='sol[11]'>&#8630;
                        </label>
                        11
                        <label class='LabelB'>
                            <input type='checkbox' name='sag[11]'>&#8631;
                        </label>
                      </div><div>
                        <img src='pul/sayfa-0011.jpg'><br>
                        <label class='LabelA'>
                            <input type='checkbox' name='sol[12]'>&#8630;
                        </label>
                        12
                        <label class='LabelB'>
                            <input type='checkbox' name='sag[12]'>&#8631;
                        </label>
                      </div><div>
                        <img src='pul/sayfa-0012.jpg'><br>
                        <label class='LabelA'>
                            <input type='checkbox' name='sol[13]'>&#8630;
                        </label>
                        13
                        <label class='LabelB'>
                            <input type='checkbox' name='sag[13]'>&#8631;
                        </label>
                      </div>

            <br style='clear: both; '>

        <input type="hidden" name="toplamsayfa" value="116"></p>
        <p><input type="submit" name="gonder" value="Gönder"></p>

        <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>


    </form>
    </body>
</html>