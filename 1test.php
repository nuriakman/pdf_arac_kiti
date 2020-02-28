<?php 

    echo "================================================";
    echo "<h1>POST</h1>";
    print_r($_POST);
    
    echo "<h1>FILES</h1>";
    print_r($_FILES);

    $DOSYALAR = $_FILES['DosyalarTekli']['name'];
    foreach ($DOSYALAR as $key => $value) {
        if($DOSYALAR['size'] > 1) {
        	move_uploaded_file($DOSYALAR['tmp_name'][$key], "upload/TEK-" . $DOSYALAR['name'][$key]);
        }
    }

    $DOSYALAR = $_FILES['DosyalarCoklu']['name'];
    foreach ($DOSYALAR as $key => $value) {
        if($DOSYALAR['size'] > 1) {
        	move_uploaded_file($DOSYALAR['tmp_name'][$key], "upload/TEK-" . $DOSYALAR['name'][$key]);
        }
    }

    $DOSYALAR = $_FILES['AnaDosya']['name'];
    foreach ($DOSYALAR as $key => $value) {
        if($DOSYALAR['size'] > 1) {
        	move_uploaded_file($DOSYALAR['tmp_name'][$key], "upload/BOL-" . $DOSYALAR['name'][$key]);
        }
    }

/*

=======================================================================
POST
    [FormAdi] => formBirlestir
    [AlinacakSayfalar] => Array
        (
            [0] => 
            [1] => 1,2,3
            [2] => 5-15
        )
    [BirlestirmeSiralama] => |018-Temel-Komutlar-Ders-Notlar.pdf|5413183606-Subat 2020.PDF|Karbon Grup DNA.pdf|Vue-Essentials-Cheat-Sheet- KOPYA KAĞIDI.pdf
    [AyarBirlestir1] => on
    [AyarBirlestir2] => on
FILES
    DosyalarTekli
    DosyalarCoklu
=======================================================================
POST
    [FormAdi] => formBol
    [AyarBol1] => on
    [AyarBol2] => 11
    [AyarBol3] => 111
    [AyarBol4] => 1111
FILES
	AnaDosya
=======================================================================
POST
    [FormAdi] => formBirlestir

FILES

=======================================================================
POST
    [FormAdi] => formBirlestir

FILES

=======================================================================
POST
    [FormAdi] => formBirlestir

FILES

=======================================================================
POST
    [FormAdi] => formBirlestir

FILES

=======================================================================
POST
    [FormAdi] => formBirlestir

FILES

=======================================================================
POST
    [FormAdi] => formBirlestir

FILES

=======================================================================
POST
    [FormAdi] => formBirlestir

FILES

=======================================================================
POST
    [FormAdi] => formBirlestir

FILES

=======================================================================

*/

