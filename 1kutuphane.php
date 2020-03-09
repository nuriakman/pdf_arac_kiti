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

	function DosyalariYukle($arrYuklenecekDosyalar, $Tur = 'pdf', $Prefix='', $YeniDosyaAdi = '') {
		global $GENEL_AYARLAR;
		$Tur = strtolower($Tur); // Tür sadece 'pdf' veya 'img' olabilir
        // Sayac değişkeni, yüklenecek dosyalara verilecek isim için kullanılmaktadır.
	    foreach($arrYuklenecekDosyalar['name'] as $i => $value) {
	    	$dosyaTipi    = $arrYuklenecekDosyalar['type'][$i];
	    	$dosyaBoyutu  = $arrYuklenecekDosyalar['size'][$i];
	    	$dosyaTmpName = $arrYuklenecekDosyalar['tmp_name'][$i];
	    	$dosyaAdi     = $arrYuklenecekDosyalar['name'][$i];

			// Dosyayı yükleyelim...
        	//$YuklenecekYolveDosyaAdi = sprintf("{$GENEL_AYARLAR['UPLOAD_FOLDER']}%04d - $dosyaAdi.pdf", $Sayac + 1);
        	$YuklenecekYolveDosyaAdi = sprintf("{$GENEL_AYARLAR['UPLOAD_FOLDER']}{$Prefix}%04d", $i);
        	if($YeniDosyaAdi <> '') $YuklenecekYolveDosyaAdi = $GENEL_AYARLAR['UPLOAD_FOLDER'] . $YeniDosyaAdi; // Yeni dosya için isim verilmişse onu kullan...
        	if( move_uploaded_file($dosyaTmpName, $YuklenecekYolveDosyaAdi) ) {
        		// Yükleme başarılı
        	} else {
                // Yükleme başarısız
            }

	    } // foreach

	} // DosyalariYukle

    /* =======================================================
    ==========================================================
    =================== BOŞ DOSYA TEMİZLE ====================
    ==========================================================
    ======================================================= */

    function YuklenecekDosyalariTemizle($YuklenecekDosyalar, $Tur) {
        global $GENEL_AYARLAR;
        $Tur = strtolower($Tur); // Tür sadece 'pdf' veya 'img' olabilir
        if( !($Tur == "pdf" or $Tur == "img") ) return $Sayac;

        foreach($YuklenecekDosyalar['name'] as $key => $value) {
            $dosyaTipi    = $YuklenecekDosyalar['type'][$key];
            $dosyaBoyutu  = $YuklenecekDosyalar['size'][$key];
            $dosyaTmpName = $YuklenecekDosyalar['tmp_name'][$key];
            $dosyaAdi     = $YuklenecekDosyalar['name'][$key];
            $Sil = 0;
            if( $Tur == "pdf") {
                // İzin verilen türde bir dosya mı?
                if(!in_array($dosyaTipi, $GENEL_AYARLAR["mime_pdf"] ) )   $Sil = 1;
                // Dosya boyutu izin verilen ölçüde mi?
                if( $dosyaBoyutu > $GENEL_AYARLAR["MAX_PDF_SIZE_in_mb"] ) $Sil = 1;
            }

            if( $Tur == "img") {
                // İzin verilen türde bir dosya mı?
                if(!in_array($dosyaTipi, $GENEL_AYARLAR["mime_img"] ) )   $Sil = 1;
                // Dosya boyutu izin verilen ölçüde mi?
                if( $dosyaBoyutu > $GENEL_AYARLAR["MAX_IMG_SIZE_in_mb"] ) $Sil = 1;
            }

            if($dosyaBoyutu == 0) $Sil = 1;

            if($Sil == 1) {
                unset($YuklenecekDosyalar['type'][$key]);
                unset($YuklenecekDosyalar['size'][$key]);
                unset($YuklenecekDosyalar['tmp_name'][$key]);
                unset($YuklenecekDosyalar['name'][$key]);
            }
        }
        return $YuklenecekDosyalar;
    } // YuklenecekDosyalariTemizle


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
        $KOMUT = "pdfinfo $Dosya | grep -a 'Pages' | cut -d\: -f2";
        // echo "$KOMUT\n";
        $cevap = shell_exec($KOMUT);  // echo "<p><b>KOMUT:</b>$KOMUT</p>";
        $SayfaAdedi = trim($cevap) * 1;
        if($SayfaAdedi<=0) return 0;
        return $SayfaAdedi;
    } // PDFDosyaSayfaSayisi




    /* =======================================================
    ==========================================================
    ================ DesendekiSayfalar =================
    ==========================================================
    ======================================================= */
    function DesendekiSayfalar($SayfaAdedi, $Desen) {

        //echo "DesendekiSayfalar($SayfaAdedi, $Desen)\n";
       
        $arrSayfalar = array();

        if($Desen == "Hepsi") {
            // Desen yoksa, Tüm sayfaları alacak şekilde ayarla
            for($i=1; $i <= $SayfaAdedi; $i++) {
                $arrSayfalar[] = $i;
            }
            return $arrSayfalar;
        }

        // 0-9, virgül ve tire karakterleri kalsın. Gerisini temizle...
        $Desen = preg_replace('/[^0-9\,\-]/i', '', $Desen);

        $Desen = "," . $Desen; // Sadece aralık verilerek yapılmış bir Desen varsa patlamayalım diye...

        $arrSayfa = explode(",", $Desen);

        foreach ($arrSayfa as $key2 => $value2) {

            if($arrSayfa[$key2] == "") continue;

            $Hata = 0; 

            $arrAralik = explode("-", $arrSayfa[$key2]);
            if( count($arrAralik) == 2 ) {
                // Aralık alınması istenmiş
                $Baslama = $arrAralik[0];
                $Bitis   = $arrAralik[1];

                if( $Baslama > $SayfaAdedi ) {
                    $Hata = 1;
                }

                if( $Bitis > $SayfaAdedi ) {
                    $Bitis = $SayfaAdedi;
                }

                if( $Bitis == "" ) {
                    // 15- gibi bir şey yazılmış. Yani, 15 ve sonrası
                    $Bitis = $SayfaAdedi;
                }

                if( $Baslama == "" ) {
                    // -15 gibi bir şey yazılmış. Yani, 15 ve öncesi
                    $Baslama = 1;
                }

                if( $Hata == 0 ) {
                    for($i=$Baslama; $i <= $Bitis; $i++) {
                        if( !in_array($i, $arrSayfalar) ) {
                            $arrSayfalar[] = $i;
                        }
                    }
                }
                continue;
            }

            // Tek sayfa isteniyor
            $tmp = intval($arrSayfa[$key2]);
            if($tmp >= 1 and $tmp <= $SayfaAdedi ) {
                if( !in_array($tmp, $arrSayfalar) ) {
                    $arrSayfalar[] = $tmp;
                }
            }

        }

        return $arrSayfalar;

    } // DesendekiSayfalar



    /* =======================================================
    ==========================================================
    ======================= SayidanHarf ======================
    ==========================================================
    ======================================================= */
    function SayidanHarf($SAYI) {
        // SAYI verip, karşılığında HARF alma fonksiyonu
        $HarfSIFIR = "M";
        $HARFLER   = "ABCDEFGHIJ";
        if($SAYI == 0) return $HarfSIFIR;

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
    ===================== SayfalariDoldur ====================
    ==========================================================
    ======================================================= */
    function SayfalariDoldur($SayfaAdedi) {
        $arrSONUC = array();
        for($i=1; $i <= $SayfaAdedi; $i++) {
            $arrSONUC[] = $i;
        }
        return $arrSONUC;
    }




    /* =======================================================
    ==========================================================
    ================== SayfalariSadelestir ===================
    ==========================================================
    ======================================================= */
    function SayfalariSadelestir($arrSayilar) {
        // Sadeleştirme İşlemi: Örnek: 1..120 arası değerler varsa 1-120 olarak değiştirilebilir.
        // TODO: Burada daha fazla sadeleştirmeye gidilebilir. Örnek sayafalar: 1..20, 25, 28, 35-45
        
        if( count($arrSayilar) == 0 ) return $arrSayilar;

        $ilk = "ilk";
        $c   = "ilk";
        $son = 0;
        $Sirali = 1;
        foreach ($arrSayilar as $k => $v) {
            if($ilk == "ilk") {
                $ilk = $v;
                $c   = $ilk;
            }

            if($c <> $v) {
                $Sirali = 0;
            } else {
                $son = $v;
                $c++;
            }
        }

        if( $Sirali == 1 ) {
            unset($arrSayilar);
            $arrSayilar[] = $ilk . "-" . $son;
            // echo "-----------" . $ilk . "-" . $son . "\n\n";
        }
        
        return $arrSayilar;

    } // SayfalariSadelestir



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


