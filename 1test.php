<?php 

    /* =======================================================
    ==========================================================
    ======================= BİRLEŞTİR ========================
    ==========================================================
    ======================================================= */

	if( isset($_POST["FormAdi"]) and $_POST["FormAdi"] == "formBirlestir" ) {
/*
POST
    [FormAdi] => formBirlestir
    [AlinacakSayfalar] ARRAY
    [BirlestirmeSiralama] => |018-Temel-Komutlar-Ders-Notlar.pdf|5413183606-Subat 2020.PDF|Karbon Grup DNA.pdf|Vue-Essentials-Cheat-Sheet- KOPYA KAĞIDI.pdf
    [AyarBirlestir1] => on CHECKBOX
    [AyarBirlestir2] => on CHECKBOX
FILES
    DosyalarTekli
    DosyalarCoklu
*/		
    	$Tekli = 0;
	    foreach($_FILES['DosyalarTekli']['name'] as $key => $value) {
	        if ($_FILES['DosyalarTekli']['size'][$key] > 1) {
	        	$Tekli++;
	        }
	    }

    	$Coklu = 0;
	    foreach($_FILES['DosyalarTekli']['name'] as $key => $value) {
	        if ($_FILES['DosyalarTekli']['size'][$key] > 1) {
	        	$Coklu++;
	        }
	    }

	    if($Tekli == 0 and $Coklu == 0) {
	    	die("Dosya seçimi yapılmadı");
	    }

	}

    /* =======================================================
    ==========================================================
    ======================= BİRLEŞTİR ========================
    ==========================================================
    ======================================================= */

	if( isset($_POST["FormAdi"]) and $_POST["FormAdi"] == "formBol" ) {

	}


    echo "================================================\n";
    echo "<h1>POST</h1>";     print_r($_POST);
    echo "<h1>FILES</h1>";    print_r($_FILES);

    foreach($_FILES['DosyalarTekli']['name'] as $key => $value) {
        if ($_FILES['DosyalarTekli']['size'][$key] > 1) {
        	move_uploaded_file($_FILES['DosyalarTekli']['tmp_name'][$key], "upload/TEK-" . $_FILES['DosyalarTekli']['name'][$key]);
        }
    }

    foreach($_FILES['DosyalarCoklu']['name'] as $key => $value) {
        if ($_FILES['DosyalarCoklu']['size'][$key] > 1) {
        	move_uploaded_file($_FILES['DosyalarCoklu']['tmp_name'][$key], "upload/COK-" . $_FILES['DosyalarCoklu']['name'][$key]);
        }
    }

    foreach($_FILES['AnaDosya1']['name'] as $key => $value) {
        if ($_FILES['AnaDosya1']['size'][$key] > 1) {
        	move_uploaded_file($_FILES['AnaDosya1']['tmp_name'][$key], "upload/ANA1-" . $_FILES['AnaDosya1']['name'][$key]);
        }
    }

    foreach($_FILES['AnaDosya2']['name'] as $key => $value) {
        if ($_FILES['AnaDosya2']['size'][$key] > 1) {
        	move_uploaded_file($_FILES['AnaDosya2']['tmp_name'][$key], "upload/ANA2-" . $_FILES['AnaDosya2']['name'][$key]);
        }
    }

    foreach($_FILES['HarmanPDF']['name'] as $key => $value) {
        if ($_FILES['HarmanPDF']['size'][$key] > 1) {
        	move_uploaded_file($_FILES['HarmanPDF']['tmp_name'][$key], "upload/HARMAN-" . $_FILES['HarmanPDF']['name'][$key]);
        }
    }

/*

=======================================================================
POST
    [FormAdi] => formBirlestir
    [AlinacakSayfalar] ARRAY
    [BirlestirmeSiralama] => |018-Temel-Komutlar-Ders-Notlar.pdf|5413183606-Subat 2020.PDF|Karbon Grup DNA.pdf|Vue-Essentials-Cheat-Sheet- KOPYA KAĞIDI.pdf
    [AyarBirlestir1] => on CHECKBOX
    [AyarBirlestir2] => on CHECKBOX
FILES
    DosyalarTekli
    DosyalarCoklu
=======================================================================
POST
    [FormAdi] => formBol
    [AyarBol1] => on CHECKBOX
    [AyarBol2] => 11
    [AyarBol3] => 22
    [AyarBol4] => 33
FILES
	AnaDosyaBol
=======================================================================
POST
    [FormAdi] => formResim1
    [AyarResimPDFYap1] => on CHECKBOX
    [AyarResimPDFYap2] => on CHECKBOX
FILES
	AnaDosyaResim1
=======================================================================
POST
    [FormAdi] => formResim2
    [AyarResim1] => on CHECKBOX
    [AyarResim2] => on CHECKBOX
FILES
	AnaDosyaResim2
=======================================================================
POST
    [FormAdi] => formHarmanla
	[Harman_AlinacakSayfalar] ARRAY
	[Harman_BaslamaSayfasi]   ARRAY
FILES
	HarmanPDF
=======================================================================
POST
    [FormAdi] => formArayaEkle
    [YeniPDF_Baslama]  ARRAY
    [YeniPDF_Sayfalar] ARRAY
FILES
	ArayaEkleAnaDosya
	ArayaEklePDF
=======================================================================
POST
    [FormAdi] => formYonet1
FILES
	YonetAnaPDF
=======================================================================
POST
    [FormAdi] => formYonet2
    [sayfa_no] ARRAY
    [sol] ARRAY
    [sag] ARRAY
    [dik] ARRAY
    [SilinecekSayfalar] => 11
    [EklenecekSayfalar] => 22
FILES
	(yok)
=======================================================================

*/

