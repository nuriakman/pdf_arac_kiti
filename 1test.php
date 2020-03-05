<?php
	require_once('1kutuphane.php');

    /* =======================================================
    ==========================================================
    ======================= BİRLEŞTİR ========================
    ==========================================================
    ======================================================= */

	/*
	POST
	    [FormAdi] => formBirlestir
	    [AlinacakSayfalar] ARRAY
	    [BirlestirmeSiralama] => |Notlar.pdf|5413183606.PDF|Karbon.pdf|Vue.pdf
	    [AyarBirlestir1] => on CHECKBOX
	    [AyarBirlestir2] => on CHECKBOX
	    [AyarBirlestir3] => on CHECKBOX
	FILES
	    DosyalarTekli
	    DosyalarCoklu
	*/

	if( isset($_POST["FormAdi"]) and $_POST["FormAdi"] == "formBirlestir" ) {
    	
    	// Upload klasöründeki tüm dosyaları temizle...
    	$KOMUT = "rm -rf upload/*";
    	$cevap = shell_exec($KOMUT);

    	// Boş Sayfayı UPLOAD klasörüne kopyala
    	$KOMUT = sprintf("cp %s %s%s", $GENEL_AYARLAR["BOS_SAYFA"], $GENEL_AYARLAR["UPLOAD_FOLDER"], $GENEL_AYARLAR["BOS"]);
    	$cevap = shell_exec($KOMUT);

    	$arrHATA = array();

    	// Seçilmiş dosyaları UPLOAD klasörüne dosya adı 0001, 0002 olacak biçimde yükle.
    	$Tekli = 0;
	    foreach($_FILES['DosyalarTekli']['name'] as $key => $value) {
	        if ($_FILES['DosyalarTekli']['size'][$key] > 1) {
	        	$Tekli++;
	        }
	    }

    	$Coklu = 0;
	    foreach($_FILES['DosyalarCoklu']['name'] as $key => $value) {
	        if ($_FILES['DosyalarCoklu']['size'][$key] > 1) {
	        	$Coklu++;
	        }
	    }

	    if($Tekli == 0 and $Coklu == 0) {
	    	$arrHATA[] = "Hiç dosya seçmediniz";
	    }


    	$c=0;

    	$c = DosyalariYukle("DosyalarTekli", 'pdf', $c);

    	if($_POST['BirlestirmeSiralama'] <> '') {

    		// İlk karakter '|'. Bunu silelim...
    		$_POST['BirlestirmeSiralama'] = substr($_POST['BirlestirmeSiralama'], 1);

    		$arrSiralama = explode('|', $_POST['BirlestirmeSiralama']);

    		// $_FILES değişkenini, kullanıcının belirlediği sıralamaya göre sıralayalım...
    		foreach ($arrSiralama as $key1 => $value1) {
    			// Sıralama aynı ise deevam et
    			if ($_FILES['DosyalarCoklu']['name'][$key1] == $arrSiralama[$key1] ) continue;
    			
    			// Sıralama aynı değil. Mevcut bilgileri tmp değişkenlere koyalım
    			$tmp1 = $_FILES['DosyalarCoklu']['name'    ][$key1];
    			$tmp2 = $_FILES['DosyalarCoklu']['type'    ][$key1];
    			$tmp3 = $_FILES['DosyalarCoklu']['tmp_name'][$key1];
    			$tmp4 = $_FILES['DosyalarCoklu']['size'    ][$key1];
    			$tmp5 = $_FILES['DosyalarCoklu']['error'   ][$key1];
    			
    			// Geri kalan dosyalarda arayıp sıradaki dosyayı bulalım
    			for($i=$key1; $i < count($_FILES['DosyalarCoklu']['name']); $i++) {
    				if( $_FILES['DosyalarCoklu']['name'][$i] == $arrSiralama[$key1] ) {
    					// Bulduğumuza göre swap yapalım.
    					$_FILES['DosyalarCoklu']['name'    ][$key1] = $_FILES['DosyalarCoklu']['name'    ][$i];
    					$_FILES['DosyalarCoklu']['type'    ][$key1] = $_FILES['DosyalarCoklu']['type'    ][$i];
    					$_FILES['DosyalarCoklu']['tmp_name'][$key1] = $_FILES['DosyalarCoklu']['tmp_name'][$i];
    					$_FILES['DosyalarCoklu']['size'    ][$key1] = $_FILES['DosyalarCoklu']['size'    ][$i];
    					$_FILES['DosyalarCoklu']['error'   ][$key1] = $_FILES['DosyalarCoklu']['error'   ][$i];
    					
    					$_FILES['DosyalarCoklu']['name'    ][$i] = $tmp1;
    					$_FILES['DosyalarCoklu']['type'    ][$i] = $tmp2;
    					$_FILES['DosyalarCoklu']['tmp_name'][$i] = $tmp3;
    					$_FILES['DosyalarCoklu']['size'    ][$i] = $tmp4;
    					$_FILES['DosyalarCoklu']['error'   ][$i] = $tmp5;
    				}
    			} // for
    		} // foreach
    	} // if($_POST['BirlestirmeSiralama'] <> '') {

    	$c = DosyalariYukle("DosyalarCoklu", 'pdf', $c);


		$temp = $_POST["AlinacakSayfalar"];
		unset($temp[0]); // İlk eleman gizli. Kullanılmıyor...
    	foreach ($temp as $key => $value) {
			// 0-9, virgül ve tire karakterleri kalsın. Gerisini temizle...
			$arrAlinacakSayfalar[] = preg_replace('/[^0-9\,\-]/i', '', $temp[$key]);
		}
		// print_r($arrAlinacakSayfalar);

    	$arrPDFs = array();
    	for($i=0; $i < $c; $i++) {
    		$Desen = $arrAlinacakSayfalar[$i];
    		$Dosya = sprintf("%04d", $i);
    		$SayfaAdedi = PDFDosyaSayfaSayisi( $Dosya );
    		$arrPDFs[$i]['ALIAS']       = SayidanHarf($i); // Bu fonksiyona SIFIR gönderilemez.
    		$arrPDFs[$i]['DosyaAdi']    = $Dosya;
    		$arrPDFs[$i]['SayfaAdedi']  = $SayfaAdedi;
    		$arrPDFs[$i]['Alinacaklar'] = AlinacakSayfalariAyarla($Dosya, $SayfaAdedi, $Desen);
    	}


    	$GIRDI  = "pdftk ";
    	$ALINAN = "cat ";
    	$SONUC  = "output SONUC.PDF";
    	foreach ($arrPDFs as $k => $v) {
    		$GIRDI  .= sprintf("%s=%s ", $arrPDFs[$k]['ALIAS'], $arrPDFs[$k]['DosyaAdi']);
    		foreach ($arrPDFs[$k]['Alinacaklar'] as $k1 => $v1) {
    			$ALINAN .= $arrPDFs[$k]['ALIAS'] . $v1 . " ";
    		}
    		// Eklenen her dosya sağ sayfadan başlasın
    		if( isset($_POST["AyarBirlestir1"]) and $_POST["AyarBirlestir1"] == "on") {
	    		if( count($arrPDFs[$k]['Alinacaklar']) % 2 == 1 ) $ALINAN .= "W1 ";
    		}
    		// Dosyalar arasına 1 boş sayfa ekle
    		if( isset($_POST["AyarBirlestir2"]) and $_POST["AyarBirlestir2"] == "on") {
	    		$ALINAN .= "W1 ";
    		}
    		// Dosyalar arasına 2 boş sayfa ekle
    		if( isset($_POST["AyarBirlestir3"]) and $_POST["AyarBirlestir3"] == "on") {
	    		$ALINAN .= "W1 ";
	    		$ALINAN .= "W1 ";
    		}
    	}

    	if( !(strpos($ALINAN, "W1") === false) ) {
    		$GIRDI .= "W=" . $GENEL_AYARLAR["BOS"] . " ";
    	}

    	$KOMUT = "$GIRDI $ALINAN $SONUC";
	    
	    chdir("upload");
    	$cevap = shell_exec($KOMUT);
    	chdir("../");

    	
    	echo $KOMUT . "\n\n";

    	// print_r($arrPDFs);



    	echo "***  \n";
    	echo "================== BİRLEŞTİR \n";
    	echo "================== BİRLEŞTİR \n";
    	echo "================== BİRLEŞTİR \n";
    	//die();
	}

    /* =======================================================
    ==========================================================
    ========================== SİL ===========================
    ==========================================================
    ======================================================= */
	/*
	POST
	    [FormAdi] => formSil
	    [AyarSil1] => 123
	    [AyarSil2] => on
	    [AyarSil3] => on
	FILES
		AnaDosyaSil

	*/

	if( isset($_POST["FormAdi"]) and $_POST["FormAdi"] == "formSil" ) {
    	
    	// Upload klasöründeki tüm dosyaları temizle...
    	$KOMUT = "rm -rf upload/*";
    	$cevap = shell_exec($KOMUT);

    	$arrHATA = array();

    	// Seçilmiş dosyaları UPLOAD klasörüne dosya adı 0001, 0002 olacak biçimde yükle.
    	$Tekli = 0;
	    foreach($_FILES['AnaDosyaSil']['name'] as $key => $value) {
	        if ($_FILES['AnaDosyaSil']['size'][$key] > 1) {
	        	$Tekli++;
	        }
	    }

	    if($Tekli == 0) {
	    	$arrHATA[] = "Hiç dosya seçmediniz";
	    }


    	$c=0;

    	$c = DosyalariYukle("AnaDosyaSil", 'pdf', $c);

		// 0-9, virgül ve tire karakterleri kalsın. Gerisini temizle...
		$arrSilinecekSayfalar[] = preg_replace('/[^0-9\,\-]/i', '', $_POST["AyarSil1"] );

		// print_r($arrSilinecekSayfalar);

    	$arrPDFs = array();
    	for($i=0; $i < $c; $i++) {
    		$Desen = $arrSilinecekSayfalar[$i];
    		$Dosya = sprintf("%04d", $i);
    		$SayfaAdedi = PDFDosyaSayfaSayisi( $Dosya );
    		$arrPDFs[$i]['ALIAS']       = SayidanHarf($i); // Bu fonksiyona SIFIR gönderilemez.
    		$arrPDFs[$i]['DosyaAdi']    = $Dosya;
    		$arrPDFs[$i]['SayfaAdedi']  = $SayfaAdedi;
    		$arrPDFs[$i]['Sayfalar']    = AlinacakSayfalariAyarla($Dosya, $SayfaAdedi, $Desen);
    	}

		//print_r($arrPDFs);

		$TekleriSil  = 0;
		$CiftleriSil = 0;

		// Dosyalar arasına 1 boş sayfa ekle
		if( isset($_POST["AyarSil2"]) and $_POST["AyarSil2"] == "on") {
    		$TekleriSil = 1;
		}
		// Dosyalar arasına 2 boş sayfa ekle
		if( isset($_POST["AyarSil3"]) and $_POST["AyarSil3"] == "on") {
    		$CiftleriSil = 1;
		}
    	
    	$GIRDI  = "pdftk ";
    	$ALINAN = "cat ";
    	$SONUC  = "output SONUC.PDF";

    	
    	foreach ($arrPDFs as $k => $v) {

			// Girdi için ALIAS belirleyelim...
			$GIRDI  .= sprintf("%s=%s ", $arrPDFs[$k]['ALIAS'], $arrPDFs[$k]['DosyaAdi']);

    		$arrSONUC_Sayfalar = array();
	    	for($SayfaNo=1; $SayfaNo <= $arrPDFs[$k]['SayfaAdedi']; $SayfaNo++) {

	    		$Sil = 0;

	    		if($TekleriSil == 1) { // Tek Sayfaları Sil
					if($SayfaNo % 2 == 1) $Sil = 1;
				}
	    		if($CiftleriSil == 1) { // Çift Sayfaları Sil
					if($SayfaNo % 2 == 0) $Sil = 1;
				}

				// İstenmayen sayfaları sil
				if(in_array($SayfaNo, $arrPDFs[$k]['Sayfalar'])) $Sil = 1;

				// Silinmesi istenmemişsa bize lazım olan sayfadır.
				if($Sil == 0) $arrSONUC_Sayfalar[] = $SayfaNo;

	    	}

    		foreach ($arrSONUC_Sayfalar as $k1 => $v1) {
    			$ALINAN .= $arrPDFs[$k]['ALIAS'] . $v1 . " ";
    		}

			// print_r($arrSONUC_Sayfalar);
	    	unset($arrSONUC_Sayfalar);
	    }
    	$KOMUT = "$GIRDI $ALINAN $SONUC";
	    
	    chdir("upload");
    	$cevap = shell_exec($KOMUT);
    	chdir("../");
    	
    	echo "KOMUT:\n" . $KOMUT . "\n\n";

    	// print_r($arrPDFs);



    	echo "***  \n";
    	echo "================== SİL \n";
    	echo "================== SİL \n";
    	echo "================== SİL \n";
    	//die();
	}



    /* =======================================================
    ==========================================================
    ========================== BÖL ===========================
    ==========================================================
    ======================================================= */
	/*
	POST
	    [FormAdi] => formBol
	    [AyarBol1] => on CHECKBOX
	    [AyarBol2] => 11
	    [AyarBol3] => 22
	    [AyarBol4] => 33
	FILES
		AnaDosyaBol
	*/
	if( isset($_POST["FormAdi"]) and $_POST["FormAdi"] == "formBol" ) {
    	
    	// Upload klasöründeki tüm dosyaları temizle...
    	$KOMUT = "rm -rf upload/*";
    	$cevap = shell_exec($KOMUT);

    	$arrHATA = array();

    	// Seçilmiş dosyaları UPLOAD klasörüne dosya adı 0001, 0002 olacak biçimde yükle.
    	$Tekli = 0;
	    foreach($_FILES['AnaDosyaBol']['name'] as $key => $value) {
	        if ($_FILES['AnaDosyaBol']['size'][$key] > 1) {
	        	$Tekli++;
	        }
	    }

	    if($Tekli == 0) {
	    	$arrHATA[] = "Hiç dosya seçmediniz";
	    }


    	$c=0;

    	$c = DosyalariYukle("AnaDosyaBol", 'pdf', $c);

		// 0-9, virgül ve tire karakterleri kalsın. Gerisini temizle...
		$arrBol3[] = preg_replace('/[^0-9\,\-]/i', '', $_POST["AyarBol3"] );
		$arrBol4[] = preg_replace('/[^0-9\,\-]/i', '', $_POST["AyarBol4"] );


		$SayfaAdedi = PDFDosyaSayfaSayisi( "0000" );
/*
		// Her bir sayfayı ayrı PDF yap
		if( isset($_POST["AyarBol1"]) and $_POST["AyarBol1"] == "on") {

			if($SayfaAdedi < 100000) $KOMUT = "pdftk 0000 burst output Sayfa_%05d.pdf";
			if($SayfaAdedi < 10000 ) $KOMUT = "pdftk 0000 burst output Sayfa_%04d.pdf";
			if($SayfaAdedi < 1000  ) $KOMUT = "pdftk 0000 burst output Sayfa_%03d.pdf";
			if($SayfaAdedi < 100   ) $KOMUT = "pdftk 0000 burst output Sayfa_%02d.pdf";
			if($SayfaAdedi < 10    ) $KOMUT = "pdftk 0000 burst output Sayfa_%01d.pdf";
	    	
		    echo $KOMUT;
		    chdir("upload");
	    	$cevap = shell_exec($KOMUT);
	    	chdir("../");
		}

		// Dosyayı X sayfalık parçalara böl
		$SayfaBlogu = intval($_POST["AyarBol2"]);
		if( isset($_POST["AyarBol2"]) and $SayfaBlogu >= 1) {
			$Bas  = 1;
			$Bit  = $SayfaBlogu;
			$Bolum= 0;
			while($Bit < $SayfaAdedi - 1) {
				$Bas = $Bit;
				$Bit = $Bit + $SayfaBlogu;
				if($Bit > $SayfaAdedi) $Bit = $SayfaAdedi;
				$Bolum++;
				if($SayfaAdedi / $SayfaBlogu < 10000) $KOMUT = sprintf("pdftk 0000 cat {$Bas}-{$Bit} output Bolum_%03d.pdf", $Bolum);
				if($SayfaAdedi / $SayfaBlogu < 1000)  $KOMUT = sprintf("pdftk 0000 cat {$Bas}-{$Bit} output Bolum_%03d.pdf", $Bolum);
				if($SayfaAdedi / $SayfaBlogu < 100)   $KOMUT = sprintf("pdftk 0000 cat {$Bas}-{$Bit} output Bolum_%02d.pdf", $Bolum);
				if($SayfaAdedi / $SayfaBlogu < 10)    $KOMUT = sprintf("pdftk 0000 cat {$Bas}-{$Bit} output Bolum_%01d.pdf", $Bolum);
			    echo "$KOMUT\n";
			    chdir("upload");
		    	$cevap = shell_exec($KOMUT);
		    	chdir("../");
			}

		}
*/

		// PDF dosyayı şu sayfalardan bölerek ayrı dosyalar yap
		$arrSayfa = explode(",", $_POST["AyarBol3"]);
		foreach ($arrSayfa as $key => $value) {
			$arrSayfa[$key] = intval($value);
			if($arrSayfa[$key] > $SayfaAdedi) $arrSayfa[$key] = $SayfaAdedi;
		}
		$arrSayfa = array_unique($arrSayfa);
		asort($arrSayfa);
		$arrSayfa[] = $SayfaAdedi+1;

		$Bas   = 1;
		$Bolum = 0;
		for($i=0; $i<count($arrSayfa); $i++) {
			$Bit = $arrSayfa[$i] - 1;
			$KOMUT = sprintf("pdftk 0000 cat {$Bas}-{$Bit} output Sayfalar_{$Bas}-{$Bit}.pdf", $Bolum);
			$Bas = $Bit + 1;
		    echo "$KOMUT\n";
		    chdir("upload");
	    	$cevap = shell_exec($KOMUT);
	    	chdir("../");
		}

print_r($arrSayfa); die();

		if( isset($_POST["AyarBol2"]) and $SayfaBlogu >= 1) {
			$Bas  = 1;
			$Bit  = $SayfaBlogu;
			$Bolum= 0;
			while($Bit < $SayfaAdedi - 1) {
				$Bas = $Bit;
				$Bit = $Bit + $SayfaBlogu;
				if($Bit > $SayfaAdedi) $Bit = $SayfaAdedi;
				$Bolum++;
				if($SayfaAdedi / $SayfaBlogu < 10000) $KOMUT = sprintf("pdftk 0000 cat {$Bas}-{$Bit} output Bolum_%03d.pdf", $Bolum);
				if($SayfaAdedi / $SayfaBlogu < 1000)  $KOMUT = sprintf("pdftk 0000 cat {$Bas}-{$Bit} output Bolum_%03d.pdf", $Bolum);
				if($SayfaAdedi / $SayfaBlogu < 100)   $KOMUT = sprintf("pdftk 0000 cat {$Bas}-{$Bit} output Bolum_%02d.pdf", $Bolum);
				if($SayfaAdedi / $SayfaBlogu < 10)    $KOMUT = sprintf("pdftk 0000 cat {$Bas}-{$Bit} output Bolum_%01d.pdf", $Bolum);
			    echo "$KOMUT\n";
			    chdir("upload");
		    	$cevap = shell_exec($KOMUT);
		    	chdir("../");
			}

		}

die("\n\nBİTTİ...");
		// print_r($arrBol1);

    	$arrPDFs = array();
    	for($i=0; $i < $c; $i++) {
    		$Desen3 = $arrBol3[$i];
    		$Desen4 = $arrBol4[$i];
    		$Dosya = sprintf("%04d", $i);
    		$SayfaAdedi = PDFDosyaSayfaSayisi( $Dosya );
    		$arrPDFs[$i]['ALIAS']       = SayidanHarf($i); // Bu fonksiyona SIFIR gönderilemez.
    		$arrPDFs[$i]['DosyaAdi']    = $Dosya;
    		$arrPDFs[$i]['SayfaAdedi']  = $SayfaAdedi;
    		$arrPDFs[$i]['Sayfalar3']    = AlinacakSayfalariAyarla($Dosya, $SayfaAdedi, $Desen3);
    		$arrPDFs[$i]['Sayfalar4']    = AlinacakSayfalariAyarla($Dosya, $SayfaAdedi, $Desen4);
    	}

		//print_r($arrPDFs);

		$TekleriSil  = 0;
		$CiftleriSil = 0;

		// Dosyalar arasına 1 boş sayfa ekle
		if( isset($_POST["AyarBol2"]) and $_POST["AyarBol2"] == "on") {
    		$TekleriSil = 1;
		}
		// Dosyalar arasına 2 boş sayfa ekle
		if( isset($_POST["AyarBol3"]) and $_POST["AyarBol3"] == "on") {
    		$CiftleriSil = 1;
		}
    	
    	$GIRDI  = "pdftk ";
    	$ALINAN = "cat ";
    	$SONUC  = "output SONUC.PDF";

    	
    	foreach ($arrPDFs as $k => $v) {

			// Girdi için ALIAS belirleyelim...
			$GIRDI  .= sprintf("%s=%s ", $arrPDFs[$k]['ALIAS'], $arrPDFs[$k]['DosyaAdi']);

    		$arrSONUC_Sayfalar = array();
	    	for($SayfaNo=1; $SayfaNo <= $arrPDFs[$k]['SayfaAdedi']; $SayfaNo++) {

	    		$Sil = 0;

	    		if($TekleriSil == 1) { // Tek Sayfaları Sil
					if($SayfaNo % 2 == 1) $Sil = 1;
				}
	    		if($CiftleriSil == 1) { // Çift Sayfaları Sil
					if($SayfaNo % 2 == 0) $Sil = 1;
				}

				// İstenmayen sayfaları sil
				if(in_array($SayfaNo, $arrPDFs[$k]['Sayfalar'])) $Sil = 1;

				// Silinmesi istenmemişsa bize lazım olan sayfadır.
				if($Sil == 0) $arrSONUC_Sayfalar[] = $SayfaNo;

	    	}

    		foreach ($arrSONUC_Sayfalar as $k1 => $v1) {
    			$ALINAN .= $arrPDFs[$k]['ALIAS'] . $v1 . " ";
    		}

			// print_r($arrSONUC_Sayfalar);
	    	unset($arrSONUC_Sayfalar);
	    }
    	$KOMUT = "$GIRDI $ALINAN $SONUC";
	    
	    chdir("upload");
    	$cevap = shell_exec($KOMUT);
    	chdir("../");
    	
    	echo "KOMUT:\n" . $KOMUT . "\n\n";

    	// print_r($arrPDFs);



    	echo "***  \n";
    	echo "================== SİL \n";
    	echo "================== SİL \n";
    	echo "================== SİL \n";
    	//die();
	}




    echo "\n\n\n";
    echo "============= GELEN VERİLER \n";
    echo "============= GELEN VERİLER \n";
    echo "============= GELEN VERİLER \n";
    echo "<h1>POST</h1>";     print_r($_POST);
    echo "<h1>FILES</h1>";    print_r($_FILES);
/*
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
*/
/*

=======================================================================
POST
    [FormAdi] => formBirlestir
    [AlinacakSayfalar] ARRAY
    [BirlestirmeSiralama] => |018-Temel-Komutlar-Ders-Notlar.pdf|5413183606-Subat 2020.PDF|Karbon Grup DNA.pdf|Vue-Essentials-Cheat-Sheet- KOPYA KAĞIDI.pdf
    [AyarBirlestir1] => on CHECKBOX
    [AyarBirlestir2] => on CHECKBOX
    [AyarBirlestir3] => on CHECKBOX
FILES
    DosyalarTekli
    DosyalarCoklu
=======================================================================
POST
    [FormAdi] => formSil
    [AyarSil1] => 123
    [AyarSil2] => on
    [AyarSil3] => on
FILES
	AnaDosyaSil
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

