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

    	$arrDosyalarTekli = $_FILES["DosyalarTekli"];
    	$arrDosyalarCoklu = $_FILES["DosyalarCoklu"];

    	// Seçilen dosyalar arasında BOŞ veya GEÇERSİZ dosya varsa sil...
    	$arrDosyalarTekli = YuklenecekDosyalariTemizle($arrDosyalarTekli, 'pdf');
    	$arrDosyalarCoklu = YuklenecekDosyalariTemizle($arrDosyalarCoklu, 'pdf');

    	// Seçilmiş dosyaları UPLOAD klasörüne dosya adı 0001, 0002 olacak biçimde yükle.
    	$Prefix = "TEK";
    	DosyalariYukle($arrDosyalarTekli, 'pdf', $Prefix);

    	// Çoklu dosya yükleme yapılmışsa sıralama işlemi için...
    	if($_POST['BirlestirmeSiralama'] <> '') {

    		// İlk karakter '|'. Bunu silelim...
    		$_POST['BirlestirmeSiralama'] = substr($_POST['BirlestirmeSiralama'], 1);

    		$arrSiralama = explode('|', $_POST['BirlestirmeSiralama']);

    		// $_FILES değişkenini, kullanıcının belirlediği sıralamaya göre sıralayalım...
    		foreach ($arrSiralama as $key1 => $value1) {
    			// Sıralama aynı ise deevam et
    			if ($arrDosyalarCoklu['name'][$key1] == $arrSiralama[$key1] ) continue;
    			
    			// Sıralama aynı değil. Mevcut bilgileri tmp değişkenlere koyalım
    			$tmp1 = $arrDosyalarCoklu['name'    ][$key1];
    			$tmp2 = $arrDosyalarCoklu['type'    ][$key1];
    			$tmp3 = $arrDosyalarCoklu['tmp_name'][$key1];
    			$tmp4 = $arrDosyalarCoklu['size'    ][$key1];
    			$tmp5 = $arrDosyalarCoklu['error'   ][$key1];
    			
    			// Geri kalan dosyalarda arayıp sıradaki dosyayı bulalım
    			for($i=$key1; $i < count($arrDosyalarCoklu['name']); $i++) {
    				if( $arrDosyalarCoklu['name'][$i] == $arrSiralama[$key1] ) {
    					// Bulduğumuza göre swap yapalım.
    					$arrDosyalarCoklu['name'    ][$key1] = $arrDosyalarCoklu['name'    ][$i];
    					$arrDosyalarCoklu['type'    ][$key1] = $arrDosyalarCoklu['type'    ][$i];
    					$arrDosyalarCoklu['tmp_name'][$key1] = $arrDosyalarCoklu['tmp_name'][$i];
    					$arrDosyalarCoklu['size'    ][$key1] = $arrDosyalarCoklu['size'    ][$i];
    					$arrDosyalarCoklu['error'   ][$key1] = $arrDosyalarCoklu['error'   ][$i];
    					
    					$arrDosyalarCoklu['name'    ][$i] = $tmp1;
    					$arrDosyalarCoklu['type'    ][$i] = $tmp2;
    					$arrDosyalarCoklu['tmp_name'][$i] = $tmp3;
    					$arrDosyalarCoklu['size'    ][$i] = $tmp4;
    					$arrDosyalarCoklu['error'   ][$i] = $tmp5;
    				}
    			} // for
    		} // foreach
    	} // if($_POST['BirlestirmeSiralama'] <> '') {

    	$Prefix = "COK";
    	DosyalariYukle($arrDosyalarCoklu, 'pdf', $Prefix);

		$arrDesen = $_POST["AlinacakSayfalar"];
    
		$SIRANO  = 0;
		$arrPDFs = array();
    	foreach ($arrDosyalarTekli['name'] as $i => $value) {
    		$SIRANO++;
    		$Prefix = "TEK";
    		$Dosya  = sprintf("{$Prefix}%04d", $i);
    		$Desen  = ($arrDesen[$i] == "") ? "Hepsi" : $arrDesen[$i];
    		$SayfaAdedi = PDFDosyaSayfaSayisi( $Dosya );
    		$arrPDFs[$SIRANO]['ALIAS']       = SayidanHarf($SIRANO); // Bu fonksiyona SIFIR gönderilemez.
    		$arrPDFs[$SIRANO]['DosyaAdi']    = $Dosya;
    		$arrPDFs[$SIRANO]['SayfaAdedi']  = $SayfaAdedi;
    		$arrPDFs[$SIRANO]['Sayfalar']    = SayfalariDoldur($SayfaAdedi);
    		$arrPDFs[$SIRANO]['Desendekiler']= DesendekiSayfalar($SayfaAdedi, $Desen);
    	}
    	foreach ($arrDosyalarCoklu['name'] as $i => $value) {
    		$SIRANO++;
    		$Prefix = "COK";
    		$Desen  = "Hepsi";
    		$Dosya  = sprintf("{$Prefix}%04d", $i);
    		$SayfaAdedi = PDFDosyaSayfaSayisi( $Dosya );
    		$arrPDFs[$SIRANO]['ALIAS']       = SayidanHarf($SIRANO); // Bu fonksiyona SIFIR gönderilemez.
    		$arrPDFs[$SIRANO]['DosyaAdi']    = $Dosya;
    		$arrPDFs[$SIRANO]['SayfaAdedi']  = $SayfaAdedi;
    		$arrPDFs[$SIRANO]['Sayfalar']    = SayfalariDoldur($SayfaAdedi);
    		$arrPDFs[$SIRANO]['Desendekiler']= DesendekiSayfalar($SayfaAdedi, $Desen);
    	}

    	$GIRDI  = "pdftk ";
    	$ALINAN = "cat ";
    	$SONUC  = "output SONUC.PDF";
    	foreach ($arrPDFs as $k => $v) {
    		$GIRDI  .= sprintf("%s=%s ", $arrPDFs[$k]['ALIAS'], $arrPDFs[$k]['DosyaAdi']);

    		$arrSadelestirilmis = SayfalariSadelestir($arrPDFs[$k]['Desendekiler']);
    		foreach ($arrSadelestirilmis as $k1 => $v1) {
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
	} // formBirlestir

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


    	$Prefix      = "Sil";

    	$arrDosyalar = $_FILES["AnaDosyaSil"];

    	// Seçilen dosyalar arasında BOŞ veya GEÇERSİZ dosya varsa sil...
		$arrDosyalar = YuklenecekDosyalariTemizle($arrDosyalar, 'pdf');

    	DosyalariYukle($arrDosyalar, 'pdf', $Prefix);

    	$SIRANO  = 0;
    	$arrPDFs = array();
    	foreach ($arrDosyalar['name'] as $i => $value) {
    		$SIRANO++;
    		$Dosya  = sprintf("{$Prefix}%04d", $i);
    		$Desen = $_POST["AyarSil1"];
    		$SayfaAdedi = PDFDosyaSayfaSayisi( $Dosya );
    		$arrPDFs[$SIRANO]['ALIAS']       = SayidanHarf($SIRANO); // Bu fonksiyona SIFIR gönderilemez.
    		$arrPDFs[$SIRANO]['DosyaAdi']    = $Dosya;
    		$arrPDFs[$SIRANO]['SayfaAdedi']  = $SayfaAdedi;
    		$arrPDFs[$SIRANO]['Sayfalar']    = SayfalariDoldur($SayfaAdedi);
    		$arrPDFs[$SIRANO]['Desendekiler']= DesendekiSayfalar($SayfaAdedi, $Desen);
    	}

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

    	$GIRDI  = " ";
    	$ALINAN = " ";

    	foreach ($arrPDFs as $k => $v) {

			// Girdi için ALIAS belirleyelim...
			$GIRDI  = "pdftk " . sprintf("%s=%s ", $arrPDFs[$k]['ALIAS'], $arrPDFs[$k]['DosyaAdi']);

			foreach ($arrPDFs[$k]['Sayfalar'] as $i => $SayfaNo) {
				$Sil = 0;
	    		if($TekleriSil == 1) { // Tek Sayfaları Sil
					if($SayfaNo % 2 == 1) $Sil = 1;
				}
	    		if($CiftleriSil == 1) { // Çift Sayfaları Sil
					if($SayfaNo % 2 == 0) $Sil = 1;
				}
				if(in_array($SayfaNo, $arrPDFs[$k]['Desendekiler'])) $Sil = 1;

				if($Sil == 1) unset($arrPDFs[$k]['Sayfalar'][$i]);

			}

			$ALINAN = "";
    		foreach ($arrPDFs[$k]['Sayfalar'] as $k1 => $v1) {
    			$ALINAN .= $arrPDFs[$k]['ALIAS'] . $v1 . " ";
    		}
	    
	    	$SONUC  = sprintf("output SONUC-%02d.PDF", $k);

	    	$KOMUT = "$GIRDI cat $ALINAN $SONUC";

		    chdir("upload");
	    	$cevap = shell_exec($KOMUT);
	    	chdir("../");
	    	
	    	echo "KOMUT:\n" . $KOMUT . "\n\n";

	    }
    	// print_r($arrPDFs);



    	echo "***  \n";
    	echo "================== SİL \n";
    	echo "================== SİL \n";
    	echo "================== SİL \n";
    	//die();
	} // formSil



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

    	$Prefix      = "Bol";

    	$arrDosyalar = $_FILES["AnaDosyaBol"];

    	// Seçilen dosyalar arasında BOŞ veya GEÇERSİZ dosya varsa sil...
		$arrDosyalar = YuklenecekDosyalariTemizle($arrDosyalar, 'pdf');

    	DosyalariYukle($arrDosyalar, 'pdf', $Prefix);

    	$SIRANO  = 0;
    	$arrPDFs = array();
    	foreach ($arrDosyalar['name'] as $i => $value) {
    		$SIRANO++;
    		$Dosya  = sprintf("{$Prefix}%04d", $i);
    		$Desen  = "";
    		$SayfaAdedi = PDFDosyaSayfaSayisi( $Dosya );
    		$arrPDFs[$SIRANO]['ALIAS']       = SayidanHarf($SIRANO); // Bu fonksiyona SIFIR gönderilemez.
    		$arrPDFs[$SIRANO]['DosyaAdi']    = $Dosya;
    		$arrPDFs[$SIRANO]['SayfaAdedi']  = $SayfaAdedi;
    		$arrPDFs[$SIRANO]['Sayfalar']    = SayfalariDoldur($SayfaAdedi);
    	}

		foreach ($arrPDFs as $i => $value) {
    		$SIRANO++;
    		$Dosya      = $arrPDFs[$i]['DosyaAdi'];
    		$SayfaAdedi = $arrPDFs[$i]['SayfaAdedi'];

			// Her bir sayfayı ayrı PDF yap
			// Her bir sayfayı ayrı PDF yap
			// Her bir sayfayı ayrı PDF yap
			if( isset($_POST["AyarBol1"]) and $_POST["AyarBol1"] == "on") {

				if($SayfaAdedi < 100000) $KOMUT = "pdftk {$Dosya} burst output Sayfa_%05d.pdf";
				if($SayfaAdedi < 10000 ) $KOMUT = "pdftk {$Dosya} burst output Sayfa_%04d.pdf";
				if($SayfaAdedi < 1000  ) $KOMUT = "pdftk {$Dosya} burst output Sayfa_%03d.pdf";
				if($SayfaAdedi < 100   ) $KOMUT = "pdftk {$Dosya} burst output Sayfa_%02d.pdf";
				if($SayfaAdedi < 10    ) $KOMUT = "pdftk {$Dosya} burst output Sayfa_%01d.pdf";
		    	
			    echo $KOMUT;
			    chdir("upload");
		    	$cevap = shell_exec($KOMUT);
		    	chdir("../");
			}

			// Dosyayı X sayfalık parçalara böl
			// Dosyayı X sayfalık parçalara böl
			// Dosyayı X sayfalık parçalara böl
			$SayfaBlogu = intval($_POST["AyarBol2"]);
			if( isset($_POST["AyarBol2"]) and $SayfaBlogu >= 1) {
				$Bas  = 1;
				$Bit  = 0;
				$Bolum= 0;
				while($Bit < $SayfaAdedi - 1) {
					$Bas = $Bit + 1;
					$Bit = $Bit + $SayfaBlogu;
					if($Bit > $SayfaAdedi) $Bit = $SayfaAdedi;
					$Bolum++;
					if($SayfaAdedi / $SayfaBlogu < 100000) $KOMUT = sprintf("pdftk {$Dosya} cat {$Bas}-{$Bit} output Bolum_%05d.pdf", $Bolum);
					if($SayfaAdedi / $SayfaBlogu < 10000)  $KOMUT = sprintf("pdftk {$Dosya} cat {$Bas}-{$Bit} output Bolum_%04d.pdf", $Bolum);
					if($SayfaAdedi / $SayfaBlogu < 1000)   $KOMUT = sprintf("pdftk {$Dosya} cat {$Bas}-{$Bit} output Bolum_%03d.pdf", $Bolum);
					if($SayfaAdedi / $SayfaBlogu < 100)    $KOMUT = sprintf("pdftk {$Dosya} cat {$Bas}-{$Bit} output Bolum_%02d.pdf", $Bolum);
					if($SayfaAdedi / $SayfaBlogu < 10)     $KOMUT = sprintf("pdftk {$Dosya} cat {$Bas}-{$Bit} output Bolum_%01d.pdf", $Bolum);
				    echo "$KOMUT\n";
				    chdir("upload");
			    	$cevap = shell_exec($KOMUT);
			    	chdir("../");
				}

			}

			// PDF dosyayı şu sayfalardan bölerek ayrı dosyalar yap
			// PDF dosyayı şu sayfalardan bölerek ayrı dosyalar yap
			// PDF dosyayı şu sayfalardan bölerek ayrı dosyalar yap
			if( isset($_POST["AyarBol3"]) and $_POST["AyarBol3"] <> "") {
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
					$KOMUT = sprintf("pdftk {$Dosya} cat {$Bas}-{$Bit} output Sayfalar_{$Bas}-{$Bit}.pdf", $Bolum);
					$Bas = $Bit + 1;
				    echo "$KOMUT\n";
				    chdir("upload");
			    	$cevap = shell_exec($KOMUT);
			    	chdir("../");
				}
			}


			// Özel böl (Her ';' ayrımı ayrı bir PDF olacak)
			// Özel böl (Her ';' ayrımı ayrı bir PDF olacak)
			// Özel böl (Her ';' ayrımı ayrı bir PDF olacak)
			if( isset($_POST["AyarBol4"]) and $_POST["AyarBol4"] <> "") {

				$DESEN = $_POST["AyarBol4"] . ";" ; // Sonucun mutlaka dizi olmasını garantilemek için
				// 0-9, virgül ve tire ve noktalıvirgül karakterleri kalsın. Gerisini temizle...
				$DESEN = preg_replace('/[^0-9\,\-\;]/i', '', $DESEN);
				$arrDesenler = explode(";", $DESEN);
				print_r($arrDesenler);

				$Bolum = 0;
				$arrAlinacaklar = array();
				foreach ($arrDesenler as $key => $value) {
					if($value == "") continue;
					$arrAlinacaklar = DesendekiSayfalar($SayfaAdedi, $arrDesenler[$key]);
					//print_r($arrAlinacaklar);

					$arrSadelestirilmis = SayfalariSadelestir($arrAlinacaklar);
					$SAYFALAR = implode(" ", $arrSadelestirilmis);
					$Bolum++;
					$KOMUT = sprintf("pdftk {$Dosya} cat {$SAYFALAR} output Bolum_{$Bolum}.pdf", $Bolum);
				    echo "$KOMUT\n";
				    chdir("upload");
			    	$cevap = shell_exec($KOMUT);
			    	chdir("../");
				}

			}

		} // foreach ($arrPDFs as $i => $value) {

    	echo "***  \n";
    	echo "================== BÖL \n";
    	echo "================== BÖL \n";
    	echo "================== BÖL \n";
    	//die();
	} // formBol


    /* =======================================================
    ==========================================================
    ========================== RESİM1 ========================
    ==========================================================
    ======================================================= */
	/*
	POST
	    [FormAdi] => formResim1
	    [AyarResimPDFYap1] => on CHECKBOX
	    [AyarResimPDFYap2] => on CHECKBOX
	    [AyarResimPDFYap3] => on CHECKBOX
	FILES
		AnaDosyaResim1
	*/
	if( isset($_POST["FormAdi"]) and $_POST["FormAdi"] == "formResim1" ) {
    	
    	// Upload klasöründeki tüm dosyaları temizle...
    	$KOMUT = "rm -rf upload/*";
    	$cevap = shell_exec($KOMUT);

    	$arrHATA = array();


    	$Prefix      = "Resimden";

    	$arrDosyalar = $_FILES["AnaDosyaResim1"];

    	// Seçilen dosyalar arasında BOŞ veya GEÇERSİZ dosya varsa sil...
		$arrDosyalar = YuklenecekDosyalariTemizle($arrDosyalar, 'pdf');

    	DosyalariYukle($arrDosyalar, 'pdf', $Prefix);

    	$SIRANO  = 0;
    	$arrPDFs = array();
    	foreach ($arrDosyalar['name'] as $i => $value) {
    		$SIRANO++;
    		$Dosya  = sprintf("{$Prefix}%04d", $i);
    		$Desen = $_POST["AyarSil1"];
    		$SayfaAdedi = PDFDosyaSayfaSayisi( $Dosya );
    		$arrPDFs[$SIRANO]['ALIAS']       = SayidanHarf($SIRANO); // Bu fonksiyona SIFIR gönderilemez.
    		$arrPDFs[$SIRANO]['DosyaAdi']    = $Dosya;
    		$arrPDFs[$SIRANO]['SayfaAdedi']  = $SayfaAdedi;
    		$arrPDFs[$SIRANO]['Sayfalar']    = SayfalariDoldur($SayfaAdedi);
    		$arrPDFs[$SIRANO]['Desendekiler']= DesendekiSayfalar($SayfaAdedi, $Desen);
    	}


    	foreach ($arrPDFs as $k => $v) {
			$SayfaAdedi = $arrPDFs[$k]['SayfaAdedi'];
			$Dosya      = $arrPDFs[$k]['DosyaAdi'];

			// PDF içindeki tüm resimleri çıkar
			// PDF içindeki tüm resimleri çıkar
			// PDF içindeki tüm resimleri çıkar
			if( isset($_POST["AyarResimPDFYap1"]) and $_POST["AyarResimPDFYap1"] == "on") {
				$Kalite = $_POST["AyarResimPDFYap3"];
				$KOMUT = "pdfimages -j {$Dosya} Resim; rm *.ppm;";
				if(count($arrPDFs)>1) {
					$KOMUT = "pdfimages -j {$Dosya} Dosya{$k}_Resim; rm *.ppm;";
				}
			    echo $KOMUT;
			    chdir("upload");
		    	$cevap = shell_exec($KOMUT);
		    	chdir("../");
			}

			//  PDF'in her sayfasını JPG dosyası olarak çıkar 
			//  PDF'in her sayfasını JPG dosyası olarak çıkar 
			//  PDF'in her sayfasını JPG dosyası olarak çıkar 
			if( isset($_POST["AyarResimPDFYap2"]) and $_POST["AyarResimPDFYap2"] == "on") {
				$Kalite = intval($_POST["AyarResimPDFYap3"]);
				// pdftoppm komutu imagemagick ve convert'den daha iyi sonuç veriyor
				$KOMUT = "pdftoppm {$Dosya} Sayfa -jpeg -jpegopt quality={$Kalite} -f 7 -l 23"; // 7-23 arası sayfaları çıkar
				$KOMUT = "pdftoppm {$Dosya} Sayfa -jpeg -jpegopt quality={$Kalite} -r 300"; // resulation: 300
				$KOMUT = "pdftoppm {$Dosya} Sayfa -jpeg -jpegopt quality={$Kalite} -density 300";
				$KOMUT = "pdftoppm {$Dosya} Sayfa -jpeg -jpegopt quality={$Kalite}";
				

				$KOMUT = "pdftoppm {$Dosya} Sayfa -jpeg -jpegopt quality={$Kalite}";
				if(count($arrPDFs)>1) {
					$KOMUT = "pdftoppm {$Dosya} Dosya{$k}_Sayfa -jpeg -jpegopt quality={$Kalite}";
				}

			    echo $KOMUT;
			    chdir("upload");
		    	$cevap = shell_exec($KOMUT);
		    	chdir("../");
			}

		} // foreach ($arrPDFs as $k => $v) {

    	echo "***  \n";
    	echo "================== formResim1 \n";
    	echo "================== formResim1 \n";
    	echo "================== formResim1 \n";
    	//die();
	} // formResim1

    /* =======================================================
    ==========================================================
    ========================== RESİM2 ========================
    ==========================================================
    ======================================================= */
	/*
	POST
	    [FormAdi] => formResim2
	    [AyarResim1] => on CHECKBOX
	    [AyarResim2] => on CHECKBOX
	    [AyarResim3] => Text
	FILES
		AnaDosyaResim2
	*/
	if( isset($_POST["FormAdi"]) and $_POST["FormAdi"] == "formResim2" ) {
    	
    	// Upload klasöründeki tüm dosyaları temizle...
    	$KOMUT = "rm -rf upload/*";
    	$cevap = shell_exec($KOMUT);

    	$arrHATA = array();


    	$Prefix      = "Resimden";

    	$arrDosyalar = $_FILES["AnaDosyaResim2"];

    	// Seçilen dosyalar arasında BOŞ veya GEÇERSİZ dosya varsa sil...
		$arrDosyalar = YuklenecekDosyalariTemizle($arrDosyalar, 'img');

    	DosyalariYukle($arrDosyalar, 'img', $Prefix);

    	$SIRANO  = 0;
    	$arrIMGs = array();
    	foreach ($arrDosyalar['name'] as $i => $value) {
    		$SIRANO++;
    		$Dosya  = sprintf("{$Prefix}%04d", $i);
    		$arrIMGs[$SIRANO]['ALIAS']       = SayidanHarf($SIRANO); // Bu fonksiyona SIFIR gönderilemez.
    		$arrIMGs[$SIRANO]['DosyaAdi']    = $Dosya;
    	}

    	$Portrait  = 'A4';
    	$Landscape = 'A4^T';
		$KagitYonu = ($_POST["AyarResim3"] == 'P') ? $Portrait : $Landscape;

		// Resimlerin her birini PDF dosya yap
		// Resimlerin her birini PDF dosya yap
		// Resimlerin her birini PDF dosya yap
		if( isset($_POST["AyarResim1"]) and $_POST["AyarResim1"] == "on") {

			// ALTERNATİF 1
			// ALTERNATİF 1
			// ALTERNATİF 1
			$KOMUT = "convert * PDF_%03d.pdf";

			// ALTERNATİF 2
			// ALTERNATİF 2
			// ALTERNATİF 2
			
			// Önce, istenilen kağıt yönünde (Landscape veya Portrait) PDF üret,
			$KOMUT = "img2pdf --output SONUC.pdf --pagesize {$KagitYonu} * ";
		    echo $KOMUT;
		    chdir("upload");
	    	$cevap = shell_exec($KOMUT);
	    	chdir("../");
			
			// Sonra, Bu PDF'i sayfalara böl
			$KOMUT = "pdftk SONUC.pdf burst output Sayfa_%03d.pdf; rm SONUC.pdf";
		    echo $KOMUT;
		    chdir("upload");
	    	$cevap = shell_exec($KOMUT);
	    	chdir("../");
		}

		// Resimlerden PDF dosya yap 
		// Resimlerden PDF dosya yap 
		// Resimlerden PDF dosya yap 
		if( isset($_POST["AyarResim2"]) and $_POST["AyarResim2"] == "on") {
			$KOMUT = "img2pdf --output SONUC.pdf --pagesize {$KagitYonu} {$Prefix}* ";
		    echo $KOMUT;
		    chdir("upload");
	    	$cevap = shell_exec($KOMUT);
	    	chdir("../");
		}


    	echo "***  \n";
    	echo "================== formResim2 \n";
    	echo "================== formResim2 \n";
    	echo "================== formResim2 \n";
    	//die();
	} // formResim2


    /* =======================================================
    ==========================================================
    ======================== HARMANLA ========================
    ==========================================================
    ======================================================= */
	/*
	POST
	    [FormAdi] => formHarmanla
		[Harman_Adet] ARRAY
		[Harman_Baslama]   ARRAY
	FILES
		HarmanPDF
	*/
	if( isset($_POST["FormAdi"]) and $_POST["FormAdi"] == "formHarmanla" ) {
    	
    	// Upload klasöründeki tüm dosyaları temizle...
    	$KOMUT = "rm -rf upload/*";
    	$cevap = shell_exec($KOMUT);

    	$arrHATA = array();


    	$Prefix      = "Harman";

    	$arrDosyalar = $_FILES["HarmanPDF"];

    	// Seçilen dosyalar arasında BOŞ veya GEÇERSİZ dosya varsa sil...
		$arrDosyalar = YuklenecekDosyalariTemizle($arrDosyalar, 'pdf');

    	DosyalariYukle($arrDosyalar, 'pdf', $Prefix);

    	$arrHarman_Adet    = $_POST["Harman_Adet"];
    	$arrHarman_Baslama = $_POST["Harman_Baslama"];

    	$SIRANO  = 0;
    	$arrPDFs = array();
    	foreach ($arrDosyalar['name'] as $i => $value) {
    		$SIRANO++;
    		$Dosya  = sprintf("{$Prefix}%04d", $i);
    		$SayfaAdedi = PDFDosyaSayfaSayisi( $Dosya );
    		$arrPDFs[$SIRANO]['ALIAS']       = SayidanHarf($SIRANO); // Bu fonksiyona SIFIR gönderilemez.
    		$arrPDFs[$SIRANO]['DosyaAdi']    = $Dosya;
    		$arrPDFs[$SIRANO]['SayfaAdedi']  = $SayfaAdedi;

    		$Baslama      = $arrHarman_Baslama[$i];
    		$AlinacakAdet = $arrHarman_Adet[$i];

    		// İlk kontroller
    		if( $AlinacakAdet <= 0 or $Baslama <= 0) { // reddet
    			$Baslama = $SayfaAdedi + 1; // Böylece sanki dosya işlenmiş gibi davranacak
    		}

    		if( $Baslama > $SayfaAdedi) { // reddet
    			$Baslama = $SayfaAdedi + 1; // Böylece sanki dosya işlenmiş gibi davranacak
    		}

    		if( $AlinacakAdet > $SayfaAdedi) { // reddet
    			$Baslama = $SayfaAdedi + 1; // Böylece sanki dosya işlenmiş gibi davranacak
    		}

    		if( ($AlinacakAdet + $Baslama) > $SayfaAdedi) { // reddet
    			$Baslama = $SayfaAdedi + 1; // Böylece sanki dosya işlenmiş gibi davranacak
    		}

    		$arrPDFs[$SIRANO]['KONUM']      = $Baslama;
    		$arrPDFs[$SIRANO]['ADET']       = $AlinacakAdet;
    	}

// print_r($arrPDFs);

    	// ADIM 1: ALIAS'ların hazırlanması
    	$GIRDI  = "pdftk ";
    	foreach ($arrPDFs as $k => $v) {
    		$GIRDI  .= sprintf("%s=%s ", $arrPDFs[$k]['ALIAS'], $arrPDFs[$k]['DosyaAdi']);
    	}

    	// ADIM 2: Harmanlamanın Yapılması
    	$HARMAN = "";

		$Sayac = 0;
		$Hata = 0;
		while($Hata == 0) {

			$temp = "";

			$Sayac++; if($Sayac > 1000) break; // Emniyet alalım...
	    	foreach ($arrPDFs as $k => $v) {
	    		$SayfaAdedi = $arrPDFs[$k]['SayfaAdedi'];
	    		$Alias   = $arrPDFs[$k]['ALIAS'];
	    		$Baslama = $arrPDFs[$k]['KONUM'];
	    		$Adet    = $arrPDFs[$k]['ADET'];
	    		$Bitis   = $Baslama + $Adet - 1;
	    		//echo "if($Baslama > $SayfaAdedi or $Bitis > $SayfaAdedi) {\n";
	    		if($Baslama > $SayfaAdedi or $Bitis > $SayfaAdedi) {
	    			$Hata = 1;
	    		}
	    		
	    	//	if($Baslama == $Bitis) {
	    	//		$temp .= "{$Alias}{$Baslama} ";
	    	//	} else {
	    			$temp .= "{$Alias}{$Baslama}-{$Bitis} ";
	    	//	}

	    		$arrPDFs[$k]['KONUM'] = $Bitis + 1;
	    	}

	    	if( $Hata == 0) {
	    		$HARMAN .= $temp;
	    	}
	    }

	    if($HARMAN <> "") {
	    	$KOMUT = "$GIRDI cat $HARMAN output SONUC.PDF";
		    chdir("upload");
	    	$cevap = shell_exec($KOMUT);
	    	chdir("../");

	    	
	    	echo $KOMUT . "\n\n";

	    }

// echo "ALIAS: $GIRDI \n\n HARMAN: $HARMAN";


    	//die();
    } // formHarmanla





    /* =======================================================
    ==========================================================
    ======================= ARAYA EKLE =======================
    ==========================================================
    ======================================================= */

	/*
	POST
	    [FormAdi] => formArayaEkle
	    [YeniPDF_Baslama]  ARRAY
	    [YeniPDF_Sayfalar] ARRAY
	FILES
		ArayaEkleAnaDosya
		ArayaEklePDF
	*/

	if( isset($_POST["FormAdi"]) and $_POST["FormAdi"] == "formArayaEkle" ) {
    	
    	// Upload klasöründeki tüm dosyaları temizle...
    	$KOMUT = "rm -rf upload/*";
    	$cevap = shell_exec($KOMUT);

    	$arrHATA = array();

    	$arrBaslamalar = $_POST["YeniPDF_Baslama"];
    	$arrSayfaDesen   = $_POST["YeniPDF_Sayfalar"];

    	$arrAnaDosya     = $_FILES["ArayaEkleANA"];
    	$arrEklenecekler = $_FILES["ArayaEklePDF"];

    	// Seçilen dosyalar arasında BOŞ veya GEÇERSİZ dosya varsa sil...
    	$arrAnaDosya     = YuklenecekDosyalariTemizle($arrAnaDosya, 'pdf');
    	$arrEklenecekler = YuklenecekDosyalariTemizle($arrEklenecekler, 'pdf');

    	// Seçilmiş dosyaları UPLOAD klasörüne dosya adı 0001, 0002 olacak biçimde yükle.
    	$Prefix = "ANA";
    	DosyalariYukle($arrAnaDosya,     'pdf', $Prefix);

    	$Prefix = "Araya";
    	DosyalariYukle($arrEklenecekler, 'pdf', $Prefix);

		$arrDesen = $_POST["AlinacakSayfalar"];
    
    	$ALIAS   = "";
		$SIRANO  = 0;
		$arrPDFs = array();
    	// Her ne kadar döngü ile yapıldı ise de, aslında burada sadece 1 adet dosya var.
    	foreach ($arrAnaDosya['name'] as $i => $value) {
    		$SIRANO++;
    		$Prefix = "ANA";
    		$Dosya  = sprintf("{$Prefix}%04d", $i);
    		$Desen  = ($arrDesen[$i] == "") ? "Hepsi" : $arrDesen[$i];
    		$SayfaAdedi = PDFDosyaSayfaSayisi( $Dosya );
    		$arrPDFs[$SIRANO]['ALIAS']       = SayidanHarf($SIRANO); // Bu fonksiyona SIFIR gönderilemez.
    		$arrPDFs[$SIRANO]['DosyaAdi']    = $Dosya;
    		$arrPDFs[$SIRANO]['SayfaAdedi']  = $SayfaAdedi;
    		$AnaSayfaSayisi = $SayfaAdedi;
    		$Alias_ANA      = $arrPDFs[$SIRANO]['ALIAS'];
    		$ALIAS .= sprintf("%s=%s ", $arrPDFs[$SIRANO]['ALIAS'], $arrPDFs[$SIRANO]['DosyaAdi']);
    		//$arrPDFs[$SIRANO]['Sayfalar']    = SayfalariDoldur($SayfaAdedi);
    	}

//die($ALIAS);
		//$SIRANO   = 0;
		$arrPDF2s = array();
    	foreach ($arrEklenecekler['name'] as $i => $value) {
    		$SIRANO++;
    		$Prefix = "Araya";
    		$Desen  = ($arrSayfaDesen[$i] == "") ? "Hepsi" : $arrSayfaDesen[$i];
    		$Dosya  = sprintf("{$Prefix}%04d", $i);
    		$SayfaAdedi = PDFDosyaSayfaSayisi( $Dosya );
    		$arrPDF2s[$SIRANO]['ALIAS']       = SayidanHarf($SIRANO); // Bu fonksiyona SIFIR gönderilemez.
    		$arrPDF2s[$SIRANO]['DosyaAdi']    = $Dosya;
    		$arrPDF2s[$SIRANO]['SayfaAdedi']  = $SayfaAdedi;
    		//$arrPDF2s[$SIRANO]['Sayfalar']    = SayfalariDoldur($SayfaAdedi);
    		$arrPDF2s[$SIRANO]['Desendekiler']= DesendekiSayfalar($SayfaAdedi, $Desen);
    		$arrPDF2s[$SIRANO]['Baslamasi']   = intval($arrBaslamalar[$i]);
    		$ALIAS .= sprintf("%s=%s ", $arrPDF2s[$SIRANO]['ALIAS'], $arrPDF2s[$SIRANO]['DosyaAdi']);
    	}


		$BasAna = 1;
		$BitAna = 1;
		$SONUC .= "\n\n";

		for($i=1; $i<=count($arrPDF2s); $i++) {

			// Ana dosyayı yürütelim...
			if($i == 1) {
				if($arrPDF2s[$i]['Baslamasi'] > 0) {
					$BasAna = 1;
					$BitAna = $arrPDF2s[$i]['Baslamasi'];
					$SONUC .= "{$Alias_ANA}{$BasAna}-{$BitAna} \n";
					$BasAna = $BitAna + 1;
				}
			} else {
				$BitAna = $arrPDF2s[$i]['Baslamasi'];
				$SONUC .= "{$Alias_ANA}{$BasAna}-{$BitAna} \n";
				$BasAna = $BitAna + 1;
			}


			// Eklenecek dosyayı yürütelim
			$arrSadelestirilmis = SayfalariSadelestir($arrPDF2s[$i]['Desendekiler']);
			foreach ($arrSadelestirilmis as $k1 => $v1) {
				$SONUC .= $arrPDF2s[$i]['ALIAS'] . $v1 . " \n";
			}

		}
echo "SONUC: $SONUC \n";
die();
		$BitAna = $AnaSayfaSayisi;
		$SONUC .= "{$Alias_ANA}{$BasAna}-{$BitAna} ";


    	$KOMUT = "pdftk $ALIAS cat $SONUC output SONUC.PDF";
die($KOMUT);


	    chdir("upload");
    	$cevap = shell_exec($KOMUT);
    	chdir("../");

    	
    	echo $KOMUT . "\n\n";

    	// print_r($arrPDFs);



    	echo "***  \n";
    	echo "================== formArayaEkle \n";
    	echo "================== formArayaEkle \n";
    	echo "================== formArayaEkle \n";
    	//die();
	} // formArayaEkle

die("\n\nMutlu son...\n\n");

    echo "\n\n\n";
    echo "============= GELEN VERİLER \n";
    echo "============= GELEN VERİLER \n";
    echo "============= GELEN VERİLER \n";
    echo "<h1>POST</h1>";     print_r($_POST);
    echo "<h1>FILES</h1>";    print_r($_FILES);
