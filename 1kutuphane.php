<?php

    /* =======================================================
    ==========================================================
    ===================== GENEL AYARLAR ======================
    ==========================================================
    ======================================================= */

    $GENEL_AYARLAR = array();
	$GENEL_AYARLAR["MAX_PDF_SIZE_in_mb"] = 10 * 1024 * 1024; // Byte cinsinden
	$GENEL_AYARLAR["MAX_IMG_SIZE_in_mb"] = 10 * 1024 * 1024; // Byte cinsinden
	
	$GENEL_AYARLAR["UPLOAD_FOLDER"] = "upload/"; // Sonunda '/' var!
    $GENEL_AYARLAR["BOS_SAYFA"]     = "0bossayfa.pdf"; // Bu dosyanın konumuna göre relatif adres
    $GENEL_AYARLAR["BOS"]           = "BOS.PDF"; // Boş sayfa için kullanılacak isimdir.
	
	// Dosya Tipleri için kaynak: https://stackoverflow.com/questions/7519393/php-mime-types-list-of-mime-types-publically-available
	$GENEL_AYARLAR["mime_pdf"][] = "application/pdf";
	$GENEL_AYARLAR["mime_img"][] = 'image/jpeg';
	$GENEL_AYARLAR["mime_img"][] = 'image/pjpeg';
	$GENEL_AYARLAR["mime_img"][] = 'image/jpeg';
	$GENEL_AYARLAR["mime_img"][] = 'image/jpeg';
	$GENEL_AYARLAR["mime_img"][] = 'image/pjpeg';
	$GENEL_AYARLAR["mime_img"][] = 'image/jpeg';
	$GENEL_AYARLAR["mime_img"][] = 'image/pjpeg';
	$GENEL_AYARLAR["mime_img"][] = 'image/jpeg';
	$GENEL_AYARLAR["mime_img"][] = 'image/pjpeg';
	$GENEL_AYARLAR["mime_img"][] = 'image/png';
	$GENEL_AYARLAR["mime_img"][] = 'image/png';
	$GENEL_AYARLAR["mime_img"][] = 'application/pdf';



    /* =======================================================
    ==========================================================
    ===================== DOSYA YÜKLEME ======================
    ==========================================================
    ======================================================= */

	function DosyalariYukle($FilesDegiskeniAdi, $Tur= 'pdf', $Sayac=0, $YeniDosyaAdi = '') {
		global $GENEL_AYARLAR;
		$Tur = strtolower($Tur); // Tür sadece 'pdf' veya 'img' olabilir
		if( !($Tur == "pdf" or $Tur == "img") ) return $Sayac;

	    foreach($_FILES[$FilesDegiskeniAdi]['name'] as $key => $value) {
	    	$dosyaTipi    = $_FILES[$FilesDegiskeniAdi]['type'][$key];
	    	$dosyaBoyutu  = $_FILES[$FilesDegiskeniAdi]['size'][$key];
	    	$dosyaTmpName = $_FILES[$FilesDegiskeniAdi]['tmp_name'][$key];
	    	$dosyaAdi     = $_FILES[$FilesDegiskeniAdi]['name'][$key];

			if( $Tur == "pdf") {
				// İzin verilen türde bir dosya mı?
				if(!in_array($dosyaTipi, $GENEL_AYARLAR["mime_pdf"] ) )   continue;
				// Dosya boyutu izin verilen ölçüde mi?
				if( $dosyaBoyutu > $GENEL_AYARLAR["MAX_PDF_SIZE_in_mb"] ) continue;
			}

			if( $Tur == "img") {
				// İzin verilen türde bir dosya mı?
				if(!in_array($dosyaTipi, $GENEL_AYARLAR["mime_img"] ) )   continue;
				// Dosya boyutu izin verilen ölçüde mi?
				if( $dosyaBoyutu > $GENEL_AYARLAR["MAX_IMG_SIZE_in_mb"] ) continue;
			}

			// Dosyayı yükleyelim...
        	//$YuklenecekYolveDosyaAdi = sprintf("{$GENEL_AYARLAR['UPLOAD_FOLDER']}%04d - $dosyaAdi.pdf", $Sayac + 1);
        	$YuklenecekYolveDosyaAdi = sprintf("{$GENEL_AYARLAR['UPLOAD_FOLDER']}%04d", $Sayac);
        	if($YeniDosyaAdi <> '') $YuklenecekYolveDosyaAdi = $GENEL_AYARLAR['UPLOAD_FOLDER'] . $YeniDosyaAdi; // Yeni dosya için isim verilmişse onu kullan...
        	if( move_uploaded_file($dosyaTmpName, $YuklenecekYolveDosyaAdi) ) {
        		$Sayac++;
        	}

	    } // foreach

	    return $Sayac;

	} // DosyalariYukle


    /* =======================================================
    ==========================================================
    ======================= XXXX ========================
    ==========================================================
    ======================================================= */
    function PDFDosyaSayfaSayisi($Dosya, $UploadFolder = '') {
        global $GENEL_AYARLAR;

        if($UploadFolder == '') $UploadFolder = $GENEL_AYARLAR["UPLOAD_FOLDER"];
        $Dosya = $UploadFolder . $Dosya;
        
        // PDF'in sayfa sayısını bulalım
        $KOMUT = "pdfinfo $Dosya | grep 'Pages' | cut -d\: -f2";
        // echo $KOMUT;
        $cevap = shell_exec($KOMUT);  // echo "<p><b>KOMUT:</b>$KOMUT</p>";
        $SayfaAdedi = trim($cevap) * 1;
        if($SayfaAdedi<=0) return 0;
        return $SayfaAdedi;
    }




    /* =======================================================
    ==========================================================
    ================ AlinacakSayfalariAyarla =================
    ==========================================================
    ======================================================= */
    function AlinacakSayfalariAyarla($Dosya, $SayfaAdedi, $Desen) {

        // echo "AlinacakSayfalariAyarla($Dosya, $SayfaAdedi, $Desen)";

        // 0-9, virgül ve tire karakterleri kalsın. Gerisini temizle...
        $Desen = preg_replace('/[^0-9\,\-]/i', '', $Desen);
        
        $arrSayfalar = array();

        if($Desen == "") {
            // Desen yoksa, Tüm sayfaları alacak şekilde ayarla
            for($i=0; $i < $SayfaAdedi; $i++) {
                $arrSayfalar[$i] = $i;
            }
            return $arrSayfalar;
        }

        $Desen = "," . $Desen; // Sadece aralık verilerek yapılmış bir Desen varsa patlamayalım diye...

        $arrSayfa = explode(",", $Desen);

        foreach ($arrSayfa as $key2 => $value2) {

            if($arrSayfa[$key2] == "") continue;

            $arrAralik = explode("-", $arrSayfa[$key2]);

            if( count($arrAralik) == 2 ) {
                // Aralık alınması istenmiş
                if( $arrAralik[1] > $SayfaAdedi ) {
                    $arrAralik[1] = $SayfaAdedi;
                }

                if( $arrAralik[1] == "" ) {
                    // 15- gibi bir şey yazılmış. Yani, 15 ve sonrası. Onu uyarlayalım...
                    $arrAralik[1] = $SayfaAdedi;
                }

                for($i=$arrAralik[0]; $i <= $arrAralik[1]; $i++) {
                    $arrSayfalar[] = $i;
                }
                continue;
            }

            // Tek sayfa isteniyor
            $tmp = intval($arrSayfa[$key2]);
            if($tmp > 0) $arrSayfalar[] = $tmp;

        }

        return $arrSayfalar;

    } // AlinacakSayfalariAyarla



    /* =======================================================
    ==========================================================
    ======================= SayidanHarf ======================
    ==========================================================
    ======================================================= */
    function SayidanHarf($SAYI) {
        // SAYI verip, karşılığında HARF alma fonksiyonu
        $HARFLER = "ABCDEFGHIJ";
        $STR = trim("$SAYI");
        $SONUC = "";
        for($i=0; $i < strlen($STR); $i++) {
            $RAKAM = $STR[$i];
            $SONUC .= $HARFLER[$RAKAM];
        }
        return $SONUC;

    }




    /* =======================================================
    ==========================================================
    ======================= XXXX ========================
    ==========================================================
    ======================================================= */




    /* =======================================================
    ==========================================================
    ======================= XXXX ========================
    ==========================================================
    ======================================================= */




    /* =======================================================
    ==========================================================
    ======================= XXXX ========================
    ==========================================================
    ======================================================= */




    /* =======================================================
    ==========================================================
    ======================= XXXX ========================
    ==========================================================
    ======================================================= */


