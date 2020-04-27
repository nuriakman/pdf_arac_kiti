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
- OCR Eklenebilir
  - https://help.ubuntu.com/community/OCR
  - pdftotext ile PDF'den TEXT üretilebilir  (pdftotext için: sudo apt-get install poppler-utils)
  - abiword --to=txt SOURCE.pdf ile PDF'den TXT üretilebilir
  - abiword --to=doc SOURCE.pdf ile PDF'den DOC üretilebilir
  - https://okular.kde.org/
  - apt install ocrmypdf
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


### Eklenebilecek Özellikler:
- Her biri X yapraktan oluşan kitapçık (booklet) yap
- Sayfa No Ekleme: Baş.Sayfa: X, Bit.Sayfa: Y,  Sayfa numarası şundan başlasın: Z  `pspdftool 'number(x=-1pt,y=-1pt,start=1,size=10)' input.pdf output.pdf` Kaynak: https://stackoverflow.com/a/9034911/134739

### Başarılı Sonuçlar
resimli.pdf adlı PDF dosya içindeki TÜM RESİMLERİ 5-100 arası dosyalardaki resimleri, resim hangi sayfada var onu da dosya adına ekleyerek .PDG formatında çıkartır `pdfimages -f 5 -l 100 -p -png resimli.pdf SONUC`

### Faydalı Programlar

- https://pdfkit.org/
- [pdftk](https://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/)
- https://github.com/mstamy2/PyPDF2 A utility to read and write PDFs with Python
- https://github.com/pmaupin/pdfrw  pdfrw is a pure Python library that reads and writes PDFs


# ARAŞTIRMALAR


### pdftk Kullanım Örnekleri
- https://www.pdflabs.com/docs/pdftk-man-page/
- pdftk A=rapor.pdf B=bos.pdf cat B1 A3-7 B1 A9-10 B1 A9 output SONUC.pdf
- pdftk A=rapor.pdf B=bos.pdf cat A1 A1left A1right  A3-7 B1 A9-10 B1 A9 output SONUC.pdf


### jpg Yapma Kullanım Örnekleri
- https://stackoverflow.com/questions/6605006/convert-pdf-to-image-with-high-resolution#6605085
- convert -density 600 test.pdf -background white -flatten -resize 25% test.png
- convert -density 300 -trim test.pdf -quality 100 test.jpg
- convert demo.pdf[0] -scale x800 -quality 75  -flatten demo75.jpg
- convert -geometry 1600x1600 -density 200x200 -quality 100 test.pdf test_image.jpg
- convert -thumbnail x300 demo.pdf[2] -flatten demo.jpg
- -flatten Parametresi, transperant zemine sahip sayfaların düzgün çalışmasını sağlar
- Resimlerden PDF üretme `convert "*.{png,jpeg}" -quality 100 outfile.pdf`
- Resimlerden PDF üretme ÖNCE: `ls *.tif | xargs -I% convert % %.pdf` SONRA `pdftk *.pdf cat output merged.pdf && rm *.tif.pdf`
- PDF'den Resim Üretme: `convert -density 600 in.pdf out-%02d.jpg`

```BASH
# normally I extract the embedded image with 'pdfimages' at the native resolution, 
# then use ImageMagick's convert to the needed format:

pdfimages -list fileName.pdf
pdfimages fileName.pdf fileName   # save in .ppm format
convert fileName-000.ppm fileName-000.png

#this generate the best and smallest result file.

#Note: For lossy JPG embedded images, you had to use -j:

pdfimages -j fileName.pdf fileName   # save in .jpg format

```

veya

```BASH
convert           \
   -verbose       \
   -density 150   \
   -trim          \
    test.pdf      \
   -quality 100   \
   -flatten       \
   -sharpen 0x1.0 \
    24-18.jpg
```
Kaynak: https://stackoverflow.com/a/6605085/134739


The following extracts all images from a PDF file, saving them in JPEG format.
```
pdfimages -list in.pdf
pdfimages -j    in.pdf /tmp/out
pdfimages -all  in.pdf /tmp/out
```

If what you need is a cropped image in pdf/eps format, then extract a page with the image using pdfmod
```
pdfcrop --margins "-15 -50 0 -140" extracted_page.pdf
```

mkdir images && pdftoppm -jpeg -jpegopt quality=100 -r 300 mypdf.pdf images/pg


- Pdfimages reads the PDF file PDF-file, scans one or more pages, and writes one PPM, PBM, or JPEG file for each image.
- pdfimages -all input.pdf images/prefix


### Booklet Yapma:
- http://www.michaelm.info/blog/?p=1375
- http://pdfbooklet.sourceforge.net/


### HowTo Add Page Numbers to a PDF File:
- http://forums.debian.net/viewtopic.php?t=30598
- https://stackoverflow.com/questions/30378713/modify-existing-pdf-to-add-page-n-of-nnn-footer

The next command uses `pdftk` with `multistamp` to overlay the page numbering file to an original:
```
pdftk original.pdf              \
  multistamp 100pagenumbers.pdf \
  output pages-numbered.pdf
```

### Print two A5 pages on one A4 page with correct sizes:
### How can I print a PDF document on multiple pages?:
- https://askubuntu.com/questions/1143795/print-two-a5-pages-on-one-a4-page-with-correct-sizes
- https://askubuntu.com/questions/186867/how-can-i-print-a-pdf-document-on-multiple-pages
- https://pypi.org/project/pdfnup/
- https://pypi.org/project/pyPdf/
- https://pypi.org/project/PyPDF2/
- https://mstamy2.github.io/PyPDF2/
- http://pybrary.net/pyPdf/


### PDF to JPG:
- https://github.com/pankajr141/pdf2jpg
- convert myfile.pdf myfile.png
- magick myfile.pdf myfile.png
- pdfimages my-file.pdf prefix 
- pdftoppm input.pdf outputname -png    ----> imagemagick den daha kaliteli. pdftoppm is much faster than convert
- pdftk document.pdf cat 12 output - | convert - document-page-12.png


### PDF Poster Yapma:
- https://gitlab.com/pdftools/pdfposter
- https://pdfposter.readthedocs.io/en/stable/index.html


### Linux'daki PDF Yazılımları:
- https://en.wikipedia.org/wiki/List_of_PDF_software#Linux_and_Unix
- https://manpages.ubuntu.com/manpages/bionic/man1/pdftocairo.1.html
- https://www.mankier.com/1/pdftocairo
- https://github.com/DavidFirth/pdfjam
- https://poppler.freedesktop.org/
- http://qpdf.sourceforge.net/  -- MUTLAKA İNCELENMELİ!
