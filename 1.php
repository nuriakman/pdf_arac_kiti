<?php

// KAYNAK: https://www.pdflabs.com/docs/pdftk-man-page/

/*
pdftk A=rapor.pdf B=bos.pdf cat B1 A3-7 B1 A9-10 B1 A9 output SONUC.pdf
pdftk A=rapor.pdf B=bos.pdf cat A1 A1left A1right  A3-7 B1 A9-10 B1 A9 output SONUC.pdf

Sayfa No Ekleme: Baş.Sayfa: X, Bit.Sayfa: Y,  Sayfa numarası şundan başlasın: Z

Booklet Yapma:
http://www.michaelm.info/blog/?p=1375
http://pdfbooklet.sourceforge.net/



HowTo Add Page Numbers to a PDF File:
http://forums.debian.net/viewtopic.php?t=30598

Print two A5 pages on one A4 page with correct sizes:
How can I print a PDF document on multiple pages?:
https://askubuntu.com/questions/1143795/print-two-a5-pages-on-one-a4-page-with-correct-sizes
https://askubuntu.com/questions/186867/how-can-i-print-a-pdf-document-on-multiple-pages
https://pypi.org/project/pdfnup/
https://pypi.org/project/pyPdf/
https://pypi.org/project/PyPDF2/
https://mstamy2.github.io/PyPDF2/
http://pybrary.net/pyPdf/


PDF to JPG:
https://github.com/pankajr141/pdf2jpg
convert myfile.pdf myfile.png
magick myfile.pdf myfile.png
pdfimages my-file.pdf prefix 
pdftoppm input.pdf outputname -png    ----> imagemagick 'den daha kaliteli. pdftoppm is much faster than convert
pdftk document.pdf cat 12 output - | convert - document-page-12.png


PDF Poster Yapma:
https://gitlab.com/pdftools/pdfposter
https://pdfposter.readthedocs.io/en/stable/index.html


Linux'daki PDF Yazılımları:
https://en.wikipedia.org/wiki/List_of_PDF_software#Linux_and_Unix
https://manpages.ubuntu.com/manpages/bionic/man1/pdftocairo.1.html
https://www.mankier.com/1/pdftocairo
https://github.com/DavidFirth/pdfjam
https://poppler.freedesktop.org/



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
            <legend><b style='color: darkred;'>PDF Birleştirme Ayarları:</b> </legend>
            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <tr>
                    <td nowrap="nowrap"> Eklenen her dosya sağ sayfadan başlasın </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="SagSayfadaBirlestir"> </td>
                </tr>
                <tr>
                    <td nowrap="nowrap"> Dosyalar arasına boş bir yaprak ekle </td>
                    <td nowrap="nowrap">
                        <input type="checkbox" name="SagSayfadaBirlestir"> </td>
                </tr>
            </table>
        </fieldset>
        <br>
        <br>
        <fieldset style='width:50%'>
            <legend><b style='color: darkred;'>Çoklu PDF Dosya Seçimi:</b> <input type="button" value="HAYDI" onclick="HAYDI()"></legend>
            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <tr>
                    <td nowrap="nowrap"> Dosyaları Seçiniz (Çoklu Seçim Yapabilirsiniz) </td>
                    <td nowrap="nowrap">
                        <input type='file' id='TopluPDF' name='TopluPDF[]' multiple onchange='DosyalariEkranaListele()'> </td>
                </tr>
                <tr id='SiralamaSatiri' style='display:none;'>
                    <td colspan="2">
                        <b>Dosyalarınızın sıralamasını sürükle-bırak yaparak belirleyin:</b><br>
                        <input type='text' id='Siralama' name='Siralama' value=''><br>
                        <ul id='tmpSecilenDosyalar' class='tmpSecilenDosyalar'>
                            
                        </ul>
                    </td>
                </tr>
            </table>
        </fieldset>
<br><br>

<script>
    function YeniDosyaEkle(Kod) {
        var rowCount = $('#tableBirlestirme' +Kod+ ' tr').length;
        var SATIR = $('#tableBirlestirme' +Kod+ ' tr:nth-child(2)');
        SATIR.clone().appendTo('#tableBirlestirme' +Kod);
        $('#tableBirlestirme' +Kod+ ' tr:nth-child(' + (rowCount+1) + ')').show()
        var tr = $('#tableBirlestirme' +Kod+ ' tr:nth-child(' + (rowCount+1) + ')').find("td");
        tr[0].innerHTML = rowCount - 1;
    }


    function DosyalariEkranaListele() {
        var files = $('#TopluPDF').get(0).files;

        if ( $('.tmpSecilenDosyalar li').length >= 1 ) {
            $('.tmpSecilenDosyalar').dropme('destroy');
            $('.tmpSecilenDosyalar').html('');
        }

        // Sürükle bırak eklenirse süper olur...
        // $('.tmpSecilenDosyalar').dropme();
        $.each(files, function(_, file) {
            //$('.tmpSecilenDosyalar').append( '<li>name : ' + file.name + ' --- ' + ' size : ' + file.size + '</li>' );
            $('.tmpSecilenDosyalar').append( '<li>' + file.name + '</li>' );
        });

        $('#SiralamaSatiri').hide();
        if ( $('.tmpSecilenDosyalar li').length > 1 ) {
            $('#SiralamaSatiri').show();
        }

        if ( $('.tmpSecilenDosyalar li').length >= 1 ) {

            $('#Siralama').val('');
            $('.tmpSecilenDosyalar li').each(function(i, li){
                $('#Siralama').val( $('#Siralama').val() + '|' + $(li).text() );
            })

            $('.tmpSecilenDosyalar').dropme({
                replacerSize: true 
            });

            $('.tmpSecilenDosyalar').bind('sortupdate', function(e, elm) {
                //Triggered when the position has changed.
                $('#Siralama').val('');
                $('.tmpSecilenDosyalar li').each(function(i, li){
                    $('#Siralama').val( $('#Siralama').val() + '|' + $(li).text() );
                })

                // $('#Siralama').html()
            });

        }

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
            <legend><b style='color: darkred;'>Tek Tek PDF Dosya Seçimi:</b> <input type='button' value='1 Tane Daha Ekle' onclick='YeniDosyaEkle(1)'></legend>
            <table border="1" cellpadding="10" cellspacing="0" width="100%" id="tableBirlestirme1">
                <tr>
                    <td nowrap="nowrap"> Dosya No </td>
                    <td nowrap="nowrap"> Eklenecek PDF dosyayı seçiniz </td>
                    <td nowrap="nowrap"> Bu dosyanın hangi sayfaları eklensin? </td>
                </tr>
                
                <tr style='display:none;'>
                    <td nowrap='nowrap' style='font-size: 30px; text-align: center;'>
                        YENİ
                    </td>
                    <td nowrap='nowrap'>
                        <input type='file' name='YeniPDF[0]'>
                    </td>
                    <td nowrap='nowrap'>
                        <input type='text' name='YeniPDF_Sayfalar[0]' placeholder='1,3,5,15-27  (Tamamı için boş bırakın)' style='width: 250px;'>
                    </td>
                </tr>

                <tr>
                    <td nowrap='nowrap' style='font-size: 30px; text-align: center;'>
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
        <br>
        <br>
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
                    <td nowrap="nowrap"> Her biri X sayfalık kitapçık (booklet) yap </td>
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


                <tr style='display:none;'>
                    <td nowrap='nowrap' style='font-size: 30px; text-align: center;'>
                        YENİ
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

                <tr>
                    <td nowrap='nowrap' style='font-size: 30px; text-align: center;'>
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
                background-color: #CFD8DC;
            }

            /* Taşınan Nesne */
            .drop-elmDrag {
                background-color: #1565C0;
            }

            /* Bırakılacak Konum */
            .tmpSecilenDosyalar li.drop-replacer {
              border: 1px dashed #000000;
              background: none;
              background-color: lightgreen;
            }

            /* PDF Sayfa Önizlemelerinin olduğu UL elementi */
            .tmpSecilenDosyalar {
                margin: 0px;
                padding: 0px;
            }

            /* Her bir PDF Sayfa Önizlemesi */
            .tmpSecilenDosyalar li {
                margin:  5px;
                list-style: none;
                /*
                width: 200px;
                height: 230px;
                float: left;
                text-align: center;
                display: block;
*/
                overflow: hidden;
                border: 1px solid darkgrey;
                padding: 5px;
            }


/* ***************************************** */



            /* Bırakılacak Konum */
            .PDFSayfalari li.drop-replacer {
              border: 1px dashed #000000;
              background: none;
              background-color: lightgreen;
            }

            /* PDF Sayfa Önizlemelerinin olduğu UL elementi */
            .PDFSayfalari {
                margin: 0px;
                padding: 0px;
                cursor: grab;
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
                width: 50px !important;
                border-radius: 5px;
                border: 1px solid #33691E;
            }
            
            .LabelB {
                font-size: 30px;
                margin-left: 15px;
                background-color: #A5D6A7 !important;
                margin: 2px;
                display: inline-block;
                width: 50px !important;
                border-radius: 5px;
                border: 1px solid #33691E;
            }
            
            .LabelYON {
                font-size: 25px;
                margin-left: 15px;
                background-color: #A5D6A7 !important;
                margin: 2px;
                display: inline-block;
                width: 30px !important;
                height: 30px !important;
                overflow: hidden;
                border-radius: 50px;
                border: 1px solid #33691E;
                cursor: pointer;
            }
            
            .SOL {
                transform: rotate(-90deg);
            }
            
            .SAG {
                transform: rotate( 90deg);
            }
            
            .DIK {
                transform: rotate( 180deg);
            }
            
            .NORMAL {
                transform: rotate( 0deg);
            }

            .chkBoxGizli {
                display:  none;
            }

            .SayfaNo {
                border-top: 3px solid #FF5722;
                padding-top:  2px;
                font-size:  15px !important;
                display: block;
                text-align: left;
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

        function Cevir1(ResimNo, ResimYon) {
            // console.log(ResimNo, ResimYon, DEGER)
            document.getElementById(ResimNo).className = 'NORMAL';
            
            var DURUM = document.getElementById(ResimYon + ResimNo).checked
            document.getElementById(ResimYon + ResimNo).checked =  !DURUM;

            if(document.getElementById(ResimYon + ResimNo).checked == true) {
                document.getElementById(ResimNo).className = ResimYon;
            }
        }
        </script>


        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="dropMe/dropMe.js"></script>
        <!-- KAYNAK: http://naukri-engineering.github.io/dropMe/  -->
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
                <img id='0' src='pul/sayfa-0000.jpg'>
                <input type='hidden' name='sayfa_no[]' value='0'>
                <br>
                <input type='checkbox' class='chkBoxGizli' id='SOL0' name='sol[0]'>
                <input type='checkbox' class='chkBoxGizli' id='SAG0' name='sag[0]'>
                <input type='checkbox' class='chkBoxGizli' id='DIK0' name='dik[0]'>
                <div class='LabelYON' onclick="Cevir1(0, 'SOL')"> &#8630; </div>
                <div class='LabelYON' onclick="Cevir1(0, 'SAG', this.value)"> &#8631; </div>
                <div class='LabelYON' onclick="Cevir1(0, 'DIK', this.value)"> &#8645; </div>
                <span class='SayfaNo'>Sayfa: 123</span>
            </li>
            
            <li>
                <img id='1' src='pul/sayfa-0001.jpg'>
                <input type='hidden' name='sayfa_no[]' value='1'>
                <br>
                <input type='checkbox' class='chkBoxGizli' id='SOL1' name='sol[1]'>
                <input type='checkbox' class='chkBoxGizli' id='SAG1' name='sag[1]'>
                <input type='checkbox' class='chkBoxGizli' id='DIK1' name='dik[1]'>
                <div class='LabelYON' onclick="Cevir1(1, 'SOL')"> &#8630; </div>
                <div class='LabelYON' onclick="Cevir1(1, 'SAG', this.value)"> &#8631; </div>
                <div class='LabelYON' onclick="Cevir1(1, 'DIK', this.value)"> &#8645; </div>
                <span class='SayfaNo'>Sayfa: 1</span>
            </li>
            
            <li>
                <img id='2' src='pul/sayfa-0002.jpg'>
                <input type='hidden' name='sayfa_no[]' value='2'>
                <br>
                <input type='checkbox' class='chkBoxGizli' id='SOL2' name='sol[2]'>
                <input type='checkbox' class='chkBoxGizli' id='SAG2' name='sag[2]'>
                <input type='checkbox' class='chkBoxGizli' id='DIK2' name='dik[2]'>
                <div class='LabelYON' onclick="Cevir1(2, 'SOL')"> &#8630; </div>
                <div class='LabelYON' onclick="Cevir1(2, 'SAG', this.value)"> &#8631; </div>
                <div class='LabelYON' onclick="Cevir1(2, 'DIK', this.value)"> &#8645; </div>
                <span class='SayfaNo'>Sayfa: 2</span>
            </li>
            
            <li>
                <img id='3' src='pul/sayfa-0003.jpg'>
                <input type='hidden' name='sayfa_no[]' value='3'>
                <br>
                <input type='checkbox' class='chkBoxGizli' id='SOL3' name='sol[3]'>
                <input type='checkbox' class='chkBoxGizli' id='SAG3' name='sag[3]'>
                <input type='checkbox' class='chkBoxGizli' id='DIK3' name='dik[3]'>
                <div class='LabelYON' onclick="Cevir1(3, 'SOL')"> &#8630; </div>
                <div class='LabelYON' onclick="Cevir1(3, 'SAG', this.value)"> &#8631; </div>
                <div class='LabelYON' onclick="Cevir1(3, 'DIK', this.value)"> &#8645; </div>
                <span class='SayfaNo'>Sayfa: 3</span>
            </li>
            
            <li>
                <img id='4' src='pul/sayfa-0004.jpg'>
                <input type='hidden' name='sayfa_no[]' value='4'>
                <br>
                <input type='checkbox' class='chkBoxGizli' id='SOL4' name='sol[4]'>
                <input type='checkbox' class='chkBoxGizli' id='SAG4' name='sag[4]'>
                <input type='checkbox' class='chkBoxGizli' id='DIK4' name='dik[4]'>
                <div class='LabelYON' onclick="Cevir1(4, 'SOL')"> &#8630; </div>
                <div class='LabelYON' onclick="Cevir1(4, 'SAG', this.value)"> &#8631; </div>
                <div class='LabelYON' onclick="Cevir1(4, 'DIK', this.value)"> &#8645; </div>
                <span class='SayfaNo'>Sayfa: 4</span>
            </li>
            
            <li>
                <img id='5' src='pul/sayfa-0005.jpg'>
                <input type='hidden' name='sayfa_no[]' value='5'>
                <br>
                <input type='checkbox' class='chkBoxGizli' id='SOL5' name='sol[5]'>
                <input type='checkbox' class='chkBoxGizli' id='SAG5' name='sag[5]'>
                <input type='checkbox' class='chkBoxGizli' id='DIK5' name='dik[5]'>
                <div class='LabelYON' onclick="Cevir1(5, 'SOL')"> &#8630; </div>
                <div class='LabelYON' onclick="Cevir1(5, 'SAG', this.value)"> &#8631; </div>
                <div class='LabelYON' onclick="Cevir1(5, 'DIK', this.value)"> &#8645; </div>
                <span class='SayfaNo'>Sayfa: 5</span>
            </li>
            
            <li>
                <img id='6' src='pul/sayfa-0006.jpg'>
                <input type='hidden' name='sayfa_no[]' value='6'>
                <br>
                <input type='checkbox' class='chkBoxGizli' id='SOL6' name='sol[6]'>
                <input type='checkbox' class='chkBoxGizli' id='SAG6' name='sag[6]'>
                <input type='checkbox' class='chkBoxGizli' id='DIK6' name='dik[6]'>
                <div class='LabelYON' onclick="Cevir1(6, 'SOL')"> &#8630; </div>
                <div class='LabelYON' onclick="Cevir1(6, 'SAG', this.value)"> &#8631; </div>
                <div class='LabelYON' onclick="Cevir1(6, 'DIK', this.value)"> &#8645; </div>
                <span class='SayfaNo'>Sayfa: 6</span>
            </li>
            
            <li>
                <img id='7' src='pul/sayfa-0007.jpg'>
                <input type='hidden' name='sayfa_no[]' value='7'>
                <br>
                <input type='checkbox' class='chkBoxGizli' id='SOL7' name='sol[7]'>
                <input type='checkbox' class='chkBoxGizli' id='SAG7' name='sag[7]'>
                <input type='checkbox' class='chkBoxGizli' id='DIK7' name='dik[7]'>
                <div class='LabelYON' onclick="Cevir1(7, 'SOL')"> &#8630; </div>
                <div class='LabelYON' onclick="Cevir1(7, 'SAG', this.value)"> &#8631; </div>
                <div class='LabelYON' onclick="Cevir1(7, 'DIK', this.value)"> &#8645; </div>
                <span class='SayfaNo'>Sayfa: 7</span>
            </li>
            
            <li>
                <img id='8' src='pul/sayfa-0008.jpg'>
                <input type='hidden' name='sayfa_no[]' value='8'>
                <br>
                <input type='checkbox' class='chkBoxGizli' id='SOL8' name='sol[8]'>
                <input type='checkbox' class='chkBoxGizli' id='SAG8' name='sag[8]'>
                <input type='checkbox' class='chkBoxGizli' id='DIK8' name='dik[8]'>
                <div class='LabelYON' onclick="Cevir1(8, 'SOL')"> &#8630; </div>
                <div class='LabelYON' onclick="Cevir1(8, 'SAG', this.value)"> &#8631; </div>
                <div class='LabelYON' onclick="Cevir1(8, 'DIK', this.value)"> &#8645; </div>
                <span class='SayfaNo'>Sayfa: 8</span>
            </li>
            
            <li>
                <img id='9' src='pul/sayfa-0009.jpg'>
                <input type='hidden' name='sayfa_no[]' value='9'>
                <br>
                <input type='checkbox' class='chkBoxGizli' id='SOL9' name='sol[9]'>
                <input type='checkbox' class='chkBoxGizli' id='SAG9' name='sag[9]'>
                <input type='checkbox' class='chkBoxGizli' id='DIK9' name='dik[9]'>
                <div class='LabelYON' onclick="Cevir1(9, 'SOL')"> &#8630; </div>
                <div class='LabelYON' onclick="Cevir1(9, 'SAG', this.value)"> &#8631; </div>
                <div class='LabelYON' onclick="Cevir1(9, 'DIK', this.value)"> &#8645; </div>
                <span class='SayfaNo'>Sayfa: 9</span>
            </li>
            
            <li>
                <img id='10' src='pul/sayfa-0010.jpg'>
                <input type='hidden' name='sayfa_no[]' value='10'>
                <br>
                <input type='checkbox' class='chkBoxGizli' id='SOL10' name='sol[10]'>
                <input type='checkbox' class='chkBoxGizli' id='SAG10' name='sag[10]'>
                <input type='checkbox' class='chkBoxGizli' id='DIK10' name='dik[10]'>
                <div class='LabelYON' onclick="Cevir1(10, 'SOL')"> &#8630; </div>
                <div class='LabelYON' onclick="Cevir1(10, 'SAG', this.value)"> &#8631; </div>
                <div class='LabelYON' onclick="Cevir1(10, 'DIK', this.value)"> &#8645; </div>
                <span class='SayfaNo'>Sayfa: 10</span>
            </li>
            
            <li>
                <img id='11' src='pul/sayfa-0011.jpg'>
                <input type='hidden' name='sayfa_no[]' value='11'>
                <br>
                <input type='checkbox' class='chkBoxGizli' id='SOL11' name='sol[11]'>
                <input type='checkbox' class='chkBoxGizli' id='SAG11' name='sag[11]'>
                <input type='checkbox' class='chkBoxGizli' id='DIK11' name='dik[11]'>
                <div class='LabelYON' onclick="Cevir1(11, 'SOL')"> &#8630; </div>
                <div class='LabelYON' onclick="Cevir1(11, 'SAG')"> &#8631; </div>
                <div class='LabelYON' onclick="Cevir1(11, 'DIK')"> &#8645; </div>
                <span class='SayfaNo'>Sayfa: 11</span>
            </li>
            
            <li>
                <img id='12' src='pul/sayfa-0012.jpg'>
                <input type='hidden' name='sayfa_no[]' value='12'>
                <br>
                <input type='checkbox' class='chkBoxGizli' id='SOL12' name='sol[12]'>
                <input type='checkbox' class='chkBoxGizli' id='SAG12' name='sag[12]'>
                <input type='checkbox' class='chkBoxGizli' id='DIK12' name='dik[12]'>
                <div class='LabelYON' onclick="Cevir1(12, 'SOL')"> &#8630; </div>
                <div class='LabelYON' onclick="Cevir1(12, 'SAG')"> &#8631; </div>
                <div class='LabelYON' onclick="Cevir1(12, 'DIK')"> &#8645; </div>
                <span class='SayfaNo'>Sayfa: 12</span>
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