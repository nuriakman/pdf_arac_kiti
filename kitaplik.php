<?php
    function TempDosyaSil($Dosya) {
        $Dosya = "./upload/" . $Dosya . ".pdf";
        if(file_exists($Dosya)) unlink($Dosya);
    }

    function SayfalariAyir($Dosya, $Bas, $Bit, $Sonuc) {
        $Dosya = "./upload/" . $Dosya . ".pdf";
        $Sonuc = "./upload/" . $Sonuc . ".pdf";

        $Aralik = trim("$Bas") . "-" . trim("$Bit");

        $KOMUT = "pdftk $Dosya cat $Aralik output $Sonuc compress";
        $cevap = shell_exec($KOMUT); // echo "<p><b>KOMUT:</b>$KOMUT</p>";
        // echo "<p><b>$Sonuc</b> Sayfası üretildi.</p>";
    }

    function SiradakiSayfaSagdaOlsun($SayfaAdedi) {
        if(SiradakiSayfaSagdaMi($SayfaAdedi)) {
            return BosSayfaEkle();
        } else {
            return $SayfaAdedi;
        }
    }

    function SiradakiSayfaSagdaMi($SayfaAdedi) {
        if($SayfaAdedi == 0) $SayfaAdedi = 1;
        return ($SayfaAdedi % 2 == 1) ? true : false; // Tek sayfa ise TRUE döner
    }
   
    function PDFDosyaSayfaSayisi($Dosya) {
        $Dosya = "./upload/" . $Dosya . ".pdf";
        // PDF'in sayfa sayısını bulalım
        $KOMUT = "pdfinfo -box -f 0 -l 1500 $Dosya | grep 'Pages' | cut -d\: -f2";
        $cevap = shell_exec($KOMUT);  // echo "<p><b>KOMUT:</b>$KOMUT</p>";
        $SayfaAdedi = trim($cevap) * 1;
        if($SayfaAdedi<=0) return 0;
        return $SayfaAdedi;
    }

    function BosSayfaEkle($Dosya = "0bossayfa", $SONUC = "SONUC") {
        return SayfaEkle($Dosya, $SONUC);
    }

    function SayfaEkle($Dosya, $SONUC = "SONUC") {
        $Dosya1 = "./upload/" . $Dosya . ".pdf";
        $SONUC1 = "./upload/" . $SONUC . ".pdf";
        $TEMP   = "./upload/temp.pdf";
        if($Dosya == "") { // Birleştirme yeni başlıyor
            // unlink($SONUC1); // Eski dosyayı silelim.
            $KOMUT = "pdftk 0bossayfa.pdf 0bossayfa.pdf cat output $SONUC1";
            $cevap = shell_exec($KOMUT);  // echo "<p><b>KOMUT:</b>$KOMUT</p>";
            return 2; // 2 adet boş sayfa ekledim, sayfa sayısı 2 oldu yani.
        }
        $KOMUT = "pdftk $Dosya1 cat output $TEMP ";
        if(file_exists($SONUC1)) $KOMUT = "pdftk $SONUC1 $Dosya1 cat output $TEMP ";
        $cevap = shell_exec($KOMUT);  // echo "<p><b>KOMUT:</b>$KOMUT</p>";
        $KOMUT = "mv $TEMP $SONUC1 ";
        $cevap = shell_exec($KOMUT);  // echo "<p><b>KOMUT:</b>$KOMUT</p>";
        return PDFDosyaSayfaSayisi($SONUC);
    }

    function YataySayfalariCevir($Dosya) {
        $Dosya1 = "./upload/" . $Dosya . ".pdf";
        $TEMP   = "./upload/TEMP.pdf";
        $SayfaAdedi = PDFDosyaSayfaSayisi($Dosya);


        // 270 Derece yatay sayfaları bulalım
        $KOMUT = "pdfinfo -box -f 0 -l 5000 $Dosya1 | grep 'rot:  270' ";  // 5000: Sayfa Sayısı
        $cevap1 = shell_exec($KOMUT);
        $cevap1 = str_replace(" rot:  270", "", $cevap1);
        $cevap1 = str_replace("Page", "", $cevap1);
        $cevap1 = str_replace(" ", "", $cevap1);

        // 270 Derece yatay sayfaları bulalım
        $KOMUT = "pdfinfo -box -f 0 -l 5000 $Dosya1 | grep 'rot:  90' ";  // 5000: Sayfa Sayısı
        $cevap2 = shell_exec($KOMUT);
        $cevap2 = str_replace(" rot:  270", "", $cevap2);
        $cevap2 = str_replace("Page", "", $cevap2);
        $cevap2 = str_replace(" ", "", $cevap2);

        // 270 Derece yatay sayfaları bulalım
        $KOMUT = "pdfinfo -box -f 0 -l 5000 $Dosya1 | grep 'size: 842 x 595' ";  // 5000: Sayfa Sayısı
        $cevap3 = shell_exec($KOMUT);
        $cevap3 = str_replace(" size: 842 x 595 pts (A4)", "", $cevap3);
        $cevap3 = str_replace("Page", "", $cevap3);
        $cevap3 = str_replace(" ", "", $cevap3);

        $arrYataySayfalar1 = explode("\n", $cevap1);
        $arrYataySayfalar2 = explode("\n", $cevap2);
        $arrYataySayfalar3 = explode("\n", $cevap3);
        
//        echo "---- arrYataySayfalar: ---- "; print_r($arrYataySayfalar);

        foreach ($arrYataySayfalar1 as $key => $value) {
            if(!(intval($value) > 0)) unset($arrYataySayfalar1[$key]);
        }

        foreach ($arrYataySayfalar2 as $key => $value) {
            if(!(intval($value) > 0)) unset($arrYataySayfalar2[$key]);
        }

        foreach ($arrYataySayfalar3 as $key => $value) {
            if(!(intval($value) > 0)) unset($arrYataySayfalar3[$key]);
        }

        // Dosya üzerinde yapılacak toplu değişiklik için sayfa ayarlarını yapalım
        $arrSayfalar = array();
        for($i=1; $i<=$SayfaAdedi;$i++) {
            $Yon = trim($i);
            if( in_array($i, $arrYataySayfalar1) ) $Yon = trim($i) . "west";
            if( in_array($i, $arrYataySayfalar2) ) $Yon = trim($i) . "north";
            if( in_array($i, $arrYataySayfalar3) ) $Yon = trim($i) . "west";
            $arrSayfalar[] = $Yon;
        }

        $Sayfalar = implode(" ", $arrSayfalar);
        // echo "<pre>";  echo print_r($Sayfalar);

        $KOMUT = "pdftk $Dosya1 cat $Sayfalar output $TEMP";
        // echo "<p>$KOMUT</p>";
        $cevap = shell_exec($KOMUT);

        $KOMUT = "mv $TEMP $Dosya1";
        // echo "<p>$KOMUT</p>";
        $cevap = shell_exec($KOMUT);
    }

/*
    die("<br>$cevap<br>bitti");

?>

<style>
    body {
        background-color: #eeeeee;
    }
    .Resim {
        float:left;
        width: 200px;
        border: 1px solid lightgrey;
        padding: 2px;
        margin: 20px;
    }
</style>

<?php

    $INPUT=getcwd() . "/Erzurum.pdf";

    $SONUC=getcwd() . "/1.pdf";


    $KOMUT = "pdftk $INPUT cat 1 output $SONUC compress";

ob_start();
    $cevap = shell_exec($KOMUT);
    //$cevap = shell_exec("rm 000.pdf");
    //$cevap = shell_exec("ls -al");
    if( !file_exists("000.pdf") ) shell_exec('pdftk \
        kapak.pdf \
        bossayfa.pdf \
        nufus.pdf \
        bossayfa.pdf \
        ozgecmisler.pdf \
        bossayfa.pdf \
        ozgecmisler.pdf \
        bossayfa.pdf \
        ozgecmisler.pdf \
        bossayfa.pdf \
        protokol.pdf \
        bossayfa.pdf \
        secim_il.pdf \
        bossayfa.pdf \
        faaliyet.pdf \
        bossayfa.pdf \
        cat output 000.pdf');
    $cevap = shell_exec('convert -density 50 000.pdf -quality 50 sayfa-%04d.jpg');
ob_end_clean();

    if($cevap <> "") echo "<h1>Cevap:</h1>$cevap";

    if( file_exists($SONUC) ) {
        // echo "<h2>Çıktı üretildi</h2>";
    }

    if( file_exists("000.pdf") ) {
        // echo "<h2>Sonuç:</h2>";

        foreach (glob("temp/*.jpg") as $dosya) {
            echo "<img src='$dosya' class='Resim'>";
        }       
    }


echo "<p style='clear:both;'>Bitti...</p>";


/*

KAYNAK: https://www.pdflabs.com/docs/pdftk-man-page/
KAYNAK: https://www.pdflabs.com/docs/pdftk-man-page/
KAYNAK: https://www.pdflabs.com/docs/pdftk-man-page/

## PDF'leri Birleştirme
pdftk kapak.pdf bossayfa.pdf ozgecmisler.pdf  bossayfa.pdf cat output SONUC.pdf

## PDF'in 15,16 ve 20. sayfarını al
pdftk Erzurum.pdf cat 15 16 20 output SONUC.pdf compress

## PDF'in 15-20 arası sayfarını al
pdftk Erzurum.pdf cat 15-20 output SONUC.pdf compress

## PDF'i sayfalara bölmek: Numaralama 1'den Başlıyor
pdftk Erzurum.pdf cat 1 output 1.pdf  compress 

## Sayfaları Resim olarak çevirmek: (Sadece 19.Sayfa için)
convert -density 50 Erzurum.pdf[17] -quality 50 sayfa18.jpg;

## Tüm Sayfaları Resim olarak çevirmek:
convert -density 50 Erzurum.pdf -quality 50 sayfa.jpg


## Tüm Sayfaları Resim olarak çevirmek: sayfa-0000.jpg formatında
convert -density 50 Erzurum.pdf -quality 50 sayfa-%04d.jpg


## Döngü İle Sayfaları Resim olarak çevirmek:
date;for i in {0..19}; do convert -density 50 Erzurum.pdf[$i] -quality 50 $i.jpg; done;date;


https://www.pdflabs.com/docs/pdftk-man-page/



Hizmet İyileştirme ve Kurumsal Gelişim Dairesi Başkanlığı

Ferhat Bey: Programcı 0634 - 886 62 29

https://net2.com/how-to-install-and-use-pdftk-on-linux-to-merge-or-split-pdf-files/



install pdftk install pdftk install pdftk 
install pdftk install pdftk install pdftk 
install pdftk install pdftk install pdftk 
install pdftk install pdftk install pdftk 
install pdftk install pdftk install pdftk 

ADRES: https://askubuntu.com/questions/1028522/how-can-i-install-pdftk-in-ubuntu-18-04-and-later

Installing pdftk on Ubuntu 18.04 amd64

I've written a small bash script which automatise the installation on Ubuntu 18.04. Note that I've downloaded only amd64 packages!



#!/bin/bash
#
# author: abu
# date:   July 3 2019 (ver. 1.1)
# description: bash script to install pdftk on Ubuntu 18.04 for amd64 machines
##############################################################################
#
# change to /tmp directory
cd /tmp
# download packages
wget http://launchpadlibrarian.net/340410966/libgcj17_6.4.0-8ubuntu1_amd64.deb \
 http://launchpadlibrarian.net/337429932/libgcj-common_6.4-3ubuntu1_all.deb \
 https://launchpad.net/ubuntu/+source/pdftk/2.02-4build1/+build/10581759/+files/pdftk_2.02-4build1_amd64.deb \
 https://launchpad.net/ubuntu/+source/pdftk/2.02-4build1/+build/10581759/+files/pdftk-dbg_2.02-4build1_amd64.deb


echo -e "Packages for pdftk downloaded\n\n"
# install packages 
echo -e "\n\n Installing pdftk: \n\n"
sudo apt-get install ./libgcj17_6.4.0-8ubuntu1_amd64.deb \
    ./libgcj-common_6.4-3ubuntu1_all.deb \
    ./pdftk_2.02-4build1_amd64.deb \
    ./pdftk-dbg_2.02-4build1_amd64.deb
echo -e "\n\n pdftk installed\n"
echo -e "   try it in shell with: > pdftk \n"
# delete deb files in /tmp directory
rm ./libgcj17_6.4.0-8ubuntu1_amd64.deb
rm ./libgcj-common_6.4-3ubuntu1_all.deb
rm ./pdftk_2.02-4build1_amd64.deb
rm ./pdftk-dbg_2.02-4build1_amd64.deb

*/