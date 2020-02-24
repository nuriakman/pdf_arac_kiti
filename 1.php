<?php

// KAYNAK: https://www.pdflabs.com/docs/pdftk-man-page/

/*
pdftk A=rapor.pdf B=bos.pdf cat B1 A3-7 B1 A9-10 B1 A9 output SONUC.pdf
pdftk A=rapor.pdf B=bos.pdf cat A1 A1left A1right  A3-7 B1 A9-10 B1 A9 output SONUC.pdf
*/

    if( isset($_POST["toplamsayfa"]) ) {
        echo "<pre>";
        print_r($_POST);
        print_r($_FILES);
        echo "</pre>";
    }

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PDF Araç Kiti</title>
</head>

<body>
    <form id="form1" 11method="post" action="" enctype="multipart/form-data">
        <h1>PDF Araç Kiti</h1>
        <!-- <p><a href='index.php'>Ana Sayfaya Git</a></p> -->

<br><br>
        <h2>PDF Dosyaları birleştirip tek dosya yap</h2>
        <fieldset style='width:50%'>
            <legend><b style='color: darkred;'>PDF Birleştirme İşlemleri:</b> <input type="button" value="HAYDI" onclick="HAYDI()"></legend>
            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <tr>
                    <td nowrap="nowrap"> Tümünü birleştir (Çoklu dosya seçiniz) </td>
                    <td nowrap="nowrap">
                        <input type='file' id='TopluPDF' name='TopluPDF[]' multiple onchange='DosyalariEkranaListele()'> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Her dosya sağ sayfadan başlasın </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="SagSayfadaBirlestir"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Dosyalar arasına boş yaprak ekle </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="SagSayfadaBirlestir"> </td>
                </tr>
            </table>
            <b>Seçilen dosyalar:</b><br>
            <ul id='tmpSecilenDosyalar'>
                
            </ul>
        </fieldset>
<br><br>

<script>
    function YeniDosyaEkle(Kod) {
        var rowCount = $('#tableBirlestirme' +Kod+ ' tr').length;
        var SATIR = $('#tableBirlestirme' +Kod+ ' tr:nth-child(2)');
        SATIR.clone().appendTo('#tableBirlestirme' +Kod);
        var tr = $('#tableBirlestirme' +Kod+ ' tr:nth-child(' + (rowCount+1) + ')').find("td");
        tr[0].innerHTML = rowCount;
    }


    function DosyalariEkranaListele() {
        var files = $('#TopluPDF').get(0).files;

        $('#tmpSecilenDosyalar').html('');
        
        // Sürükle bırak eklenirse süper olur...
        // $('#tmpSecilenDosyalar').dropme();

        $.each(files, function(_, file) {
            $('#tmpSecilenDosyalar').append( '<li>name : ' + file.name + ' --- ' + ' size : ' + file.size + '</li>' );
        });

        return;
    }

    function HAYDI() {

        // AJAX ile FİLE UPLOAD

        var form = $('#form1')[0]; // You need to use standard javascript object here
        var data = new FormData(form);
        data.append("CustomField1", "This is some extra data, testing");
        data.append("CustomField2", "This is some extra data, testing");
        // Attach file
        data.append('image', $('input[type=file]')[0].files[0]);

        $.ajax( {
            url    : '1test.php',
            type   : 'POST',
            enctype: 'multipart/form-data',
            data   : data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            dataType: "text",
           success : function(ajaxCevap)
           {
               alert(ajaxCevap); // Cevabı göster...
           }
        } );
    }
</script>
        <fieldset style='width:50%'>
            <legend><b style='color: darkred;'>PDF Dosya Birleştirme:</b> <input type='button' value='1 Tane Daha Ekle' onclick='YeniDosyaEkle(1)'></legend>
            <table border="1" cellpadding="10" cellspacing="0" width="100%" id="tableBirlestirme1">
                <tr>
                    <td nowrap="nowrap"> Dosya No </td>
                    <td nowrap="nowrap"> Eklenecek PDF dosyayı seçiniz </td>
                    <td nowrap="nowrap"> Bu dosyanın hangi sayfaları eklensin? </td>
                </tr>
                
                <tr>
                    <td nowrap='nowrap' style='font-size: 30px;'>
                        1
                    </td>
                    <td nowrap='nowrap'>
                        <input type='file' name='YeniPDF[0]'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='YeniPDF_Sayfalar[0]' placeholder='1,3,5,15-27  (Tamamı için boş bırakın)' style='width: 250px;'>
                    </td>
                </tr>

            </table>
        </fieldset>











        <h2>Bir PDF dosyası üzerinde çalış</h2>
        <fieldset style='width:50%'>
            <legend><b style='color: darkred;'>PDF Dosyanız:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <tr>
                    <td nowrap="nowrap"> Üzerinde çalışacağınız dosya </td>
                    <td nowrap="nowrap">
                        <input type='file' name='AnaDosya' multiple> </td>
                </tr>
            </table>
        </fieldset>
        <br>
        <br>
        <fieldset style='width:50%'>
            <legend><b style='color: darkred;'>PDF Çıktı Üretme:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <tr>
                    <td nowrap="nowrap"> PDF'in her biri X sayfalık kitapçık (booklet) yap </td>
                    <td nowrap="nowrap">
                        <input type="text" name="BookletSayfaAdedi" placeholder="Örnek: 60" style="width: 250px;"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Her sayfayı ayrı PDF yap </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="TumunuPDFYap"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Her X sayfayı alıp, sayfaları ayrı PDF yap </td>
                    <td nowrap="nowrap">
                        <input type="text" name="HerXSayfadanBol" placeholder="Örnek: 4" style="width: 250px;"> </td>
                </tr>
            </table>
        </fieldset>
        <br>
        <br>
        <fieldset style='width:50%'>
            <legend><b style='color: darkred;'>Boş Sayfa Ekle:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <tr>
                    <td nowrap="nowrap"> Hangi sayfalardan sonra boş sayfa eklensin? </td>
                    <td nowrap="nowrap">
                        <input type="text" name="BosSayfalar" placeholder="Örnek: 6,18,27,33" style="width: 250px;"> </td>
                </tr>
            </table>
        </fieldset>
        <br>
        <br>
        <fieldset style='width:50%'>
            <legend><b style='color: darkred;'>Sayfa Sil:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <tr>
                    <td nowrap="nowrap"> Hangi sayfalar silinsin? </td>
                    <td nowrap="nowrap">
                        <input type="text" name="SilSayfalar" placeholder="Örnek: 6,18,27,33-40" style="width: 250px;"> </td>
                </tr>
            </table>
        </fieldset>
        <br>
        <br>
        <fieldset style='width:50%'>
            <legend><b style='color: darkred;'>PDF Dosyayı Böl:</b></legend>
            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <tr>
                    <td nowrap="nowrap"> Hangi sayfalardan bölünsün? </td>
                    <td nowrap="nowrap">
                        <input type="text" name="Bol1Sayfalar" placeholder="Örnek: 6,18,27,33" style="width: 250px;"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Özel böl (Her noktalıvirgül ayrımı ayrı PDF olacak) </td>
                    <td nowrap="nowrap">
                        <input type="text" name="Bol2Sayfalar" placeholder="Örnek: 1,7,10,50-60;18-30,35-40" style="width: 250px;"> </td>
                </tr>
            </table>
        </fieldset>
        <br>
        <br>
        <fieldset style='width:50%'>
            <legend><b style='color: darkred;'>PDF Dosya Ekle:</b>  <input type='button' value='1 Tane Daha Ekle' onclick='YeniDosyaEkle(2)'></legend>
            <table border="1" cellpadding="10" cellspacing="0" width="100%" id="tableBirlestirme2">
                <tr>
                    <td nowrap="nowrap"> Dosya </td>
                    <td nowrap="nowrap"> Hangi sayfadan sonra eklensin? </td>
                    <td nowrap="nowrap"> Eklenecek PDF dosyayı seçiniz: </td>
                    <td nowrap="nowrap"> Bu dosyanın hangi sayfaları eklensin? </td>
                </tr>

                <tr>
                    <td nowrap='nowrap' style='font-size: 30px;'>
                        1
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='YeniPDF_Baslama[0]' placeholder='Örnek: 18' style='width: 250px;'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='file' name='YeniPDF[0]'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='YeniPDF_Sayfalar[0]' placeholder='1,3,5,15-27  (Tamamı için boş bırakın)' style='width: 250px;'>
                    </td>
                </tr>

            </table>
        </fieldset>

<script>
    function GOSTER() {

        $.ajax({
               type    : "POST",
               url     : "1test.php",
               dataType: "text",
               data    : $("#form1").serialize(), // Formu serialize et.
               success : function(ajaxCevap)
               {
                   alert(ajaxCevap); // Cevabı göster...
               }
             });

    }

</script>

        <p>
            <input type="button" value="GÖSTER" onclick="GOSTER()">

            <input type="submit" name="gonder" value="Gönder">
        </p>

        <style>
            body {
                background-color: white;
            }


            /* Bırakılacak Konum */
            .PDFSayfalari li.drop-replacer {
              border: 1px dashed #000000;
              background: none;
              background-color: lightgreen;
            }

            /* Taşınan Nesne */
            .drop-elmDrag {
                background-color: #1565C0;
            }

            /* PDF Sayfa Önizlemelerinin olduğu UL elementi */
            .PDFSayfalari {
                margin: 0px;
                padding: 0px;
            }

            /* Her bir PDF Sayfa Önizlemesi */
            .PDFSayfalari li {
                margin:  5px;
                list-style: none;
                width: 200px;
                height: 230px;
                text-align: center;
                float: left;
                overflow: hidden;
                border: 1px solid darkgrey;
                padding: 5px;
                display: block;
                
            }

            .PDFSayfalari img {
                margin: 5px;
                border: 1px solid lightgray;
                height: 150px;
            }

           
            .LabelA {
                font-size: 30px;
                margin-right: 15px;
                background-color: #A5D6A7 !important;
                margin: 2px;
                display: inline-block;
                border-radius: 5px;
                border: 1px solid #33691E;
            }
            
            .LabelB {
                font-size: 30px;
                margin-left: 15px;
                background-color: #A5D6A7 !important;
                margin: 2px;
                display: inline-block;
                border-radius: 5px;
                border: 1px solid #33691E;
            }
            
            .SOL {
                transform: rotate(-90deg);
            }
            
            .SAG {
                transform: rotate( 90deg);
            }
            
            .NORMAL {
                transform: rotate( 0deg);
            }



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


        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="dropMe/dropMe.js"></script>
        <script>

            jQuery(document).ready(function($) {
                $('.PDFSayfalari').dropme({
                    // items: '.PDFSayfa'
                });
            });

        </script>

<h1>Yön Değiştirme ve Sıralama</h3>
<p>Sürükle bırakarak yaparak sayfaların yerlerini değiştirebilirsiniz.<br>Yeşil oklara tıklayarak sayfa yönünü değiştirebilirsiniz.</p>
        <ul class="PDFSayfalari">
            
            <li>
                <img id='1' src='pul/sayfa-0000.jpg'>
                <input type='hidden' name='sayfa_no[]' value='1'>
                <br>
                <label class='LabelA'>
                    <input type='checkbox' id='SOL1' name='sol[1]' onclick="Cevir(1, 'SOL', this.value)">&#8630; </label> 1
                <label class='LabelB'>
                    <input type='checkbox' id='SAG1' name='sag[1]' onclick="Cevir(1, 'SAG', this.value)">&#8631; </label>
            </li>
            
            <li>
                <img id='2' src='pul/sayfa-0001.jpg'>
                <input type='hidden' name='sayfa_no[]' value='2'>
                <br>
                <label class='LabelA'>
                    <input type='checkbox' id='SOL2' name='sol[2]' onclick="Cevir(2, 'SOL', this.value)">&#8630; </label> 2
                <label class='LabelB'>
                    <input type='checkbox' id='SAG2' name='sag[2]' onclick="Cevir(2, 'SAG', this.value)">&#8631; </label>
            </li>
            
            <li>
                <img id='3' src='pul/sayfa-0002.jpg'>
                <input type='hidden' name='sayfa_no[]' value='3'>
                <br>
                <label class='LabelA'>
                    <input type='checkbox' id='SOL3' name='sol[3]' onclick="Cevir(3, 'SOL', this.value)">&#8630; </label> 3
                <label class='LabelB'>
                    <input type='checkbox' id='SAG3' name='sag[3]' onclick="Cevir(3, 'SAG', this.value)">&#8631; </label>
            </li>
            
            <li>
                <img id='4' src='pul/sayfa-0003.jpg'>
                <input type='hidden' name='sayfa_no[]' value='4'>
                <br>
                <label class='LabelA'>
                    <input type='checkbox' id='SOL4' name='sol[4]' onclick="Cevir(4, 'SOL', this.value)">&#8630; </label> 4
                <label class='LabelB'>
                    <input type='checkbox' id='SAG4' name='sag[4]' onclick="Cevir(4, 'SAG', this.value)">&#8631; </label>
            </li>
            
            <li>
                <img src='pul/sayfa-0004.jpg'>
                <input type='hidden' name='sayfa_no[]' value='5'>
                <br>
                <label class='LabelA'>
                    <input type='checkbox' name='sol[5]'>&#8630; </label> 5
                <label class='LabelB'>
                    <input type='checkbox' name='sag[5]'>&#8631; </label>
            </li>
            
            <li>
                <img src='pul/sayfa-0005.jpg'>
                <input type='hidden' name='sayfa_no[]' value='6'>
                <br>
                <label class='LabelA'>
                    <input type='checkbox' name='sol[6]'>&#8630; </label> 6
                <label class='LabelB'>
                    <input type='checkbox' name='sag[6]'>&#8631; </label>
            </li>
            
            <li>
                <img src='pul/sayfa-0006.jpg'>
                <input type='hidden' name='sayfa_no[]' value='7'>
                <br>
                <label class='LabelA'>
                    <input type='checkbox' name='sol[7]'>&#8630; </label> 7
                <label class='LabelB'>
                    <input type='checkbox' name='sag[7]'>&#8631; </label>
            </li>
            
            <li>
                <img src='pul/sayfa-0007.jpg'>
                <input type='hidden' name='sayfa_no[]' value='8'>
                <br>
                <label class='LabelA'>
                    <input type='checkbox' name='sol[8]'>&#8630; </label> 8
                <label class='LabelB'>
                    <input type='checkbox' name='sag[8]'>&#8631; </label>
            </li>
            
            <li>
                <img src='pul/sayfa-0008.jpg'>
                <input type='hidden' name='sayfa_no[]' value='9'>
                <br>
                <label class='LabelA'>
                    <input type='checkbox' name='sol[9]'>&#8630; </label> 9
                <label class='LabelB'>
                    <input type='checkbox' name='sag[9]'>&#8631; </label>
            </li>
            
            <li>
                <img src='pul/sayfa-0009.jpg'>
                <input type='hidden' name='sayfa_no[]' value='10'>
                <br>
                <label class='LabelA'>
                    <input type='checkbox' name='sol[10]'>&#8630; </label> 10
                <label class='LabelB'>
                    <input type='checkbox' name='sag[10]'>&#8631; </label>
            </li>
            
            <li>
                <img src='pul/sayfa-0010.jpg'>
                <input type='hidden' name='sayfa_no[]' value='11'>
                <br>
                <label class='LabelA'>
                    <input type='checkbox' name='sol[11]'>&#8630; </label> 11
                <label class='LabelB'>
                    <input type='checkbox' name='sag[11]'>&#8631; </label>
            </li>
            
            <li>
                <img src='pul/sayfa-0011.jpg'>
                <input type='hidden' name='sayfa_no[]' value='12'>
                <br>
                <label class='LabelA'>
                    <input type='checkbox' name='sol[12]'>&#8630; </label> 12
                <label class='LabelB'>
                    <input type='checkbox' name='sag[12]'>&#8631; </label>
            </li>
            
            <li>
                <img src='pul/sayfa-0012.jpg'>
                <input type='hidden' name='sayfa_no[]' value='13'>
                <br>
                <label class='LabelA'>
                    <input type='checkbox' name='sol[13]'>&#8630; </label> 13
                <label class='LabelB'>
                    <input type='checkbox' name='sag[13]'>&#8631; </label>
            </li>

        </ul>
        <!-- /PDFSayfalari -->

        <br style='clear: both; '>
        <p>
            <input type="hidden" name="toplamsayfa" value="116">
            <input type="submit" name="gonder" value="Gönder">
        </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </form>
</body>

</html>