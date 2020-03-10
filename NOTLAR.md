##  TODO
- Parola korumalı dosyalar için parola alma
- Dosyaya parola koyma
- Yazdırma engeli koyma
- Dosyadan parola kaldırma
- PDF Dosya tamir etme  pdftk broken.pdf output fixed.pdf
- Uncompress PDF page streams for editing the PDF in a text editor (e.g., vim, emacs) pdftk doc.pdf output doc.unc.pdf uncompress
- pdfcrop --margins "-15 -50 0 -140" extracted_page.pdf
+ PDF'den Resim'e ÇOKLU DOSYA SEÇİMİ olabilir
+ PDF'den sayfa sil'de ÇOKLU DOSYA SEÇİMİ olabilir
- SAYFALARI DÜZENLE ekranında silme için de icon eklenebilir

* Merge PDF Documents
* Collate PDF Page Scans
* Split PDF Pages into a New Document
* Rotate PDF Documents or Pages
* Decrypt Input as Necessary (Password Required)
* Encrypt Output as Desired
* Fill PDF Forms with X/FDF Data and/or Flatten Forms
* Generate FDF Data Stencils from PDF Forms
* Apply a Background Watermark or a Foreground Stamp
* Report PDF Metrics, Bookmarks and Metadata
* Add/Update PDF Bookmarks or Metadata
* Attach Files to PDF Pages or the PDF Document
* Unpack PDF Attachments
* Burst a PDF Document into Single Pages
* Uncompress and Re-Compress Page Streams
* Repair Corrupted PDF (Where Possible)

## Kullanılan Kütüphaneler
- [ubuntu 18.04](https://ubuntu.com/download/desktop)
- [pdftk](https://www.pdflabs.com/docs/pdftk-man-page/)
- [pdftoppm](https://linux.die.net/man/1/pdftoppm)
- [img2pdf](https://gitlab.mister-muffin.de/josch/img2pdf)
- [pdfimages](https://www.mankier.com/1/pdfimages)
- [convert](https://imagemagick.org/script/convert.php)

## Faydalı Kaynaklar
- https://net2.com/how-to-install-and-use-pdftk-on-linux-to-merge-or-split-pdf-files/
- https://askubuntu.com/questions/1028522/how-can-i-install-pdftk-in-ubuntu-18-04-and-later

## pdftk Kurulumu

Ubuntu 18.04 üzerine pdftk kurulumu (64 Bit) [Kaynak: askubuntu.com](https://askubuntu.com/questions/1028522/how-can-i-install-pdftk-in-ubuntu-18-04-and-later)

### `pdftk_installer.sh` Dosyasının içeriği
```BASH
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
```

Yukarıdaki kod, `/tmp` dizinine kurulum dosyalarını indirir ve `apt install` komutu ile kurar. Sonrasında `/tmp` dizinine indirdiği dosyaları siler.

Bu script'i çalıştırabilmek için:
```BASH
chmod 755 pdftk_installer.sh
./pdftk_installer.sh
```


## BİRLEŞTİRME (Dosyaları birbirinin ardına ekleyerek)
```
pdftk 

	A=PDFs/Renk1.pdf 
	B=PDFs/Renk2.pdf 

cat 

	A
	B 

output 

	SONUC.pdf
```

## BİRLEŞTİRME (Bazı sayfaları alarak)
```
pdftk 

	A=PDFs/Renk1.pdf 
	B=PDFs/Renk2.pdf 

cat 

	A1 
	B2 
	A3 
	B4 

output 

	SONUC.pdf
```

## HER SAYFAYI AYRI AYRI PDF YAPMA
```
pdftk
	Renk1.pdf
burst
output
	Renk_%04d.pdf
```

## SAYFA SİLME
```
pdftk 
	
	A=PDFs/Renk1.pdf 

cat 

	A1
	A5-10
	A20-end

output 

	SONUC.pdf
```

## PDF'in sayfalarını .JPG yapma
- `convert` takes the PDF, renders it at some resolution, and uses the resulting bitmap as the source image.
- `pdfimages` looks through the PDF for embedded bitmap images and exports each one to a file. It simply ignores any text or vector drawing commands in the PDF.

```
pdfimages -j kitap.pdf Sayfa
pdfimages -f 1 -l 1 kitap.pdf resimler/Sayfa

convert -density 300 file.pdf Sayfa_%04d.jpg
convert -density 150 input.pdf -quality 90 output.png
convert -density 150 input.pdf[66] -quality 90 output.png // Sadece 66. Sayfayı resim yap


pdftoppm input.pdf outputname -png
pdftoppm input.pdf outputname -png -f {66} -singlefile   // Sadece 66. Sayfayı resim yap


pdftoppm input.pdf Sayfa -jpeg -jpegopt quality=30 -r 50  // 50 dpi ve %30 Kalitede resimler üretir (Hızlıdır)
```

## JPG dosyaları PDF yapma
```
convert image1.jpg image2.png image3.bmp output.pdf

convert *.jpg MYPDF%03d.pdf

convert -compress jpeg * outputFile.pdf

^T paper size from portrait into landscape.

// Kağıdı yatay kullan
img2pdf --output out1.pdf --pagesize A4^T 0*

// Kağıdı dikey kullan
img2pdf --output out2.pdf --pagesize A4 0*


```


