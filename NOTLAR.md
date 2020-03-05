##  TODO
- Parola korumalı dosyalar
- Dosyaya parola koyma
- Yazdırma engeli koyma
- Dosyayadan parola kaldırma
- PDF Dosya tamir etme  pdftk broken.pdf output fixed.pdf
- Uncompress PDF page streams for editing the PDF in a text editor (e.g., vim, emacs) pdftk doc.pdf output doc.unc.pdf uncompress
- pdfcrop --margins "-15 -50 0 -140" extracted_page.pdf

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
 


## Faydalı Kaynaklar
- https://www.pdflabs.com/docs/pdftk-man-page/
- https://net2.com/how-to-install-and-use-pdftk-on-linux-to-merge-or-split-pdf-files/
- https://askubuntu.com/questions/1028522/how-can-i-install-pdftk-in-ubuntu-18-04-and-later


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


